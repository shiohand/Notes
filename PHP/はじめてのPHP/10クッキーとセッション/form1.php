フォームデータをセッションへ保存
<?php
require '../tstform/FormHelper.php';
session_start();

$main_dishes = array(
  'cuke' => 'Braised Sea Cucumber',
  'stomach' => 'Sauteed Pig\'s Stomach',
  'tripe' => 'Sauteed Tripe with Wine Sauce',
  'taro' => 'Stewed Pork wigh Taro',
  'giblets' => 'Baked Giblets with Salt',
  'abalone' => 'Abalone with Marrow and Duck Feet'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors, $input) = validate_form();
  if ($errors) {
    show_form($errors);
  } else {
    process_form($input);
  }
} else {
  show_form();
}

function show_form($errors = array()) {
  $form = new FormHelper();

  if ($errors) {
    $errorHtml = '<ul><li>';
    $errorHtml .= implode('</li><li>', $errors);
    $errorHtml .= '</li</ul>';
  } else {
    $errorHtml = '';
  }

  print <<<_FORM_
  <form method="POST" action="{$form->encode($_SERVER['PHP_SELF'])}">
    $errorHtml
    Dish: {$form->select($GLOBALS['main_dishes'], ['name' => 'dish'])} <br>
    Quantity: {$form->input('text', ['name' => 'quantity'])} <br>
    {$form->input('submit', ['value' => 'Order'])}
  </form>
  _FORM_;
}

function validate_form() {
  $input = array();
  $errors = array();

  $input['dish'] = $_POST['dish'] ?? '';
  if (! array_key_exists($input['dish'], $GLOBALS['main_dishes'])) {
    $errors[] = '料理を選択してください';
  }
  
  $input['quantity'] = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
  if (($input['quantity'] === false) || ($input['quantity'] === null)) {
    $errors[] = 'サイズを入力してください';
  }

  return array($errors, $input);
}

function process_form($input) {
  // $_SESSION['order']に、正しいinputを追加する
  $_SESSION['order'][] = array('dish' => $input['dish'], 'quantity' => $input['quantity']);

  print 'ご注文ありがとうございます';
}
?>

保存されているセッションデータの出力
<?php
session_start();
if(isset($_SESSION['order']) && (count($_SESSION['order']) > 0)) {
  print '<ul>';
  foreach ($_SESSION['order'] as $order) {
    $dish_name = $main_dishes[$order['dish']];
    print "<li> {$order['quantity']} of $dish_name </li>";
  }
  print '</ul>';
} else {
  print '注文されていません';
}
?>