cURLを使った包括的なURLアクセス
  HTTPリクエストとレスポンスの詳細を制御
  ライブラリ libcurl を使用
curl_version()
  バージョン情報の連想配列 ['version']に現在のバージョン

curl_init(URL)
  URLを利用するハンドルを返す。ハンドルを使っていろいろする。
  ハンドルごとに異なるリクエストを制御できる。
curl_setopt()
  取得時の処理を制御
curl_exec()
  リクエストを取得
<?php
// ハンドル
$c = curl_init('http://numbersapi.com/09/27');
// CURLOPT_RETURNTRANSFAR 文字列として返す
curl_setopt($c, 'CURLOPT_RETURNTRANSFAR', true);
// リクエスト実行
$fact = curl_exec($c);
print 'Did you know that '.$fact;
?>

ヘッダに追加情報を設定
<?php
$params = array('api_key' => '発行されたAPIキー', 'q' => 'black pepper');
$url = 'http://api.nal.usda.gov/ndb/search?'.http_build_query($params);
$c = curl_init($url);
curl_setopt($c, 'CURLOPT_RETURNTRANSFAR', true);

// CURLOPT_HTTPHEADER HTTPヘッダ情報追加
curl_setopt($c, 'CURLOPT_HTTPHEADER', array('Content-Type: application/json'));

$fact = curl_exec($c);
print 'Did you know that '.$fact;
?>

エラーの処理
  リクエストが通らなかいなどのエラー発生時にはcurl_exec()がfalseを返す
  リクエストが通った時点で成功なので、それより後に発生したエラーは別途調べる必要あり
curl_errno()
  リクエスト失敗時にエラーコードが入る
curl_error()
  エラーコードに対応するエラーメッセージ
curl_getinfo()
  リクエストに関する情報を配列で返す。うち一つはHTTPレスポンスコード
<?php
// 存在しないAPIエンドポイント
$c = curl_init('http://api.example.com');
curl_setopt($c, 'CURLOPT_RETURNTRANSFER', true);
$result = curl_exec($c);
// 成否に関わらず接続情報を取得とする
$info = curl_getinfo($c);

// 接続の問題発見
if ($result === false) {
  print "Error #".curl_errno($c)."\n";
  print "error:".curl_error($c)."\n";
} else if ($info['http_code'] >= 400) { // 400台500台のレスポンスコードはエラー
  print "The server says HTTP error {$info['http_code']}.\n";
} else {
  print "A successful result!\n";
}
// 統計データもあるよ
print "By the way, this request took {$info['total_time']} seconds.\n";
?>

POSTを使う
CURLOPT_POST
CURLOPT_POSTFIELDS
<?php
$url = 'http://php7.example.com/post-server.php';

$form_data = array('name' => 'black pepper', 'smell' => 'good');

$c = curl_init($url);
curl_setopt($c, 'CURLOPT_RETURNTRANSFER', true);
// POSTです
curl_setopt($c, 'CURLOPT_POST', true);
// 中身です
curl_setopt($c, 'CURLOPT_POSTFIELDS', $form_data);

print curl_exec($c);
?>
JSONでPOSTしたいとき(どんなときや)
json_encode()
  phpデータ構造をjsonに変換
<?php
$url = 'http://php7.example.com/post-server.php';

$form_data = array('name' => 'black pepper', 'smell' => 'good');

$c = curl_init($url);
curl_setopt($c, 'CURLOPT_RETURNTRANSVER', true);
curl_setopt($c, 'CURLOPT_POST', true);
// JSONですよ通知
curl_setopt($c, 'CURLOPT_HTTPHEADER', array('Content-Type: application/json'));
// json_encodeでフォーマット
curl_setopt($c, 'CURLOPT_POSTFIELDS', json_encode($form_data));

print curl_exec($c);
?>

クッキーを使う
  あっちにクッキーを設定するヘッダがあっても、こっちでは特に処理しない。
  こっちでもクッキーを保存したりしたいならちゃんと設定する。
  CURLOPT_COOKIEJAR とか CURLOPT_COOKIEFILE とかで設定

クッキー['c']をカウントアップするだけのページ
<?php
// cookie-server.php
$value = $_COOKIE['c'] ?? 0; // 値を受け取る, なければ0で作る
$value++;
setcookie('c', $value); // $_COOKIE['c']に$valueを設定
// setしたけど、$_COOKIE['c']に反映されるのは再読み込みのあとからだね

print "Cookies: ".count($_COOKIE)."\n"; // 始めは0
foreach ($_COOKIE as $k => $v) { // まだ冒頭の値のまま
  print "$k: $v \n ";
}
?>

ただの実行
  ハンドルとクッキーが連携していないため、毎回新しいクッキーが作られるだけ
<?php
// サーバーページを取得
$c = curl_init('http://php7.example.com/cookie-server.php');
curl_setopt($c, 'CURLOPT_RETURNTRANSFER', true);

$res = curl_exec($c);
print $res;
$res = curl_exec($c);
print $res;
$res = curl_exec($c);
print $res;
// 1回目の実行 Cookies: 0
// 2回目の実行 Cookies: 0
// 3回目の実行 Cookies: 0
// c: 0 は無い。nullなのでforeachはすぐ終了する。
?>

curl_setopt(ハンドル, 'CURLOPT_COOKIEJAR', true);
  ハンドルはクッキーを追跡。ハンドルが生きている間(プログラム終了まで)は有効。
<?php
$c = curl_init('http://php7.example.com/cookie-server.php');
curl_setopt($c, 'CURLOPT_RETURNTRANSFER', true);

// クッキーを扱えるようにする $c「把握」
curl_setopt($c, 'CURLOPT_COOKIEJAR', true);

$res = curl_exec($c);
print $res;
$res = curl_exec($c);
print $res;
$res = curl_exec($c);
print $res;
// 1回目の実行 Cookies: 0
// 2回目の実行 Cookies: 1 \n c: 1
// 3回目の実行 Cookies: 1 \n c: 2
?>

curl_setopt(ハンドル, 'CURLOPT_COOKIEJAR', ファイル名);
curl_setopt($c, 'CURLOPT_COOKIEFILE', ファイル名);
  ファイルに保存して使う ファイルがあればずっと有効。
  リクエスト間でのクッキーの追跡
<?php
$c = curl_init('http://php7.example.com/cookie-server.php');
curl_setopt($c, 'CURLOPT_RETURNTRANSFER', true);

// __DIR__(同じディレクトリ)の'/saved.cookies'を使う
curl_setopt($c, 'CURLOPT_COOKIEJAR', __DIR__.'/saved.cookies');
// __DIR__(同じディレクトリ)の'/saved.cookies'を送る
curl_setopt($c, 'CURLOPT_COOKIEFILE', __DIR__.'/saved.cookies');

$res = curl_exec($c);
print $res;
$res = curl_exec($c);
print $res;
$res = curl_exec($c);
print $res;
// 1回目の実行 Cookies: 0
// 2回目の実行 Cookies: 1 \n c: 1
// 3回目の実行 Cookies: 1 \n c: 2
?>

HTTPSがらみ
セキュリティ関連で差があるが、使う上では特に触らなくてよい

1.身元確認 URLを処理すべきサーバーである確認 多分サーバー証明関係
2.傍受防御 暗号化

サーバー証明関係 変更すると確認がザルになる
CURLOPT_SSL_VERIFYPEER - true
CURLOPT_SSL_VERIFYHOST - 2

cURLが使うプロトコルバージョンは CURLOPT_SSLVERSION 設定で制御
デフォルト値は CURL_SSLVERSION_DEFAULT