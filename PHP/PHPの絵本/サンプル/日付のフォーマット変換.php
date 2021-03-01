<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>日付のフォーマット変換</title>
</head>
<body>
<?php
  $olddate = "2017/ 3/ 1 ";
  if(preg_match("/^[ 0-9]+\/[ 0-9]+\/[ 0-9]+$/", $olddate)) {
    // 日付形式(数値/ 数値/ 数値)であったら分割して配列に格納
    list($year, $month, $day) = preg_split("/\\/", $olddate);
    // フォーマットを指定して表示
    $newdate = sprintf("%04d-%02d-%02d", $year, $month, $day);
    print $newdate;
  } else {
    print "日付はありませんでした。<br>\n";
  }
?>
</body>
</html>