ストリーム
PHPエンジンがプログラムとデータをやり取りするための基盤となる仕組み
ローカルファイル、リモートURL、データを作成・消費するその他の外部の場所に対して

ファイルは文字列として取得する
  うらるも読めるよ

file_get_contents(ストリームの対象)
file_put_contents(ストリームの対象, 内容)
  ひとつのファイルをまとめて読み込み、書き込み
  ファイルが大きいとリスク
<?php
// テンプレHTMLのファイル読み込み
$page = file_get_contents('page-templlate.html');

// 置換
$page = str_replace('{page_title}', 'Welcome', $page);
if (date('H') >= 12) { // 現在hourが12以上(午後)のとき
  $page = str_replace('{color}', 'blue', $page);
} else { // else
  $page = str_replace('{color}', 'green', $page);
}
$page = str_replace('{color}', $_SESSION['username'], $page);

// どこかに書き込み
file_put_contents('page.html', $page);
?>

file()
  ファイルを1行ずつの配列として読み込み
  ファイルが大きいとリスク
<?php
foreach (file('people.txt') as $line) {
  $line = trim($line);
  $info = explode('|', $line); // 分割
  print "<li><a href=\"mailto:{$info[0]}\">{$info[1]}</li>\n";
}
?>

fopen(), fgets(), feof(), fclose()
  open ファイルへの接続をオープンし、ファイルへのアクセスを変数として返す
  gets 1行を読み込んで文字列として返し、次の行へ進む
  eof ファイルの末尾を超えたらtrueを返す
  close 接続をクローズする
<?php
$fh = fopen('people.txt', 'rb');
// (! feof($fh)) 現在位置が最終行以前
// (fgets($fh)) 取得した文字列がtrue判定
while ((! feof($fh)) && ($line = fgets($fh))) {
  $line = trim($line);
  $info = explode('|', $line); // 分割
  print "<li><a href=\"mailto:{$info[0]}\">{$info[1]}</li>\n";
}
fclose($fh);
?>

open()の第二引数
  rb  R  既存ファイルのみ
  wb  W  読み込み時に内容消去
  ab  W  末尾開始
  xb  W  新規ファイルのみ
  cb  W  
  末尾+(rb+, cb+など) 読み書き可能
fwrite()
  書き込み
<?php
try {
  $db = new PDO('sqlite:/tmp/restaurant.db');
} catch (Exception $e) {
  print '接続できませんでした'.$e->getMessage();
  exit();
}
$fh = fopen('dishes.txt', 'wb');
$q = $db->query("SELECT dish_name, price FROM dishes");
while ($row = $q->fetch()) {
  fwrite($fh, "The price of $row[0] is $row[1] \n"); // \n要るなら忘れず
}
fclose($fh);
?>

fgetcsv(), fputcsv()
  csvフォーマット
<?php
$fh = fopen('dishes.csv', 'rb');
$stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?,?,?)');
while ((! feof($fh)) && ($info = fgetcsv($fh))) {
  // $infoは1件3要素の配列なのでちょうど入る
  $stmt->execute($info);
  print "Inserted $info[0]\n";
}
fclose($fh);
?>
<?php
$fh = fopen('dish-list.csv', 'wb');
$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');
while ($row = $dishes->fetch(PDO::FETCH_NUM)) {
  fputcsv($fh, $row);
}
fclose($fh);
?>
CSVファイル使うよ宣言
<?php
// CSVファイル使うよ宣言
header('Content-Type: text/csv');
// CSVファイルを別のプログラムで表示すべきだよ宣言
header('Content-Disposition: attachment; filename="dishes.csv"');
// 出力ストリームへのファイルハンドル
$fh = fopen('php://output', 'wb');

$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');
while ($row = $dishes->fetch(PDO::FETCH_NUM)) {
  fputcsv($fh, $row);
}
?>
パーミッション(アクセス権)の検査
file_exists()
is_readable()
is_writeable()
<?php
// ファイルの存在のチェック
if (file_exists('/usr/local/htdocs/index.html')) {
  print "Index file is there.";
} else {
  print "No index file in /usr/local/htdocs.";
}
$template_file = 'page.template.html';
if (is_readable($template_file)) {
  $template = file_get_contents($template_file);
} else {
  print '読み込めませんでした';
}
$log_file = '/var/log/users.log';
if (is_writeable($log_file)) {
  $fh = fopen($log_file, 'ab');
  fwrite($fh, $_SESSION['username'].' at '.strftime('%c')."\n");
  fclose($fh);
} else {
  print '書き込めませんでした';
}
?>

エラーチェック
ファイル関連の関数はエラー時は警告メッセージを出し、falseを返す
track_errors を有効にするとメッセージがグローバル変数 $php_errormsg に入る

fopen(), fclose()
<?php
$fh = fopen('/usr/local/dishes.txt', 'wb');
if (! $fh) { // fopen()の戻り値がfalseならば
  print 'dishes.txtを開けませんでした: '.$php_errormsg;
} else {
  // 処理;
  if (! fclose($fh)) { // fclose()のry
    print 'dishes.txtを閉じられませんでした: '.$php_errormsg;
  }
}
?>
file_get_contents()
<?php
$page = file_get_contents('page-template.html');
if ($page === false) {
  print '読み込めませんでした: '.$php_errormsg;
} else {
  // 処理;
}
?>
fgets() 他読み込み
<?php
$fh = fopen('people.txt', 'rb');
if (! $fh) {
  print 'dishes.txtを開けませんでした: '.$php_errormsg;
} else {
  
  while (! $feof($fh)) {
    $line = fgets($fh);
    if ($line !== false) { // falseなら実行しない
      // 処理;
    }
  }

  if (! fclose($fh)) {
    print 'dishes.txtを閉じられませんでした: '.$php_errormsg;
  }
}
?>
file_put_contents() 他書き込み
<?php
$page = file_get_contents('page-template.html');
// 処理;
$result = file_put_contents('page.html', $page);
if (($result === false) || ($result == -1)) { // falseか-1
  print '保存できませんでした';
}
?>

サニタイジング
  外部からのデータやURLの無害化
ファイル名 - '/', '..'
<?php
// '/'
$use = str_replace('/', '', $_POST['user']);
// '..'
$user = str_replace('..', '', $user);

if (is_readable("usr/local/data/$user")) {
  print 'User profile for '.htmlentities($user).': <br/>';
  print file_get_contents("usr/local/data/$user");
}
?>
realpath() パスを文字列にして返すたぶん
<?php
// 一回パスを入れて
$filename = realpath("/usr/local/data/$_POST[user]");
// パスの上部が違うフォルダになっていないか照合(is_readableはただのパーミッション)
if ((substr($filename, 0, 16) == '/usr/local/data') && is_readable($filename)) {
  print 'User profile for '.htmlentities($_POST['user']).': <br/>';
  print file_get_contents($filename);
} else {
  print 'Invalid user entered.';
}
?>