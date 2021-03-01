エラーメッセージの表示先
  エラーを画面に表示 開発中など ユーザーが使用するときにはだせない
  エラーログに送信 運用開始後など
display_errors 構成ディレクティブ
  On 画面に表示
  Off エラーログに送信
log_errors
  On Webサーバーのエラーログに送信

エラーメッセージ
動作を停止するエラー
  Perse Error (パースエラー)
    セミコロンの抜けなど構文の問題
    動作は停止
  Fatal Error (致命的なエラー)
    未定義の関数呼び出しなどの重大な問題
    動作は停止
動作を続行するエラー
  Warning (警告)
    引数の数が異なるなど、疑わしいところがある
  Notice (注意)
    助言程度。未初期化変数の出力など
  Strict Notice (厳格注意) または Deprecation Warning (非推奨警告)
    運用性や互換性維持のための提案など
    バージョンアップで非対応になる可能性のある機能など
    (PHP5の新機能)

error_reporting 構成ディレクティブ
  デフォルト E_ALL & ~E_NOTICE & ~E_STRICT (注意と非推奨警告以外全て)
  報告されるエラーの種類を制御
E_ALL
E_PERSE
E_ERROR
E_WARNING
E_NOTICE
E_STRICT

デバッグ
error_log(文字列)
  エラーログに出力
<?php
$prices = array(5.95, 3.00, 12.50);
$total_price = 0;
$tax_rate = 1.08;

foreach ($prices as $price) {
  error_log("[before: $total_price]");
  $total_price = $price * $tax_rate; // +=にし忘れ
  error_log("[after: $total_price]");
}

printf('Total price (with tax): $%.2f', $total_price);
?>

出力場所を内部バッファに変更して隠す

開始 ob_start();
出力
取得 ob_get_contents();
終了 ob_end_clean();
error_log($output);

<?php
// 出力先を内部バッファへ変更
ob_start();
// 出力 今回は$_POSTの内容
var_dump($_POST);
// 内部バッファの内容取得 今はvar_dump($_POST)が出力した内容のみ
$output = ob_get_contents();
// 出力先の変更を終了(戻る)
ob_end_clean();
// ただの出力
error_log($output);
?>

デバッガの利用
phpdbg, Xdebug, Zend Debuggerなど

phpdbgの場合
・実行
phpdbg -e sample.php
　→ なにやら長い挨拶が表示

・ブレークポイント設定 毎回停止する
prompt> break 7
　→ [Breakpoint #0 added at broken.php:7]
・実行してブレークポイントで止まる
prompt> run
　→ [Breakpoint #0 at broken.php:7, hits: 1]
    >00007:      $total_price = $price * $tax_rate;
    00008: }
    00009:
・ウォッチポイントを追加 毎回停止する
prompt> watch $total_price  
　→ [Set watchpoint on $total_price]
・ブレークポイント削除
prompt> break del 0
　→ [Deleted breakpoint #0]
・以下続き
prompt> continue

try/catch以外 未補足例外の処理
予測できる例外ならtry/catchでできるけどってこと
例外処理の関数を作る → set_exception_handler()でその関数を設定する
<?php
// exceptionを受け取ってなんかする関数
function niceExceptionHandler($ex) {
  print 'エラーが発生しました。時間をおいて接続しなおしてください';
  error_log("{$ex->getMessage()} in {$ex->getFile()} @ {$ex->getLine()}");
  error_log($ex->getTraceAsString());
}

// niceExceptionHandlerをエクセプションの受け取り先に設定するよの関数
set_exception_handler('niceExceptionHandler');

print "I'm about to connect to a made up, pretend, broken detabase!\n";

// new PDOを失敗させる例
$db = new PDO('database');
?>