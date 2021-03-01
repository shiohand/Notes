<?php
try {
  $db = new PDO('sqlite:/temp/restaurant.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  print $e->getMessage();
}

$q = $db->exec("CREATE TABLE dishes (
  dish_id INT,
  dish_name VARCHAR(255),
  price DICIMAL(4, 2),
  is_spicy INT
  )");

$result = $db->exec("INSET INTO dishes (dish_name, price, is_spicy) VALUES ('Sesame Seed Puff', 2.50, 0)");
// if ($result === false) {
//   $error = $db->errorInfo();
//   print "SQL Error={$error[0]}, DB Error={$error[1]}, Message={$error[2]}\n";
// }

$db->exec("UPDATE dishes SET is_spicy = 1 WHERE dish_name = 'Eggplant with Chili Sauce'");

if ($make_things_cheaper) {
  $db->exec("DELETE FROM dishes WHERE price > 19.95");
} else {
  $db->exec("DELETE FROM dishes");
}

$stmt = $db->prepare("INSET INTO dishes (dish_name, price, is_spicy) VALUES (?, ?, ?)");
$stmt->execute(array($_POST['new_dish_name'], $_POST['new_price'], $_POST['is_spicy']));

$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch()) {
  print "{$row['dish_name']}, {$row['price']} \n";
}
$q = $db->query('SELECT dish_name, price FROM dishes');
$rows = $q->fetchAll();
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch(PDO::FETCH_NUM)) {
  print implode(',', $row)."\n";
}
$q = $db->query('SELECT dish_name, price FROM dishes');
$q->setFetchMode(PDO::FETCH_OBJ);
while($row = $q->fetch()) {
  print "{$row->dish_name} has price {$row->price} \n";
}

// $stmt = $db->prepare('SELECT dish_name, price FROM dishes WHERE dish_name LIKE ?');
// $stmt->execute(array($_POST['dish_search']));
// while ($row = $stmt->fetch()) {
//   // 処理;
// }
$dish = $db->quote($_POST['dish_search']);
$dish = strtr($dish, array('_' => '\_', '%' => '\%'));
$stmt = $db->query("SELECT dish_name, price FROM dishes WHERE dish_name LIKE $dish"); // バックスラッシュが被って面倒なのでプレースホルダは使えない
?>