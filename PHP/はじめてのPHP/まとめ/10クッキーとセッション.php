クッキーの操作
  クッキーはクライアント側に保存
$_COOKIE
  初回はもちろん、setcookie()直後も値は入っていない

setcookie(キー, 値[, 有効期限, option])
  必ずプログラムの先頭に記述(HTMLのhead部分的なこと)
  削除は空文字を入れ直す 設定時にオプションを付けていた場合は同じオプションを付ける

有効期限 第3引数 Unix Epoch
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
$d4 = $d3->format('U'); // フォーマット 'U'はUnix Epoch(経過秒)
setcookie('userid', 'ralph', $d0); // デフォルト
setcookie('userid', 'ralph', $d1); // 1時間
setcookie('userid', 'ralph', $d4); // 2019-10-01 12:00:00
?>

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
  JavaScriptにはクッキーを使わせないようにする
  デフォルト false

setCookie()引数まとめ
キー, バリュー, 期限, // きほんみっつ
パス, ドメイン, // '/', null, などにもなる
secure, HttpOnly // secureはまずtrue

<?php
setcookie('userid', 'ralph', 0, null, null, true, true);
?>

〇セッションの利用
  デフォルトではPHPSESSIDというクッキーを用いる あれば利用、なければ作成
  ウェブクライアントの識別に利用 一意の値

$_SESSION
  クッキーと同じく、初回は値は入っていない

session_start()
  デフォルトではPHPSESSIDというクッキーを用いる
  必ずプログラムの先頭に記述(HTMLのhead部分的なこと)
  引数に連想配列(['cookie_lifetime' => 600, 'read_and_close' => true]など)を渡して設定することができるよくわからん

構成ディレクティブ
  ini_set()で変更できる(session_start()前)
session.auto_start
  Onでセッション自動スタート。session_startがいらなくなる
session.gc_maxlifetime
  セッション継続時間 デフォルト 1440(秒)
session.gc_probability
  期限切れセッションの削除 デフォルト 1(%)
  常に監視して削除するのはだいぶ非効率なので、基本はリクエストごとに1%の確率で消去
  
<?php
ini_set('session.gc_maxlifetime', 600); // 600秒
ini_set('session.gc_probability', 100); // リクエストごとに削除
session_start();
?>

セッションIDを格納するクッキー 構成パラメータでプロパティを調整可能
setcookieで変えられるっていうことなの？わからん。
  session.auto_startがOnだとini_set()の暇がないのでそういうとき用。
session.name
session.cookie_lifetime
session.cookie_path
session.cookie_domain
session.cookie_secure
session.cookie_httponly

ログイン確認とログアウト
$_SESSIONにキーが有る ＝ ログイン済み
<?php
if (array_key_exists('username', $_SESSION)) {
  print 'こんにちは、'.$_SESSION['username'].'さん';
}
?>
ログアウト unset()するだけ
<?php
unset($_SESSION['username']);
?>

パスワードのハッシュ化
password_hash(ハッシュ化したいパスワード, 定数でアルゴリズム選択)
  パスワードをハッシュ化した文字列に変換
password_verify(比べるパスワード(未ハッシュ化), 保存されているパスワード(既ハッシュ化))
  比べるパスワードをハッシュ化し、保存されているパスワードのハッシュと同値かを調べる
<?php
$saved_password = password_hash('password', 'algorithm');
$submitted_password = 'password';
if (! password_verify($submitted_password, $saved_password)) {
  $errors[] = '正確なusernameとpasswordを入力してください';
}
?>