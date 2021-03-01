----デフォルト値を代入
<?php
if ($_SERVER['REAUEST_METHOD'] == 'POST') {
  $defaults = $_POST;
} else {
  // POSTリクエストじゃないときはデフォルト値を代入する
  $defaults = array(
    'delivery' => 'yes',
    'size' => 'medium',
    'main_dish' => array('taro', 'tripe'),
    'sweet' => 'cake'
  );
}
?>

----input type="text" と textarea のデフォルト値代入
<?php
print '<input type="text" name="my_name" value="'.htmlentities($defaults['my_name']).'">';

print '<textarea name="comments">';
print htmlentities($defaults['comments']);
print '</textarea>';
?>

----selectのデフォルト値に selected追加
<?php
$sweets = array(
  'puff' => 'Sesami Seed Puff',
  'square' => 'Coconut Milk Gelatin Square',
  'cake' => 'Brown Suger Cake', // 今回のデフォルト
  'ricemeat' => 'Sweet Rice and Meat'
);

print '<select name="sweet">';
foreach ($sweets as $option => $label) {
  print '<option value="'.$option.'"'; // 普通のoption錬成
  if ($option == $defaults['sweet']) { // デフォルト値のときは＋' selected'
    print ' selected';
  }
  print "> $label</option>\n";
}
print '</select>';
?>

----select multiple の場合の selected追加
<?php
$main_dihses = array(
  'cuke' => 'Braised Sea Cucumber',
  'stomach' => 'Sauteed Pig\'s Stomach',
  'tripe' => 'Sauteed Tripe with Wine Sauce', // 今回のデフォルト
  'taro' => 'Stewed Pork with Taro',          // 今回のデフォルト
  'giblets' => 'Baked Giblets with Salt',
  'abalone' => 'Abalone with Marrow and Duck Feet'
);

// 複数の値を受け取るための配列型
print '<select name="main_dich[]" multiple>';

// $selected_optionsに ['デフォルト値'] = trueの作成
// デフォルト値 => true ができる
$selected_options = array(); // 空の配列
foreach ($defaults['main_dish'] as $option) { // arrayに何が入っているか
  $selected_options[$option] = true;
}

// <option>タグ出力
foreach ($main_dishes as $option => $label) {
  print '<option value="'.htmlentities($option).'"';
  // $selected_optionsのキーに同じのがあればdefault
  if (array_key_exists($option, $selected_options)) {
    print ' selected';
  }
  print '>'.htmlentities($label).'</option>';
  print "\n";
}
print '</select>';
?>

----checkbox(一つ以上), radio(一つ) の場合の checked追加
<?php

// <input type="checkbox" name="delivery" value="yes" checked> Delivery?
print '<input type="checkbox" name="delivery" value="yes"';
if ($defaults['delivery'] == 'yes') {
  print ' checked';
}
print '> Delivery?';

// 値の設定
$checkbox_options = array(
  'small' => 'Small',
  'medium' => 'Medium',
  'large' => 'Learge'
);

// <input type="radio" name="size" value=" $value " checked> $label 
foreach ($checkbox_options as $value => $label) {
  print '<input type="radio" name="size" value="'.$value.'"';
  if ($defaults['size'] == $value) {
    print ' checked';
  }
  print "> $label ";
}

?>