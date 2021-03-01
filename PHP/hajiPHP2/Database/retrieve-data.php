<?php
require 'FormHelper.php';

try {
  $db = new PDO('sqlite:/temp/restaurand.db');
} catch (PDOException $e) {
  print "Can't connect: ".$e->getMessage();
  exit();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

$spicy_choices = array('no', 'yes', 'either');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors, $input) = validate_form(); // バリデーション実行
  if ($errors) {
    show_form($errors); // フォーム表示
  } else {
    process_form($input); // 結果表示
  }
} else {
  show_form(); // フォーム表示
}

function show_form($errors = array()) {
  $defaults = array('min_price' => '5.00', 'max_price' => '25.00');
  $form = new FormHelper($defaults);
  include 'retrieve-form.php'; // ここが謎
}

function validate_form() {
  $input = array();
  $errors = array();

  $input['dish_name'] = trim($_POST['dish_name'] ?? '');

  $input['min_price'] = filter_input(INPUT_POST, 'min_price', FILTER_VALIDATE_FLOAT);
  if ($input['min_price'] === null || $input['min_price'] === false) {
    $errors[] = 'Please enter a minimum price.';
  }
  $input['max_price'] = filter_input(INPUT_POST, 'max_price', FILTER_VALIDATE_FLOAT);
  if ($input['max_price'] === null || $input['max_price'] === false) {
    $errors[] = 'Please enter a maximum price.';
  }
  if ($input['min_price'] >= $input['max_price']) {
    $errors[] = 'The minimum price must be less than the maximum price.';
  }

  $input['is_spicy'] = $_POST['is_spicy'] ?? 'no';
  if (! array_key_exists($input['is_spicy'], $GLOBALS['spicy_choices'])) {
    $errors[] = 'Please Choose a valid "spicy" option.';
  }

  return array($errors, $input);
}

function process_form($input) {
  global $db;

  $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE price >= ? AND price <= ?'; // メニュー名検索があるとき下で追加
  if($input['is_spicy'] == 'yes') {
    $is_spicy = 1;
  } else {
    $is_spicy = 0;
  }

  if (strlen($input['dish_name'])) {
    $dish = $db->quote($input['dish_name']);
    $dish = strtr($dish, array('_' => '\_', '%' => '\%'));
    $sql .= " AND dish_name LIKE $dish";
  }

  $spicy_choice = $GLOBALS['spicy_choices'][$input['is_spicy']];
  if ($spicy_choice == 'yes') {
    $sql .= 'AND is_spicy = 1';
  } else if ($spicy_choice == 'no') {
    $sql .= 'AND is_spicy = 0';
  }
  
  $stmt = $db->prepare($sql);
  $stmt->execute(array($input['min_price'], $input['max_price']));
  $dishes = $stmt->fetchAll();

  if(count($dishes) == 0) {
    print 'No dishes matched.';
  } else {
    print '<table>';
    print '<tr><th>Dish Name</th><th>Price</th><th>Spicy?</th></tr>';
    foreach ($dishes as $dish) {
      if ($dish->is_spicy == 1) {
        $spicy = 'Yes';
      } else {
        $spicy = 'No';
      }
      printf(
        '<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
        htmlentities($dish->dish_name), $dish->price, $spicy
      );
    }
  }
}
?>