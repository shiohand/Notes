<?php
require_once '../DbManager.php';

try {
  $db = getDb();

  // INSERT文 :○○はプレースホルダ
  $stt = $db->prepare('INSERT INTO book(isbn, title, price, publish, published) VALUES(:isbn, :title, :price, :publish, :published)');
  // 受け取った値で代入
  $stt->bindValue(':isbn', $_POST['isbn']);
  $stt->bindValue(':title', $_POST['title']);
  $stt->bindValue(':price', $_POST['price']);
  $stt->bindValue(':publish', $_POST['publish']);
  $stt->bindValue(':published', $_POST['published']);
  // 実行
  $stt->execute();
  // リダイレクト
  header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/insert_form.php');
} catch (PDOException $e) {
  print "エラーメッセージ：{$e->getMessage()}";
}
?>