<?php

require 'FormHelper.php';

try {
  $db = new PDO('sqlite:/tmp/restaurant.db');
} catch (PDOException $e) {
  print "接続できませんでした: ".$e->getMessage();
  exit();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 表示選択
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
  $defaults = array('price' => '5.00');
  $form = new FormHelper($defaults);
  include 'insert-form.php';
}

function validate_form() {
  $input = array();
  $errors = array();

  $input['dish_name'] = trim($_POST['dish_name'] ?? '');
  if (! strlen($input['dish_name'])) {
    $errors[] = '料理名を選択してください';
  }

  $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
  if ($input['price'] <= 0) {
    $errors[] = '価格が無効です';
  }

  $input['is_spicy'] = $_POST['is_spicy'] ?? 'no';

  return array($errors, $input);
}

function process_form($input) {
  global $db; // $dbのひきこみ

  if($input['is_spicy'] == 'yes') {
    $is_spicy = 1;
  } else {
    $is_spicy = 0;
  }

  try {
    $stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?,?,?)');
    $stmt->execute(array($input['dish_name'], $input['price'], $input['is_spicy']));
    print 'データベースに '.htmlentities($input['dish_name']).' を追加しました';
  } catch (PDOException $e) {
    print '追加できませんでした';
  }
}
?>