データベースから取得・照合
<?php
function validate_form() {
  global $db;
  $input = array();
  $errors = array();

  $password_ok = false;
  $input['username'] = $_POST['username'] ?? '';
  $submitted_password = $_POST['password'] ?? '';

  $stmt = $db->prepare('SELECT password FROM users WHER username = ?');
  $stmt->execute($input['username']); // inputしたusernameで取り出し
  $row = $stmt->fetch();

  if ($row) { // usernameが一致していれば取れてる
    $password_ok = password_verify($submitted_password, $row[0]); // 比較
  }
  if (! $password_ok) { // 一致しているでなければ
    $errors[] = '正確なusernameとpasswordを入力してください';
  }
  return array($errors, $input);
}
?>