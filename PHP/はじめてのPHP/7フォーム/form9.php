validate。日付範囲のチェック(INT)<br>
6ヶ月前以前と未来の時刻の入力をチェック
<?php

$range_start = new DateTime('6 months ago'); // 現在から6ヶ月前
$range_end = new DateTime(); // 現在

// 1900 - 2100 , 1 - 12 , 1 - 31
$input['year'] = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 1900, 'max_range' => 2100)));
$input['month'] = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 1, 'max_range' => 12)));
$input['day'] = filter_input(INPUT_POST, 'day', FILTER_VALIDATE_INT,
  array('options' => array('min_range' => 1, 'max_range' => 31)));

// 日付として有効か(2月30日などがないか)
if ($input['year'] && $input['month'] && $input['day'] &&
  checkdate($input['month'], $input['day'], $input['year'])) {
  $submitted_date = new DateTime(strtotime($input['year'].'-'.$input['month'].'-'.$input['day']));
  // 且つ、期間のチェック
  if ($range_start > $submitted_date || $range_end < $submitted_date) {
    $errors[] = '6ヶ月以内の日付を入力してください';
  }
} else {
  // 有効な日付でない場合
  $errors[] = '無効な日時です';
}
?>
メールアドレスのチェック
<?php

$input['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (! $input['email']) {
  $errors[] = '無効なメールアドレスです';
}

?>