<?php
require_once '../../dokusyu/DbManager.php';

// $v = new MyValidator();
// $v->必要なチェック();
// $v();
// のようにしてエラーを検出・出力する

class MyValidator {
  // プライベート変数
  private $errors;

  // コンストラクタ
  public function __construct(string $encoding = 'UTF-8') {
    // $errors初期化
    $errors = [];
    // 内部文字コード設定
    mb_internal_encoding($encoding);
    // 全ての入力に共通するチェック
    // 文字コード, nullバイトチェック
    $this->checkEncoding($_GET);
    $this->checkEncoding($_POST);
    $this->checkEncoding($_COOKIE);
    $this->checkNull($_GET);
    $this->checkNull($_POST);
    $this->checkNull($_COOKIE);
  }

  // 文字コードチェック
  private function checkEncoding(array $data) {
    foreach ($data as $key => $value) {
      if (!mb_check_encoding($value)) {
        $this->errors[] = "{$key}は不正な文字コードです。";
      }
    }
  }
  // nullバイトチェック
  private function checkNull(array $data) {
    foreach ($data as $key => $value) {
      if (preg_match('/\0/',$value)) { // \0 null
        $this->errors[] = "{$key}は不正な文字を含んでいます。";
      }
    }
  }
  // 入力漏れ検証
  public function requiredCheck(string $value, string $name) {
    if (trim($value) === '') {
      $this->errors[] = "{$name}は入力必須です。";
    }
  }
  // 文字数検証
  public function lengthCheck(string $value, string $name, int $len) {
    if (trim($value) !== '') {
      if (mb_strlen($value) > $len) {
      $this->errors[] = "{$name}は{$len}文字以内で入力してください。";
      }
    }
  }
  // 整数型検証
  public function intTypeCheck(string $value, string $name) {
    if (trim($value) !== '') {
      if (!ctype_digit($value)) { // ctype_digit() 文字列が数字のみかのチェック 数値はASCIIと思われるのでだめ
        $this->errors[] = "{$name}は整数で指定してください。";
      }
    }
  }
  // 数値範囲検証
  public function rangeCheck(string $value, string $name, float $max, float $min) {
    if (trim($value) !== '') {
      if ($value > $max || $value < $min) {
        $this->errors[] = "{$name}は{$max}～{$min}で指定してください。";
      }
    }
  }
  // 日付型検証
  public function dateTypeCheck(string $value, string $name) {
    if (trim($value) !== '') {
      $res = preg_split('|([/\-])|', $value); // 区切り文字でsplit
      if (count($res) !== 3 || !@checkdate($res[1], $res[2], $res[0])) {
        $this->errors[] = "{$name}は日付形式で入力してください";
      }
    }
  }
  // 正規表現パターン検証
  public function regexCheck(string $value, string $name, string $pattern) {
    if (trim($value) !== '') {
      if (!preg_match($pattern, $value)) {
        $this->errors[] = "{$name}は正しい形式で入力してください。";
      }
    }
  }
  // 配列要素検証
  public function inArrayCheck(string $value, string $name, array $opts) {
    if (trim($value) !== '') {
      if (!in_array($value, $opts)) {
        $tmp = implode(',', $opts);
        $this->errors[] = "{$name}は{$tmp}の中から選択してください。";
      }
    }
  }
  // 重複検証
  public function duplicateCheck(string $value, string $name, string $sql) {
    try {
      $db = getDb();
      $stt = $db->prepare($sql);
      $stt->bindValue(':value', $value);
      $stt->execute();
      if (($row = $stt->fetch()) !== false) {
        $this->errors[] = "{$name}は重複しています。";
      }
    } catch (PDOException $e) {
      $this->errors[] = $e->getMessage();
    }
  }
  // $errorsに値がある場合は表示
  public function __invoke() {
    if (count($this->errors) > 0) {
      print '<ul style="Red">';
      foreach ($this->errors as $err) {
        print "<li>{$err}</li>";
      }
      print '</ul>';
      die();
    }
  }
}

?>