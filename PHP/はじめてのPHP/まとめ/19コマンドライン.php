コマンドラインPHP
コマンドラインで動くやつ。

コマンドライン引数へのアクセス
php weather2 19096
  の場合、argv[0]がweather2 argv[1]が19096になる。

例)
Yahoo! Weather APIを使って、郵便番号から取得した地域の現在の天候を出力する。
<?php
if (isset($_SERVER['argv'][1])) {
  $zip = $_SERVER['argv'][1];
} else {
  print "Please specify a zip code.\n";
  exit();
}

// YQLクエリっていうらしい
$yql = 'select item.condition from weather forecast where woeid in '.'(select woeid from geo.places(1) where text="'.$zip.'")';
// Yahoo! YQLクエリエンドポイントがリクエストするパラメータ つまり？
$params = array("q" => $yql, 'format' => 'json', 'env' => 'store://datatables.org/alltableswithkeys');
// クエリパラメータを付加して YQL URL を作成
$url = 'https://query.yahooapis.com/v1/public/yql?'.http_build_query($params);
$response = file_get_contents($url);
$json = json_decode($response);
$conditions = $json->query->results->channel->item->condition; // 内容はapiによる
print "At {$conditions->date} it is {$conditions->temp} degrees and {$conditions->text} inj $zip\n";
?>
あとはコマンドラインで php weather2 19096 したらzipcode19096の天気を取得できる

php -S localhost:8000
  -SでPHPの組み込みWebサーバの使用(今回は8000)
php -S localhost:8000 -t /home/mario/web
  -tはドキュメントルートディレクトリの変更

組み込みWebサーバでPHP REPLの利用 javascirptやrubyのconsole的な
テストや実験に適する
php -aで起動 以降、php >プロンプトで実行できる

% php -a
Interactive shell

php > print strlen('mushrooms');
9
php > $releases = simplexml_load_file("https://secure.php.net/releases/feed.php");
php > print $releases->entry[0]->title;
PHP 7.0.5 released!
php >


PsySH
  組み込みじゃないREPL的なやつもある
インストール
  php composer.phar global require psy/psysh
  globalにしたのは、パッケージごとのディレクトリではなくComposerディレクトリにインストールしたいので