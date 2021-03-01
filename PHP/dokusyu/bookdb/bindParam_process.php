<?php
require_once '../DbManager.php';

try {
  $db = getDb();
  $stt = $db->prepare('UPDATE book SET title=:title, price=:price, publish=:publish, published=:published WHERE isbn=:isbn');
  // セット
  $stt->bindParam(':isbn', $isbn);
  $stt->bindParam(':title', $title);
  $stt->bindParam(':price', $price);
  $stt->bindParam(':publish', $publish);
  $stt->bindParam(':published', $published);
  // フォームからの入力値を順に取得、セット
  // インクリメントが活躍 $i=1から！
  for ($i=1; $i <= $_POST['cnt']; $i++) { 
    $isbn = $_POST['isbn'.$i];
    $title = $_POST['title'.$i];
    $price = $_POST['price'.$i];
    $publish = $_POST['publish'.$i];
    $published = $_POST['published'.$i];
    // execute
    $stt->execute();
  }
  // リダイレクト
  header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/bindParam_form.php');
} catch (PDOException $e) {
  "エラーメッセージ：{$e->getMessage()}";
}
?>