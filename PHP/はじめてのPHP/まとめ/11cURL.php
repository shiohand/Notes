cURLを使った包括的なURLアクセス
  HTTPリクエストとレスポンスの詳細を制御
  ライブラリ libcurl を使用
curl_version()
  バージョン情報の連想配列 ['version']に現在のバージョン

curl_init(URL)  ハンドルを作成して返す
curl_setopt(ハンドル, オプション, 値)   制御を追加 CURLOPT_なんたら
curl_exec(ハンドル)     実行。リクエストを取得

ヘッダに追加情報を設定
（stream_context_create()でheader情報追加したあれ）
<?php
$params = array('api_key' => '発行されたAPIキー', 'q' => 'black pepper',);
$url = 'http://api.nal.usda.gov/ndb/search?'.http_build_query($params);

$c = curl_init($url);

// CURLOPT_RETURNTRANSFAR 文字列として返す (デフォはすぐ出力)
// CURLOPT_HTTPHEADER HTTPヘッダ情報追加
curl_setopt($c, 'CURLOPT_RETURNTRANSFAR', true);
curl_setopt($c, 'CURLOPT_HTTPHEADER', array('Content-Type: application/json'));

print curl_exec($c);
?>

エラーの処理
curl_exec(ハンドル)
  リクエストが通らなかいなどのエラー発生時にfalseを返す
  リクエストが通った後に発生したエラーは別途調べる必要あり
curl_errno(ハンドル)
  リクエスト失敗時にエラーコードが入る
curl_error(ハンドル)
  エラーコードに対応するエラーメッセージ
curl_getinfo(ハンドル)
  リクエストに関する情報を配列で返す。うち一つはHTTPレスポンスコード
  curl_exec()がエラーじゃなかったときにレスポンスコードも確認するため
  ['http_code'] レスポンスコード
  ['total_time'] なんか時間
<?php
// 存在しないAPIエンドポイント
$c = curl_init('http://間違ったURL.com');
curl_setopt($c, 'CURLOPT_RETURNTRANSFER', true);
$result = curl_exec($c); // 失敗
// 成否に関わらず接続情報を取得とする
$info = curl_getinfo($c);

// 接続の問題発見
if ($result === false) {
  print "Error #".curl_errno($c)."\n"; // エラーコード
  print "error:".curl_error($c)."\n"; // メッセージ
} else if ($info['http_code'] >= 400) { // 400台500台のレスポンスコードはエラー
  print "The server says HTTP error {$info['http_code']}.\n";
} else {
  print "A successful result!\n";
}
// 統計データもあるよ
print "By the way, this request took {$info['total_time']} seconds.\n";
?>

CURLOPT_POST
  booleanで設定 POSTリクエストにする
CURLOPT_POSTFIELDS
  POSTするオブジェクトを設定
<?php
$url = 'http://php7.example.com/post-server.php';
$form_data = array('name' => 'black pepper', 'smell' => 'good');
$c = curl_init($url);
curl_setopt($c, 'CURLOPT_RETURNTRANSVER', true);
curl_setopt($c, 'CURLOPT_POST', true);
curl_setopt($c, 'CURLOPT_HTTPHEADER', array('Content-Type: application/json'));
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