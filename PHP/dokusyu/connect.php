<?php
require_once './DbManager.php';
if($db = getDb()) {
  print '接続に成功しました。';
}
?>