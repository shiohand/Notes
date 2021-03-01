ファイル

fopen失敗でプログラムを終了する場合
<?php
$fp = @fopen("memo.txt", 'rb') or die("File Open Error!\n");
?>

fgets(ハンドル, 最大バイト長);
  改行は1バイト扱い \r\nのときは？
fputs(ハンドル, 文字列, 最大バイト長)
  書き込む
  fwrite()といっしょ
feof(ハンドル)
  End Of File
  ファイルの終端に達するとtrue
fclose()
  クローズ
<?php
while(!feof($fp)) {
  print fgets($fp)."<br>\n";
}
fclose($fp);
?>

テキストファイルの書き出し
<?php
$fp = @fopen("memo.txt", 'wb') or die("File Open Error!\n");
fputs($fp, "Hello\n", 6);
fclose($fp);
?>

ファイルの属性を取得する
file_exists is_readable is_writable
filesize(ファイル名)

rename(ファイル名, 変更後ファイル名)
  リネーム
unlink(ファイル名)
  ファイルの削除
<?php
  // ファイル名を変更
  $fp = @fopen("file.txt", "wb") or die("Error!\n");
  fputs($fp, "元のファイル名は「file.txt」です。\n");
  fclose($fp);
  rename("file.txt", "newfile.txt");
  print "ファイル名を変更しました。<br>\n";

  // ファイルを削除
  if(file_exists("newfile.txt")) { // あれば
    $fp = @fopen("newfile.txt", "rb") or die("Error!\n");
    $line = fgets($fp);
    print $line."<br>\n";
    fclose($fp);
    unlink("newfile.txt");
    print "「newfile.txt」を削除しました。<br>\n";
  } else { // なければ
    print "「newfile.txt」はありません。<br>\n";
  }
?>

RDBMS SQLite
組み込み式
new SQLite(作成するデータベース名)
  ファイルは同階層のディレクトリに入る
$db->exec(SQL文)
  クエリ実行 変更を加える
$db->query(SQL文)
  クエリ実行 データを配列で取得する
    戻り値->fetchArray(返り値の指定); 
      SQLITE3_ASSOC  フィールド名をキーにする

$db->close()
  切断

データベースの作成と接続
<?php
$db = new SQLite3("db_ehon");
$query = "CREATE TABLE tbl_ehon(id INTEGER, title VARCHAR(10), price INTEGER)";
$result = $db->exec($query);
$db->close()
?>

変更したり
<?php
$db = new SQLite3('db_ehon');
$query = "INSERT INTO tbl_ehon (id, title, price) "
  ."VALUES (1, 'cの絵本', 1380)";
$result = $db->exec($query);
$query = "INSERT INTO tbl_ehon (id, title, price) "
  ."VALUES (1, 'TCP/IPの絵本', 1580)";
$result = $db->exec($query);
$query = "INSERT INTO tbl_ehon (id, title, price) "
  ."VALUES (1, 'SQLの絵本', 1680)";
$result = $db->exec($query);
$query = "INSERT INTO tbl_ehon (id, title, price) "
  ."VALUES (1, 'Perlの絵本', 1680)";
$result = $db->exec($query);
$db->close();
?>

取得したり
<?php
$db = new SQLite3('db_ehon');
$query = "SELECT * FROM tbl_ehon";
$result = $db->query($query);
while ($info = $result->fetchArray(SQLITE3_ASSOC)) {
  print "id    = {$info['id']}, ";
  print "title = {$info['title']}, ";
  print "price = {$info['price']} ";
  print "<br>\n";
}
$db->close();
?>