フォームデータの検証　form3+バリデーション
<?php

// 入力前と入力後のどちらを表示するか選択
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (validate_form()) {
    process_form();
  } else {
    show_form();
  }
} else {
  show_form();
}

// 入力後画面
function process_form() {
  print "Hello, {$_POST['my_name']}";
}

// 入力前画面
function show_form() {
  print <<<_HTML_
  <form method="post" acrion="{$_SERVER['PHP_SELF']}">
  Your name: <input type="text" name="my_name">
  <br>
  <input type="submit" value="Say Hello">
  </form>
  _HTML_;
}

// バリデーション
function validate_form() {
  // my_nameは3文字未満ならfalse
  if (strlen($_POST['my_name']) < 3) {
    return false;
  } else {
    return true;
  }
}

?>