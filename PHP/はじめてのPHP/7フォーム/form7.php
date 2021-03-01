validationしつつ、エラーとインプットをそれぞれ配列に入れる
<?php

function validate_form() {
  $errors = array();
  $input = array();

  // filter_input() 正しい→値, 誤り→false, 入力なし→null
  $input['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
  if (is_null($input['age']) || ($input['age'] === false)) {
    $errors[] = '年齢は整数で入力してください';
  }
  $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
  if (is_null($input['price']) || ($input['price'] === false)) {
    $errors[] = '価格は小数で入力してください';
  }
  // 必須項目
  $input['name'] = trim($_POST['name'] ?? ''); // nullの対応含め準備
  if (strlen($_POST['name']) == 0) {
    $errors[] = '名前をを入力してください';
  }
  // array(配列, 配列) なので array([1, 2, 3], [$a, $b, $c] のようなこと)
  return array($errors, $input);
}

?>

validate_form()の戻り値 array($errors, $input) をlist()で受け取る 
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($form_errors, $input) = validate_form(); // array($errors, $input)
  // エラーがあればフォームとエラー表示、なければ結果表示
  if ($form_errors) {
    show_form($form_errors);
  } else {
    // $_POSTのままじゃなくフィルタリング後の配列をつくる。ていねい。
    process_form($input);
  }
} else {
  show_form();
}

?>