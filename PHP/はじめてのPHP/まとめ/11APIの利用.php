file_get_contents()で取得できる
  このメソッド、エラーの操作が微妙なので実際はcURL使う

http_build_query(連想配列)
  連想配列をクエリ文字列にする
json_decode(), json_encode()
  jsonファイルとPHPのデータ構造の変換

<?php
// NDB API 国民栄養データベース(米国農務省)
// 必要な情報を設定してクエリに
$params = array('api_key' => '発行されたAPIキー', 'q' => 'black pepper', 'format' => 'json'); // 'format' => 'json' は受け取るファイル形式
$url = 'http://api.nal.usda.gov/ndb/search?'.http_build_query($params);
// http(中略)rch?api_key=発行されたAPIキー&q=black+pepper%format=json

$response = file_get_contents($url); // 受け取り
// json形式で返ってきた 内容→P223
$info = json_decode($response);
// 連想配列にして出力
foreach ($info->list->item as $item) {
  print "The ndbno for {$item->name} is {$item->ndbno}.\n";
}
?>

ストリームコンテキスト
  読み書き操作に関する追加情報

stream_context_create(追加情報の連想配列)
  HTTPならmethod(デフォはGET)とかheaderとか設定できる。
  ('header' => 'Context-Type: application/json')
<?php
$params = array('api_key' => '発行されたAPIキー', 'q' => 'black pepper'); // 'format' => 'json'は不要になる
$url = 'http://api.nal.usda.gov/ndb/search?'.http_build_query($params);

// httpのストリームに、headerオプションを追加
$options = array('header' => 'Context-Type: application/json');
$context = stream_context_create(array('http' => $options));

print file_get_contents($url, false, $context);
// 第2引数 ストリーム対象の探すときパスがどうたらの設定。httpはfalse。
// 第3引数 コンテキスト
?>

methodをPOSTに変更したり
<?php
$url = 'http://php7.example.com/post-server.php';
$form_data = array('name' => 'black pepper', 'smell' => 'good');

$options = array(
  'method' => 'POST', // methodオプション 大文字
  'header' => 'Content-Type: application/x-www-form-urlencoded',
  // postしたいものがあるのでクエリにしてcontentに
  'content' => http_build_query($form_data)
  // jsonを送るなら json_encode($form_data) など、適宜
);

$context = stream_context_create(array('http' => $options));
print file_get_contents($url, false, $context);
?>