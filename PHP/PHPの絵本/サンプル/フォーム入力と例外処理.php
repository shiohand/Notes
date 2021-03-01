<!-- reigai1.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<form action="reigai2.php" method="post">
  <p>数字を入力してください。</p>
  <p>
    <input type="text" name="left"> ÷
    <input type="text" name="right"> =
    <input type="submit" value="答え">
  </p>
</form>
</body>
</html>

<!-- reigai2.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
<?php
function divnum($a, $b) {
  try {
    $c = $a / $b;
  } catch (Exception $e) {
    $c = "計算できません (".$e->getMessage().") ";
  }
  return $c;
}

function myErrorProc($errcode, $msg, $file, $line) {
  if(!(error_reporting() & $errcode)) {
    return;
  }
  throw new ErrorException($msg, 0, $errcode, $file, $line);
}
set_error_handler("myErrorProc");
$x = $_POST['left'];
$y = $_POST['right'];
$z = divnum($x, $y);
print "$x ÷ $y = $z\n";
?>
<p><a href="reigai1.html">前のページに戻る</a></p>
</body>
</html>