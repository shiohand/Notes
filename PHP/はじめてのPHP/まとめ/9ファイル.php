ローカルファイル、リモートURL、データを作成・消費するその他の外部の場所に対して

file_get_contents(ストリームの対象)
file_put_contents(ストリームの対象, 内容)
  ひとつのファイルをまとめて読み込み、書き込み
  ファイルが大きいとリスク
  
file()
  ファイルを1行ずつの配列として読み込み
  ファイルが大きいとリスク

fopen(), fgets(), feof(), fclose()
  open ファイルへの接続をオープンし、ファイルへのアクセスを変数として返す
  gets 1行を読み込んで文字列として返し、次の行へ進む
  eof ファイルの末尾を超えたらtrueを返す
  close 接続をクローズする

open()の第二引数
  rb  R  既存ファイルのみ     絶対読む
  wb  W  読み込み時に内容消去  絶対書く
  ab  W  末尾開始           逆張り
  xb  W  新規ファイルのみ     ニュービー感
  cb  W  内容を空にしない     wbじゃない方
  末尾+(rb+, cb+など)       読み書き可能
fwrite()
  書き込み

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

fgetcsv(), fputcsv()
  csvフォーマット
CSVファイル使うよ宣言が必要
<?php
// CSVファイル使うよ宣言
header('Content-Type: text/csv');
// CSVファイルを別のプログラムで表示すべきだよ宣言
header('Content-Disposition: attachment; filename="dishes.csv"');
?>

パーミッション(アクセス権)の検査
file_exists()  存在の有無
is_readable()  読めるか
is_writeable() 書けるか

エラーチェック
エラー時は警告メッセージ&falseを返す
track_errors を有効にするとメッセージがグローバル変数 $php_errormsg に入る
<?php
$page = file_get_contents('page-template.html');
if ($page === false) {
  print $php_errormsg;
} else {
  // 処理;
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
?>

realpath() パスを絶対パスにして返すたぶん substr(file, 0, length)で前方一致の確認
<?php
$filename = realpath("/usr/local/data/$_POST[user]");
// パスの上部が違うフォルダになっていないか照合(is_readableはただのパーミッション)
if ((substr($filename, 0, 16) == '/usr/local/data') && is_readable($filename)) {
  // OK
} else {
  // NG
}
?>