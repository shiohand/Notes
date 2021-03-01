<?php
require_once '../DbManager.php';

// $_FILESの内容
//   name, type, size, tmp_name, error
//   typeはコンテンツタイプ, tmp_nameはtmpファイル名

try {
  $db = getDb();
  $stt = $db->prepare('INSERT INTO photo(type, data) VALUES(:type, :data)');
  // アップロードファイルをセット
  $file = fopen($_FILES['photo']['tmp_name'], 'rb');
  $stt->bindValue(':type', $_FILES['photo']['type'], PDO::PARAM_STR); // STR選択
  $stt->bindValue(':data', $file, PDO::PARAM_LOB);
  $stt->execute();
} catch (PDOException $e) {
  print "エラーメッセージ：{$e->getMessage()}";
}
?>