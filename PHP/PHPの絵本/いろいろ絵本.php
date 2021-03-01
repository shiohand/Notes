n進数を変換する関数
10→x
  decbin()
  decoct()
  dechex()
x→10
  bindec()
  octdec()
  hexdec()

nl2br(対象文字列, boolean)
  改行文字(\r, \nなど)の前に<br>を入れてくれるすごい
  第二引数はtrueの場合<br />
  new line to breakの略
<?php
$str = nl2br("PHP\rSQLite\r", false);
?>
htmlspecialchars(文字列)
  記号をHTML中で使える記号に置き換え
htmlspecialchars_decode(文字列)
  htmlspecialchars()などでエスケープされている記号を戻す
sprinf(文字列, 代入する値)
  %d 整数, %f 浮動小数点数, %s 文字列, など
strpos(文字列, 文字[, オフセット])
  指定した文字の始めに現れる位置
strrpos(文字列, 文字[, オフセット])
  指定した文字の最後に現れる位置 オフセットは前から

文字コードのエンコーディング例
  UTF-8, UTF-16LE, US-ASCII
  EUC-JP, Shift_JIS, ISO-2022-JP

Unicode コードポイントエスケープ構文
  print "\u{3057}"; // し（U+3057）

名前空間の定義
  namespace namae_a;
  namespace dirdir\namae_a;

使うとき
  namae_a\メソッド()
  dirdir\namae_a\プロパティ;
useで使うとき
  use dirdir\namae_a\get_nantara(); get_nantara();
  use dirdir\namae_a\get_nantara as namaeget;
  namaeget();
  use namae_a\{get_nantara(), set_nantara();}

自分のクラス名を取得 Shiori::class;
public function getClassName() {
  print Shiori::class; // とか
}

セッションのオプション
session_write_close()
  session_start()後はセッション情報がロックされるため、スクリプト中にセッション情報を利用したい場合にいったんクローズする。
構成ディレクティブ
  session.cache_expire  セッション持続時間の変更
  session_start((['cache_expire' => '180', 'read_and_close' => true])); // 設定変更

ファイルのアップロード
<form action="load.php" method="post" enctype="multipart/form-date">
<p><input type="file" name="upfile"></p>
<p><input type="submit" value="アップロード"></p>
<!-- hiddenでファイルの設定を返る(続きはwebで) -->
<input type="hidden" name="MAX_FILE_SIZE" value="10MB">
</form>

move_uploaded_file(一時ディレクトリ, 保存先)
  一時ディレクトリにあるファイルを移動する(失敗でfalseかな)
<?php
if(move_uploaded_file($_FILES['upfile']['tmp_name'], "./".$_FILES['upfile']['name']) == false) {
  print "失敗しました。";
} else {
  print ($_FILES['upfile']['name'])." をアップロードしました。";
}
?>

例外処理
set_error_handler(エラーハンドラ)
  エラーのときに呼び出されるエラーハンドラを定義
エラーハンドラ(エラーコード, エラーメッセージ, 発生ファイル, 発生行)
  自分で書く。
<?php
function myErrorProc($errcode, $msg, $file, $line) {
  print "エラー発生";
  die(); 
}
set_error_handler("myErrorProc"); // 関数名は文字列で
?>

従来のエラーハンドリングと例外処理の統合
throwと組み合わせ
<?php
function myErorrProc2($errcode, $msg, $file, $line) {
  if(!(error_reporting() & $errcode)) { // 出力するエラーの種類を取得
    return;
  }
  throw new ErrorException($msg, 0, $errcode, $file, $line);
}
?>

テストのやつ。
アサーション assert()
アサーションオプションの指定 boolean(1/0)
  assert_options()   php.ini
  ASSERT_ACTIVE      assert.active      評価を有効に
  ASSERT_WARNING     assert.warning     評価の失敗時に警告
  ASSERT_BAIL        assert.bail        評価の失敗時に終了
  ASSERT_QUIET_EVAL  assert.quiet_eval  評価のエラー報告を無効
  ASSERT_CALLBACK    assert.callback    評価の失敗時にコールバック関数を呼び出し
php.iniのみ
zend.assertions コードを生成するかを指定
   1: コードを生成して実行(開発時)
   0: コードを生成するが実行時は読み飛ばす
  -1: コードを生成しない(本番運用)
assert.exception  評価失敗時に例外をスローするか

