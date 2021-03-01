<!-- password1.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>パスワード入力画面</title>
</head>
<body>
<form action="password2.php" method="post">
<p>パスワード：<input type="password" name="pass"><input type="submit" value="送信"></p>
</form>
</body>
</html>

<!-- password2.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>パスワード確認画面</title>
</head>
<body>
<?php
  $password = $_POST['pass'];
  if (preg_match("/^[a-z][a-z0-9_]{2,7}$/i", $password)) {
    print "正しい形式です。<br>\n";
  } else {
    print "パスワードは正しい形式ではありません。<br>\n";
  }
?>
</body>
</html>