validation
<?php

// 必須項目
if (strlen($_POST['email']) == 0) {
  $errors[] = 'メールアドレスを入力してください';
}
// trimつき
if (strlen(trim($_POST['my_name'])) < 3) {
  $errors[] = '3文字以上の名前にしてください';
}

// 整数・小数チェック
// filter_input(調べるもの, 調べるフィールド(name), 調べるルール)
// 正しい→値, 誤り→false, 入力なし→null
$ok = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
// nullだったら、またはfalseだったら
if (is_null($ok) || ($ok === false)) {
  $errors[] = '年齢は整数で入力してください';
}
$ok = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
if (is_null($ok) || ($ok === false)) {
  $errors[] = '価格は小数で入力してください';
}

?>