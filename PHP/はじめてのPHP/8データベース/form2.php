<?php

// データベースを検索する

require 'FormHelper.php';

try {
  $db = new PDO('sqlite:/tmp/restaurant.db');
} catch (PDOException $e) {
  print "接続できませんでした: ".$e->getMessage();
  exit();
}

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

// spicyの選択肢
$spicy_choices = array('no', 'yes', 'either');

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

// フォーム表示
function show_form($errors = array()) {
  $defaults = array('min_price' => '5.00', 'max_price' => '25.00');
  $form = new FormHelper($defaults);
  include 'retrieve-form.php';
}

function validate_form() {
  $input = array();
  $errors = array();

  $input['dish_name'] = trim($_POST['dish_name'] ?? '');

  $input['min_price'] = filter_input(INPUT_POST, 'min_price', FILTER_VALIDATE_FLOAT);
  if ($input['min_price'] === null || $input['min_price'] === false) {
    $errors[] = '最低価格が無効です';
  }
  $input['max_price'] = filter_input(INPUT_POST, 'max_price', FILTER_VALIDATE_FLOAT);
  if ($input['max_price'] === null || $input['max_price'] === false) {
    $errors[] = '最高価格が無効です';
  }

  $input['is_spicy'] = $_POST['is_spicy'] ?? '';
  if (! array_key_exists($input['is_spicy'], $GLOBALS['spicy_choice'])) {
    $errors[] = 'spicyオプションを選択してください';
  }
  return array($errors, $input);
}

// 結果表示
function process_form($input) {
  global $db; // $dbのひきこみ

  // クエリ用意
  // 価格指定用意
  $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE price >= ? AND price <= ?';

  // 名前指定
  if($input['dish_name']) {
    $dish = $db->quote($input['dish_name']);
    $dish = strtr($dish, array('_' => '\_', '%' => '\%'));
    $sql .= " AND dish_name LIKE $dish";
  }

  // is_spicy指定
  // 'either'のときは何も加えない
  $spicy_choice = $GLOBALS['spicy_choices'][$input['is_spicy']];
  if ($spicy_choice = 'yes') {
    $sql .= ' AND is_spicy = 1';
  } elseif ($spicy_choice == 'no') {
    $sql .= ' AND is_spicy = 0';
  }

  $stmt = $db->prepare($sql);
  // プレースホルダに代入
  $stmt->execute(array($input['min_price'], $input['max_price']));
  $dishes = $stmt->fetchAll();

  if (count($dishes) == 0) {
    print '見つかりませんでした';
  } else {
    print '<table>';
    // 見出し行
    print '<tr><th>Dish Name</th><th>Price</th><th>Spicy?</th></tr>';
    foreach ($dishes as $dish) {
      if ($dish->is_spicy == 1) {
        $spicy = 'Yes';
      } else {
        $spicy = 'No';
      }
      // データ行
      printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>', htmlentities($dish->dish_name), $dish->price, $spicy);
    }
  }
}
?>