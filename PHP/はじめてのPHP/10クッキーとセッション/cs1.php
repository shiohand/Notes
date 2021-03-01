クッキーの操作
  クッキーはクライアント側に保存
$_COOKIE
  初回は値は入っていない setcookie()直後も
setcookie(キー, 値[, 有効期限, option])
  必ずプログラムの先頭に記述(HTMLのhead部分的なこと)
  削除は空文字を入れ直す 設定時にオプションを付けていた場合は同じオプションを付ける
<?php
setcookie('userid', 'ralph'); // 本当は先頭に記述
if (isset($_COOKIE['userid'])) { // 初回接続時はまだ空なので
  print 'Hello, '.$_COOKIE['userid'];
}
setcookie('userid', '');
?>
有効期限
  デフォルトがブラウザの終了まで
  連想配列で取得
  time()+60 // 現在時刻+60秒ということ
  time()+60*60*24*30 // 30日
time()とかDateTimeとかはあとでやる！
<?php
$d0 = 0; // 0はデフォルト
$d1 = time() + 60*60; // 現在時刻+1時間ということ
$d2 = time() + 60*60*24*30; // 30日
$d3 = new DateTime('2019-10-01 12:00:00'); // 日付指定
setcookie('userid', 'ralph', $d0); // デフォルト
setcookie('userid', 'ralph', $d1); // 1時間
setcookie('userid', 'ralph', $d3->format('U')); // 伝わる表現にフォーマット
?>
その他のパラメータ
パス 第4引数 文字列
  設定したクッキーを利用できるパスの指定
  デフォルト 設定したページのある階層以下
ドメイン 第5引数 文字列
  クライアントがクッキーを送るドメインの指定
  デフォルト 設定したページのあるホスト
HTTPSのみ 第6引数 boolean
  httpsでないURLのときは送信しないように設定
  デフォルト false
HTTP専用 第7引数 boolean
  クライアントサイドのJavaScriptではやり取りできないようにする
  デフォルト false
<?php
// パス
setcookie('userid', 'ralph', 0, '/'); // ルート以下(なんたら.jp/以下)
setcookie('userid', 'ralph', 0, '/mypage/'); // ルート/mypage/以下
// ドメイン
setcookie('userid', 'ralph', 0, '/', '.example.com'); // 同じドメインなら可能
// https限定 http専用
setcookie('userid', 'ralph', 0, '/', null, true, true);
?>

セッションの利用
  デフォルトではPHPSESSIDというクッキーを用いる あれば利用、なければ作成
  ウェブクライアントの識別に利用 一意の値
$_SESSION
  初回は値は入っていない
session_start()
  必ずプログラムの先頭に記述(HTMLのhead部分的なこと)
  全ページで使うから省略したいってときはサーバー構成で構成ディレクティブsessionauto_startの設定(いつか書く)
<?php
// 訪問回数のカウント
session_start();
if (isset($_SESSION['count'])) {
  $_SESSION['count'] = $_SESSION['count']++;
} else {
  $_SESSION['count'] = 1;
}
print 'あなたはこのページを'.$_SESSION['count'].'回訪問しました';
?>
構成ディレクティブ
  ini_set()で変更 (session_start()の前) またはサーバー構成で変更
  session.auto_startを設定している場合は始めからセッションが有効なのでini_set()は使えない
有効期限
  クッキーのように長期的に使われる想定はされていない。
  デフォルトでは24分間更新されなければ終了する。「セッション切れです」ってあれか。
  金融関係など、セキュリティの求められる用途では短く設定してある。
session.gc_maxlifetime
  構成ディレクティブ デフォルト 1440(秒)
期限切れセッションの削除
  常に監視して削除するのはだいぶ非効率なので、基本はリクエストごとに1%の確率で消去
session.gc_probability
  構成ディレクティブ デフォルト 1(%)
<?php
ini_set('session.gc_maxlifetime', 600); // 600秒
ini_set('session.gc_probability', 100); // リクエストごとに削除
session_start();
?>
セッションIDを格納するクッキー
構成パラメータでプロパティを調整可能
session.name
session.cookie_lifetime
session.cookie_path
session.cookie_domain
session.cookie_secure
session.cookie_httponly