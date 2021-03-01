例外処理

try-catch文 予測できる例外にしか使えない
<?php
try {
  $db = new PDO('mysql:host=localhost;dbname=restaurant', 'penguin', 'top^hat');
} catch (PDOException $e) {
  print $e->getMessage();
}
?>

未補足例外の処理
set_exception_handler(処理用の関数)
  例外が発生したときは例外処理用の関数を実行させる
  ！ try-catchと違ってプログラムは終了する
<?php
// exceptionを受け取ってなんかする関数
function niceExceptionHandler($ex) {
  // 好きにする
  print 'エラーが発生しました。時間をおいて接続しなおしてください';
  error_log("{$ex->getMessage()} in {$ex->getFile()} @ {$ex->getLine()}");
  error_log($ex->getTraceAsString());
}

// niceExceptionHandlerをexceptionの受け取り先に設定するよの関数
set_exception_handler('niceExceptionHandler');

print "I'm about to connect to a made up, pretend, broken detabase!\n";

// new PDOを失敗させる例
$db = new PDO('database');
// →例外発生、niceExceptionHandlerに渡される
?>