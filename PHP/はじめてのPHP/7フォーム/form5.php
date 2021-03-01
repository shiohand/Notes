フォームデータの検証　form4+エラーメッセージ
<?php

// 入力前と入力後のどちらを表示するか選択
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // validate_form()から戻り値が入る → true → エラーあり
  if ($form_errors = validate_form()) {
    show_form($form_errors);
  } else {
    // validate_form()から戻り値がらない → false → エラーなし
    process_form();
  }
} else {
  show_form();
}

// 入力後画面
function process_form() {
  print "Hello, {$_POST['my_name']}";
}

// 入力前画面 ($errorsでエラー受け取り機能)
function show_form($errors = '') {
  // エラーがあるとき表示
  if ($errors) {
    print 'データが正しくありません:';
    print '<ul><li>';
    print implode('</li><li>', $errors);
    print '</li></ul>';
  }

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
  $errors = array();
  // my_nameは3文字未満ならfalse
  if (strlen($_POST['my_name']) < 3) {
    $errors[] = '3文字以上の名前にしてください';
  }
  return $errors;
}

?>