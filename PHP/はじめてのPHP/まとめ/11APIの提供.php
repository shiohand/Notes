
APIリクエストをクライアントに提供する APIをつくろう
  呼び出し用のページをデータを作成
  必要ならHTTPレスポンスコードとレスポンスヘッダも操作
header()
  HTMLレスポンスに任意のヘッダ行を追加。

現在時刻をjsonで渡すだけのページ
<?php
// time() 現在時刻
$response_data = array('now' => time());
// 返すファイルの形式(json)
header('Content-Type: application/json');
// 表示
print json_encode($response_data);

// 'Content-Type: application/json'
// {'now':time()}
// が反映されたHTMLレスポンスとなる
?>

HTMLレスポンスの全体像

上の例
  1:HTTP/1.1 200 OK
  2:Host: www.example.com
  3:Connection: close
  4:Content-Type: application/json
  5:
  6:{"now": 192258300} // time()の結果が入っている

・レスポンスヘッダ 数行はWebサーバが自動的に追加
  1 レスポンスコード 200はHTTPでは全て成功
  4 header()で入れた分
・空行
・リクエストボディ
  6 Webブラウザに表示される部分(HTMLの場合はレンダリングを経て)


レスポンスコード(HTTP/1.1 200 OK とか)の変更
  403とか表示させる設定ができる
<?php
// クエリのkeyが正しくなければ403を返す
if (! (isset($_GET['key']) && ($_GET['key'] == 'pineapple'))) {
  http_response_code(403); // HTTP/1.1 403 Forbidden
  $response_data = array('error' => 'bad key');
} else {
  $response_data = array('now' => time());
}
header('Content-Type: application/json');
print json_encode($response_data);
?>

受信したリクエストヘッダにアクセス
  $_SERVER['HTTP_ヘッダ名'] // ヘッダ名の'-'は'_'に
    受信ヘッダの中の指定したヘッダの値が入っている
  例: Content-Type は $_SERVER['HTTP_CONTENT_TYPE']に入っている

HTTP_ACCEPT(受け取りフォーマットの指定)を調べるサンプル
<?php
// サポートフォーマット
$formats = array('application/json', 'text/html', 'text/plain');
// デフォルト 相手から指定がなかったとき用
$default_format = 'application/json';

if (isset($_SERVER['HTTP_ACCEPT'], $formats)) { // 指定があったら
  if (in_array($_SERVER['HTTP_ACCEPT'], $formats)) { // サポートしている
    $format = $_SERVER['HTTP_ACCEPT'];
  } else { // サポートしていない
    http_response_code(406); // 無効なフォーマットのリクエストである
    exit();
  }
} else { // フォーマット指定がなかったら
  $format = $default_format;
}

$response_data = array('now' => time());
header("Content-Type: $format"); // フォーマットを適用

// 各フォーマットに対応した出力の準備
// jsonコース, htmlコース, textコース
if ($format == 'application/json') {
  print json_encode($response_data);

} else if ($format == 'text/html') { ?>
<!doctype html>
  <html>
    <head><title>Clock</title></head>
    <body><time><?= date('c', $response_data['now']) ?></time></body>
  </html>

<?php } else if ($format == 'text/plain') {
  print $response_data['now'];
}
?>

リクエストがHTTPSで行われているかの確認(だいじ)
<?php
// $_SERVER['HTTPS']ある onである
$is_https = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on'));
if (! $is_https) { // でなければ
  // httpsに書き換え HTTP_HOSTとREQUEST_URI
  $newUrl = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  // location変更(ページ移動)
  header("Location: $newUrl");
  exit();
}
print "httpsです";
?>