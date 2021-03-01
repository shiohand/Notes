<?php
// FormHelperと連携
require 'FormHelper.php';

// メニュー要素
$sweets = array(
  'puff' => 'Sesami Seed Puff',
  'square' => 'Coconut Milk Gelatin Square',
  'cake' => 'Brown Suger Cake',
  'ricemeat' => 'Sweet Rice and Meat'
);

$main_dishes = array(
  'cuke' => 'Braised Sea Cucumber',
  'stomach' => 'Sauteed Pig\'s Stomach',
  'tripe' => 'Sauteed Tripe with Wine Sauce',
  'taro' => 'Stewed Pork wigh Taro',
  'giblets' => 'Baked Giblets with Salt',
  'abalone' => 'Abalone with Marrow and Duck Feet'
);

// メインページのロジック
// フォームと結果のどれを表示するか
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors, $input) = validate_form(); // validate_form()の利用
  if ($errors) {
    show_form($errors);
  } else {
    process_form($input);
  }
} else {
  show_form();
}

// フォーム表示（FormHelper任せ）
function show_form($errors = array()) {
  $defaults = array('delivery' => 'yes', 'size' => 'medium');
  $form = new FormHelper($defaults);
  include 'complete-form.php';
}

// バリデーションチェック兼trim()などのゴミ取り
function validate_form() {
  $input = array();
  $error = array();

  // name
  $input['name'] = trim($_POST['name'] ?? '');
  // !(入力値がある)
  if (! strlen($input['name'])) {
    $errors[] = 'nameを入力してください';
  }
  // size
  $input['size'] = $_POST['size'] ?? '';
  // !(入力値がどれかである)
  if (! in_array($input['size'], ['small', 'medium', 'large'])) { 
    $errors[] = 'sizeを選んで';
  }
  // sweet
  $input['sweet'] = $_POST['sweet'] ?? '';
  // !(入力値が選択肢に含まれている)
  if(! array_key_exists($input['sweet'], $GLOBALS['sweets'])) {
    $errors[] = 'sweetを選んでください';
  }
  // main_dish
  $input['main_dish'] = $_POST['main_dish'] ?? array();
  // main_dishが2つ入力されていない
  if (count($input['main_dish']) != 2) {
    $errors[] = 'main_dishを2つ選んでください';
  } else {
    // !(どちらも選択肢に含まれている)
    if (! (array_key_exists($input['main_dish'][0], $GLOBALS['main_dishes'])) && (array_key_exists($input['main_dish'][1], $GLOBALS['main_dishes']))) {
      $errors[] = 'main_dishを正しく入力してください';
    }
  }
  // delivery, comments
  $input['delivery'] = $_POST['delivery'] ?? 'no';
  $input['comments'] = trim($_POST['comments'] ?? '');
  // deliveryがyesだが住所が入力されていない
  if (($input['delivery'] == 'yes') && (! strlen($input['comments']))) {
    $errors[] = '配達先住所を入力してください';
  }
  return array($errors, $input);
}

// 入力結果の表示
function process_form($input) {
  // 表示用の文字列として受け取り
  $sweet = $GLOBALS['sweets'][$input['sweet']];
  $main_dish_1 = $GLOBALS['main_dishes'][$input['main_dish'][0]];
  $main_dish_2 = $GLOBALS['main_dishes'][$input['main_dish'][1]];
  if (isset($input['delivery']) && ($input['delivery'] == 'yes')) {
    $delivery = '希望する';
  } else {
    $delivery = '希望しない';
  }

  $message = <<<_ORDER_
{$input['name']}様、ご注文ありがとうございます。
注文内容: {$sweet}({$input['size']}), {$main_dish_1}, {$main_dish_2}, delivery($delivery)
_ORDER_;
  if (strlen(trim($input['comments']))) {
    $message .= 'コメント:'.$input['comments'];
  }
  // messageを必要なところへ転送
  // mail(アドレス, タイトル, 本文) メールを送信する そなえつけ
  mail('shef@restaurant.example.com', '新しい注文', $message);
  // n12br(文字列) 文字列中の改行を<br>に置換する そなえつけ
  print nl2br(htmlentities($message, ENT_HTML5));
}
?>