
$_SESSIONにキーが有る ＝ ログイン済み
<?php
if (array_key_exists('username', $_SESSION)) {
  print 'こんにちは、'.$_SESSION['username'].'さん';
} else {
  print 'こんにちは、ゲストさん';
}
?>
ログアウト
unset()するだけ
<?php
session_start();
unset($_SESSION['username']);
?>

パスワードのハッシュ化
password_hash(ハッシュ化したいパスワード)
  パスワードをハッシュ化した文字列に変換
password_verify(比べるパスワード(未ハッシュ化), 保存されているパスワード(既ハッシュ化))
  比べるパスワードをハッシュ化し、保存されているパスワードのハッシュと同値かを調べる
<?php

function validate_form() {
  $input = array();
  $errors = array();

  $users = array('alice' => 'ハッシュ化したやつ', 'bob' => 'ハッシュ化したやつ', 'charlie' => 'ハッシュ化したやつ');

  if (! array_key_exists($_POST['username'], $users)) {
    $errors[] = '正確なusernameとpasswordを入力してください';
  } else {
    $saved_password = $users[$input['username']]; // 取り出し
    $submitted_password = $_POST['password'] ?? '';
    if (! password_verify($submitted_password, $saved_password)) {
      $errors[] = '正確なusernameとpasswordを入力してください';
    }
  }
  return array($errors, $input);
}
?>
