整数範囲のチェック
<?php

$input['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 18, 'max_range' => 65))
);
if (is_null($input['age']) || ($input['age'] === false)) {
  $errors[] = '年齢は18歳から65歳の間の整数で入力してください';
}

// 手動の文字数制限(FLOATも7.4からオプション追加されたが)
$input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
if (is_null($input['price']) || ($input['price'] === false) ||
  ($input['price'] < 10.00) || ($input['price'] > 50.00)) { // minmax追加
  $errors[] = '値段は$10から$50の間の小数で入力してください';
}

?>
<?php

// 日付範囲のチェック(INT)

$range_start = new DateTime('6 mnths ago'); // 現在から6ヶ月前
$range_end = new DateTime(); // 現在

// 1900 - 2100 , 1 - 12 , 1 - 31
$_POST['year'] = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 1900, 'max_range' => 2100)));
$_POST['month'] = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 1, 'max_range' => 12)));
$_POST['day'] = filter_input(INPUT_POST, 'day', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 1, 'max_range' => 31)));

?>