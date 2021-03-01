<?php
class FormHelper {
  protected $values = array();

  public function __construct($values = array()) {
    if ($_SERVER['REQUEST_METHOD' == 'POST']) {
      $this->values = $_POST;
    } else {
      $this->values = $values; // default
    }
  }

  // input作成機
  public function input($type, $attributes = array(), $isMultiple = false) {
    $attributes['type'] = $type; // $attributesに集約
    if (($type == 'radio') || ($type == 'checkbox')) {
      if($this->isOptionSelected($attributes['name'] ?? null, $attributes['value'] ?? null)) {
        // isOptionSelectedがtrueなら
        $attributes['checked'] = true; // checked追加
      }
    }
    return $this->tag('input', $attributes, $isMultiple); // tag生成
  }
  // select作成機
  public function select($options, $attributes = array()) {
    $multiple = $attributes['multiple'] ?? false;
    return
      $this->start('select', $attributes, $multiple).
      $this->options($attributes['name'] ?? null, $options).
      $this->end('select');
  }

  // textarea作成機
  public function textarea($attributes = array()) {
    $name = $attributes['name'] ?? null;
    $value = $this->values[$name] ?? '';
    return
      $this->start('textarea', $attributes).
      htmlentities($value).
      $this->end('textarea');
  }

  // tag(閉じタグ不要)出力機
  public function tag($tag, $attributes = array(), $isMultiple = false) {
    return "<$tag {$this->attributes($attributes, $isMultiple)} />";
  }
  // tag(開始タグ閉じタグ別)出力機
  public function start($tag, $attributes = array(), $isMultiple = false) {
    $valueAttribute = (! (($tag == 'select') || ($tag == 'textarea'))); // selectかtextareaならfalse
    $attrs = $this->attributes($attributes, $isMultiple, $valueAttribute);
    return "<$tag $attrs>"; // $attrsは完成済み
  }
  public function end($tag) {
    return "</$tag>";
  }

  // attr連結生成機
  protected function attributes($attributes, $isMultiple, $valueAttribute = true) {
    $temp = array();
    // attrがオンで、 nameが分かっていて、 valuesのキーにあれば
    if ($valueAttribute && isset($attributes['name']) && array_key_exists($attributes['name'], $this->values)) {
      $attributes['value'] = $this->values[$attributes['name']]; // 該当の値を追加
    }
    foreach ($attributes as $k => $v) {
      if (is_bool($v)) { // 値がないグループ(checkedなど)
        if ($v) {
          $temp[] = $this->encode($k);
        } else {
          $value = $this->encode($v);
          if ($isMultiple && $k == 'name') { // multipleのときはnameに[]
            $value .= '[]';
          }
          $temp[] = "$k=\"$value\""; // いっこかんせい
        }
      }
    }
    // 全部できたら
    return implode(' ', $temp);
  }

  // option生成機
  protected function options($name, $options) {
    $temp = array();
    foreach ($options as $k => $v) {
      $s = "<option value=\"{$this->encode($k)}\"";
      if ($this->isOptionSelected($name, $k)) {
        $s .= ' selected';
      }
      $s .= ">{$this->encode($v)}</option>";
      $temp[] = $s;
    }
    return implode('', $temp);
  }

  // checked判定機
  public function isOptionSelected($name, $value) {
    if (! isset($this->values[$name])) { // 該当のinputがなければ
      return false;
    } else if (is_array($this->values[$name])) { // 配列なら(じゃないならcheckedいらない)
      return in_array($value, $this->values[$name]); // valuesの値と一致していればtrue
    }
  }

  // サニタイジング
  public function encode($s) {
    return htmlentities($s);
  }
}
?>