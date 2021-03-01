<?php
require 'FormHelper.php';

try {
  $db = new PDO('sqlite:/temp/restaurant.db');
} catch (PDOException $e) {
  $e->getMessage();
  exit();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors, $input) = validate_form();
  if ($errors) {
    show_form($errors); // フォーム表示
  } else {
    process_form($input); // 結果表示
  }
} else {
  show_form(); // フォーム表示
}

function show_form($errors = array()) {
  $defaults = array('price' => '5.00');
  $form = new FormHelper($defaults);
  include 'insert-form.php';
}

function validate_form() {
  $input = array();
  $errors = array();

  $input['dish_name'] = trim($_POST['dish_name'] ?? '');
  if (! strlen($input['dish_name'])) {
    $errors[] = 'Please enter the name of the dish.';
  }
  $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT, array('options' => ['min_length' => 0]));
  if (! $input['price']) {
    $errors[] = 'Please enter a valid price.';
  }
  $input['is_spicy'] = $_POST['is_spicy'] ?? 'no';

  return array($errors, $input);
}

function process_form($input) {
  global $db;
  if($input['is_spicy'] == 'yes') {
    $is_spicy = 1;
  } else {
    $is_spicy = 0;
  }
  
  try {
    $stmt = $db->prepare('INSET INTO dishes (dish_name, price, is_spicy) VALUES (?, ?, ?)');
    $stmt->execute(array($input['dish_name'], $input['price'], $is_spicy));
    print 'Added '.htmlentities($input['dish_name']).' to the database.';
  } catch (PDOException $e) {
    print "Couldn't add your dish to the database.";
  }
}
?>