<!-- cookie1.php -->
<?php setcookie('val', 100) ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>クッキー</title>
</head>
<body>
<?php
  $getval = isset($_COOKIE['val']) ? $_COOKIE['val'] : '(なし)';
  print "ページ１の値は$getval です。\n";
?>
<p><a href="cookie2.php">ページ2へ</a></p>
</body>
</html>
<!-- cookie2.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>クッキー</title>
</head>
<body>
<?php
  $getval = isset($_COOKIE['val']) ? $_COOKIE['val'] : '(なし)';
  print "ページ2の値は$getval です。\n";
?>
<p><a href="cookie1.php">ページ1へ</a></p>
</body>
</html>