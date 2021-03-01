PDOオブジェクトを使ってDBに接続

$db = new PDO('{DSN接頭辞}:{DSNオプション}', '{ユーザ名}', '{パスワード}');
MySQLの例) $db = new PDO('mysql:host=db.example.com;dbname=restaurant', 'penguin', 'top^hat;');

データベースへ接続
<?php
try {
  $db = new PDO('mysql:host=db.example.com;dbname=restaurant', 'penguin', 'top^hat;');
  // 処理処理;
} catch (PDOException $e) {
  print '接続に失敗しました: '.$e->getMessage();
}
?>

データベースの変更
exec() SQLコマンドを送る 戻り値は追加・変更のあった行数 失敗のときはfalse
  直接条件式として使うのは、0を返す場合があるのでだめ多分。
setAttribute() エラーの扱いの設定 後述
<?php
try {
  $db = new PDO('mysql:host=db.example.com;dbname=restaurant', 'penguin', 'top^hat;');
  // 処理処理;
} catch (PDOException $e) {
  print '接続に失敗しました: '.$e->getMessage();
}
try {
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // CREATE TABLE
  $q = $db->exec(
    "CREATE TABLE dishes (
    dish_id INTEGER PRIMARY KEY,
    dish_name VARCHAR(255),
    price DECIMAL(4, 2),
    is_spicy INT"
  );
  // DROP TABLE
  $q = $db->exec(
    "DROP TABLE dishes"
  );
  // INSERT
  $db->exec(
    "INSERT INTO dishes (dish_name, price, is_spicy)
    VALUES ('Sesame Seed Puff', 2.50, 0)"
  );
  // UPDATE
  $db->exec(
    "UPDATE dishes SET is_spicy = 1
    WHERE dish_name = 'Eggplant with Chili Sauce'"
  );
  // DELETE
  $db->exec(
    "DELETE FROM dishes WHERE price > 19.95"
  );
} catch (PDOException $e) {
  print '接続できませんでした: '.$e->getMessage();
}
?>

プリペアステートメント PDOの機能を利用したサニタイジング(fetch()についてはdb2.php)
INSERTでVALUESにユーザの入力値を挿入する場合
prepare(SQL文)
  VALUES以外の部分を用意 挿入する部分にプレースホルダとして'?'。
execute(array)
  挿入する値。配列で渡す。
<?php
// ステートメントにセット
$stmt = $db->prepare('INSERT INTO dishes (dish_name) VALUES (?)');
$stmt->execute(array($_POST['new_dish_name']));
// 複数のプレースホルダ
$stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?,?,?)');
$stmt->execute(array($_POST['new_dish_name'], $_POST['new_price'], $_POST['is_spicy']));
?>
<?php

?>
<?php
?>

PDOのエラーモード
例外エラーモード
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  デバッグに最適 エラー内容を探してくれる 例外処理を行わなければプログラムは停止
サイレントエラーモード
  // デフォルト
  例外は発行せずに黙って失敗する
警告エラーモード
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  黙って失敗する PHPエンジンに警告を発する つまり？

errorInfo()
  エラー情報を含む3要素の配列 [0]一般エラー [1]使用中のデータベース固有のエラー [2]エラーメッセージ

<?php
try {
  $db = new PDO('sqlite:/tmp/restaurant.db');
} catch (PDOException $e) {
  print '接続できませんでした: '.$e->getMessage();
}
// エラーモードは変更しない
// 戻り地を受け取る
$result = $db->exec(
  "INSERT INTO dishes (dish_size, dish_name, price, is_spicy)
  VALUES ('large', 'Sesame Seed Puff', 2.50, 0)"
);
if ($result === 'false') {
  $error = $db->errorInfo();
  print 'insertできませんでした';
  print "\n";
  print "SQL Error={$error[0]}, DB Error={$error[1]}, Message={$error[2]}";
}
?>
