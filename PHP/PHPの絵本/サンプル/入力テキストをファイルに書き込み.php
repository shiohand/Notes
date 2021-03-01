<body>
<form action="write.php" method="post">
<p>
<input type="text" name="mojiretsu">
<input type="submit" value="送信">
</p>
</form>
<?php
  $mojiretsu = isset($_POST['mojiretsu']) ? $_POST['mojiretsu'] : "";
  if ($mojiretsu != "") {
    $fp = @fopen("write.txt", "wb") or die("Error!\n");
    fputs($fp, $mojiretsu);
    fclose($fp);
    print "ファイル「write.txt」に書き出しました。";
  }
?>
</body>