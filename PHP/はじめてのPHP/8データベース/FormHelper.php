<?php

class FormHelper {
  protected $values = array();

  // コンストラクタ $_POSTかデフォルト値の連想配列が入る
  public function __construct($values = array()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->values = $_POST;
    } else {
      $this->values = $values;
    }
  }
  
  // input用 $typeはtextとかradioとかsubmitとか 
  // $attributes はnameとかvalueとかのこと
  // $isMultipleは複数選択のやつ
  public function input($type, $attributes = array(), $isMultiple = false) {
    $attributes['type'] = $type;
    if (($type == 'radio') || ($type == 'checkbox')) {
      if ($this->isOptionSelected($attributes['name'] ?? null, $attributes['value'] ?? null)) {
        $attributes['checked'] = true;
      }
    }

    return $this->tag('input', $attributes, $isMultiple);
  }

  // select用 optionがあるのが他と違う
  public function select($options, $attributes = array()) {
    $multiple = $attributes['multiple'] ?? false; // 設定されてないならfalse

    return $this->start('select', $attributes, $multiple).
      // optionは別に設定
      $this->options($attributes['name'] ?? null, $options).
      $this->end('select');
  }

  // textarea用
  public function textarea($attributes = array()) {
    $name = $attributes['name'] ?? null; // attrを代入
    $value = $this->values[$name] ?? ''; // attrの値取り出し

    return $this->start('textarea', $attributes).htmlentities($value).$this->end('textarea');
  }

  // 自己終了タグ文字列 inputとかimgとかも
  public function tag($tag, $attributes = array(), $isMultiple = false) {
    return "<$tag {$this->attributes($attributes, $isMultiple)} />";
  }

  // 開始タグ文字列
  // $tag は作るタグの名前 $attributes はnameとかvalueとかのこと $isMultipleは複数選択のやつ
  public function start($tag, $attributes = array(), $isMultiple = false) {
    // selectかtextareaは例外なのでfalse
    $valueAttribute = (! (($tag == 'select') || ($tag == 'textarea')));
    // attributes() から 属性="" の部分を取得する
    $attrs = $this->attributes($attributes, $isMultiple, $valueAttribute);
    // 例：　<タグ 属性="" 属性="">
    return "<$tag $attrs>";
  }
  // 閉じタグ文字列
  public function end($tag) {
    return "</$tag>";
  }

  // tag(), start()共通 属性部分文字列
  protected function attributes($attributes, $isMultiple, $valueAttribute = true) {
    $tmp = array();
    // attrを指定。
    if (
      $valueAttribute && // start()より、selectかtextareaだったらfalse
      isset($attributes['name']) && // まず存在しなかったらfalse
      array_key_exists($attributes['name'], $this->values) // 大元になかったらfalse
      ) {
      $attributes['value'] = $this->values[$attributes['name']]; // attr部分を代入
    }
    // attr="値" を全部作って配列にまとめる
    foreach ($attributes as $k => $v) {
      if (is_bool($v)) { // attr の形のときは$vはただのbool checkedとか想定か？
        if ($v) { // 値部分がtrueのとき
          $tmp[] = $this->encode($k); // attr 完成
        }
      } else { // attr="値" の形
        // value attrの値
        $value = $this->encode($v);
        // multipleがtrueなら [] 追加
        if ($isMultiple && ($k == 'name')) {
          $value .= '[]';
        }
        $tmp[] .= "$k=\"$value\""; // attr="値" または attr="値[]" 完成
      }
    }
    // 連結
    return implode(' ', $tmp);
  }

  // selectのoption用
  // $name は selected追加用 $options は [value部分 => 表示文字列]
  // <option value="value部分">表示文字列</option>
  protected function options($name, $options) {
    $tmp = array();
    // <option value=" $k " selected> $v </option>
    foreach ($options as $k => $v) {
      $s = "<option value=\"{$this->encode($k)}\"";
      // 現在の $k をselectedにする必要があれば
      if ($this->isOptionSelected($name, $k)) {
        $s .= ' selected';
      }
      $s .= ">{$this->encode($v)}</option>";
      $temp[] = $s;
    }
    // 連結 optionを全部並べるだけ
    return implode('', $tmp);
  }

  // selected checked つけるかの判定を返す
  // $nameは $value は value=""部分
  protected function isOptionSelected($name, $value) {
    if (! isset($this->values[$name])) {
      // $nameがなければ(nullなら)
      return false;
    } elseif (is_array($this->values[$name])) {
      // $nameが配列なら$valueがあるか調べる
      return in_array($value, $this->values['name']);
    } else {
      // $nameは配列じゃないのでそれと比べるだけでよい
      return $value == $this->values[$name];
    }
  }

  // ただのhtmlentities()
  public function encode($s) {
    return htmlentities($s);
  }
}

?>