配列を使用して、selectメニューのoptionを作成
<?php

$sweets = array('Sesami Seed Puff', 'Coconut Milk Gelatin Square', 'Brown Suger Cake', 'Sweet Rice and Meat');

function generate_option($options) {
  // 初期化
  $html = '';
  // 選択肢の要素数分、<option>を作成
  foreach ($options as $option) {
    $html .= "<option>$option</option>\n";
  }
  return $html;
}

// フォームの表示
function show_form() {
  // $sweetsに<option>に入れたグローバルの$sweetsを代入
  $sweets = generate_option($GLOBALS['sweets']);
  print<<<_HTML_
<form method="post" action="{$_SERVER['PHP_SELF']}">
Your Order: <select name="order">
$sweets
</select>
<br>
<input type="submit" value="Order">
</form>
_HTML_;
}
?>

validate。選択されているか、選択肢にない内容が入力されていないかチェック
<?php
$input['order'] = $_POST['order'];
if (! in_array($input['order'], $GLOBALS['sweets'])) {
  $errors[] = '選択してください';
}
?>