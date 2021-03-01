<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>12 星座調べ</title>
</head>
<body>
<!-- 誕生日の入力フォーム -->
<form action="seiza.php" method="post">
  <p>
    星座を調べます<br>半角数字で誕生日を入力してください。<br>
    <input type="text" name="month">月
    <input type="text" name="day">日
    <input type="submit" value="調べる">
  </p>
  <?php
  // 誕生日から星座を調べる
  // 引数：誕生日 ($a=月, $b=日)
  // 戻り値：星座
  function seiza($a, $b) {
    if ((($a == 3) && (21 <= $b && $b <= 31)) ||
        (($a == 4) && (1 <= $b && $b <= 20))) {
      return "やぎ座";
    } elseif ((($a == 4) && (21 <= $b && $b <= 30)) ||
              (($a == 5) && (1 <= $b && $b <= 21))) {
      return "おうし座";
    } elseif ((($a == 5) && (22 <= $b && $b <= 31)) ||
              (($a == 6) && (1 <= $b && $b <= 21))) {
      return "ふたご座";
    } elseif ((($a == 6) && (22 <= $b && $b <= 30)) ||
              (($a == 7) && (1 <= $b && $b <= 22))) {
      return "かに座";
    } elseif ((($a == 7) && (23 <= $b && $b <= 31)) ||
              (($a == 8) && (1 <= $b && $b <= 22))) {
      return "しし座";
    } elseif ((($a == 8) && (23 <= $b && $b <= 31)) ||
              (($a == 9) && (1 <= $b && $b <= 23))) {
      return "おとめ座";
    } elseif ((($a == 9) && (24 <= $b && $b <= 30)) ||
              (($a == 10) && (1 <= $b && $b <= 23))) {
      return "てんびん座";
    } elseif ((($a == 10) && (24 <= $b && $b <= 31)) ||
              (($a == 11) && (1 <= $b && $b <= 22))) {
      return "さそり座";
    } elseif ((($a == 11) && (23 <= $b && $b <= 30)) ||
              (($a == 12) && (1 <= $b && $b <= 21))) {
      return "いて座";
    } elseif ((($a == 12) && (22 <= $b && $b <= 31)) ||
              (($a == 1) && (1 <= $b && $b <= 19))) {
      return "やぎ座";
    } elseif ((($a == 1) && (20 <= $b && $b <= 31)) ||
              (($a == 2) && (1 <= $b && $b <= 18))) {
      return "みずがめ座";
    } elseif ((($a == 2) && (19 <= $b && $b <= 29)) ||
              (($a == 3) && (1 <= $b && $b <= 20))) {
      return "うお座";
    } else {
      return "不明";
    }
  }
  $m = isset($_POST['month']) ? $_POST['month'] : '';
  $d = isset($_POST['day']) ? $_POST['day'] : '';
  if ($m && $d) {
    $s = seiza($m, $d);
    print "$m 月 $d 日生まれは $s です。";
  }
  ?>
</form>
</body>
</html>