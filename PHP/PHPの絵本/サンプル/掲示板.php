<?php
$data_file = "keijiban.txt"; // ファイル読み込み用
$ext = file_exists($data_file);
$lines = $ext ? file($data_file) : array();
$errMsg = "";
date_default_timezone_set('Asia/Tokyo');

// [書き込む]ボタンが押されたとき
if(isset($_POST['submit'])) {
  // エラーならメッセージを設定
  if(empty($_POST['name'])) {
    $errMsg = '名前を入力してください<br>';
  } else if(empty($_POST['free'])) {
    $errMsg .= '記事を入力してください';
  }

  // エラーがなかったら追加を実行
  if(!$errMsg) {
    // サニタイジング
    function convert_str($str) {
      $str = htmlspecialchars($str);
      $str = preg_replace("/\r\n/", "<br>", $str);
      $str = preg_replace("/\r|\n/", "<br>", $str);
      return $str;
    }

    $ln = explode(",", $lines[0]);
    $no = $ext ? sprintf("%03d", $ln[0]+1) : "001"; // インクリメント なければ"001"
    $name = convert_str($_POST['name']);
    $free = convert_str($_POST['free']);
    $delkey = !empty($_POST['delkey']) ? convert_str($_POST['delkey']) : '#####'; // キーがあれば入れる, なければ'#####'
    $time = date("Y/m/d H:i:s");

    $data = "$no,$name,$free,$delkey,$time\n";
    array_unshift($lines, $data); // 配列の最初に入れる
  }
}

// [ 削除 ]ボタンが押されたとき
if(isset($_POST['delbtn']) && $ext) {
  for ($i=0; $i < count($lines); $i++) {
    // Rdkeyと一致するデータを探す
    $ln = explode(",", $lines[$i]);
    if($ln[0] == $_POST['no'] && $ln[3] == $_POST['Rdkey']) {
      array_splice($lines, $i, 1); // 削除開始$i, 要素数1
      break; // 見つけて削除した時点で大丈夫
    }
  }
}

// [ 書き込む ][ 削除 ] どちらかでファイルを読み込む
if(isset($_POST['submit']) && isset($_POST['delbtn'])) {
  $fk = fopen($data_file, 'wb');
  foreach($lines as $line) {
    fputs($fk, $line);
  }
  fclose($fk);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>絵本の掲示板</title>
</head>
<body>
<div id="wrapper">
<form action="keijiban.php" method="post">
<div class="center">
  <div id="title">絵本の掲示板</div>
  <p>
    No：<input type="text" name="no" size="20">
    削除キー：<input type="text" name="Rdkey" size="20">
    <input type="submit" name="delbtn" value="削除">
  </p>
</div>

<?php
// エラーがあったときの表示
if($errMsg) {
  echo '<div id="errMsg">'.$errMsg.'</div>';
}
?>

<div id="edit_area">
  <p>
  名前：<input type="text" name="name" size="26">
  削除キー：<input type="text" name="delkey" size="20">
  </p>
  <p>
  記事<br>
  <textarea name="free"></textarea>
  </p>
  <p class="center">
  <input type="submit" name="submit" value="書き込む">
  <input type="reset" value="取り消す">
  </p>
</div>

<?php
// ファイルから読み込んだものをテーブルにセット
foreach($lines as $line) {
  $ln = explode(",", $line);
  echo '<div><p class="entry_ID">[No.'.$ln[0].'] 名前：'.$ln[1].'&nbsp;'; // [No.001] 名前：てきすとえりあ内容(空白)
  echo '書き込み日付：'.$ln[4].'</p>';
  echo '<p>'.$ln[2].'</p>';
  echo '</div><hr>';
}
?>

</form>
</div>
</body>
</html>