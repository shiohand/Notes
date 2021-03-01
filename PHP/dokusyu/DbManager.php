<?php
function getDb() {
  $dsn = 'mysql:dbname=selfphp; host=127.0.0.1; charset=utf8';
  $usr = 'selfusr';
  $pw = 'selfpass';

  $db = new PDO($dsn, $usr, $pw);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 例外モード
  return $db;
}
?>