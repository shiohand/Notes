# jQueryによるAJAX
$.ajax()
$.get()
$.post()
.load()
$.getJSON()
$.getScript()
$.serialize()
.serializeArray()
.ajaxSetup()
\- AJAX通信のデフォルト設定

## ajaxとは
Asynchronous JavaScript and XML
* 非同期
\- 通信中もブラウザの他の動作をブロックしない
* セキュリティ
\- 同じドメイン(プロトコル, ポート, ホスト)のサーバーとのみ通信
\- 例外あり
* データの受け取り方
\- 戻り値として値が返ってくるのとは違うため、毎回返ってきたデータの中身を利用した処理を走らせる

## 実行のための基本メソッド
ajax()関数で実行 または、それをさらに簡素化したショートカット用関数で実行

ajax()

load()
get()
post()
getJSON()
getScript()

param()
serialize()
serializeArray()

## 基本の記述

### sample1

```html
<button id="sample1" type="button">サンプル1</button>
```

```js
$("#sample1").on("click", function() {
  $.ajax({
    url: 'sample1.txt',
    type: "GET",
    dataType: "text",
    success: function(data) {
      console.log(data);
    }
  });
});
```

### sample2

```html
<button id="sample2" type="button">サンプル2</button>
```

```js
$("#sample1").on("click", function() {
  $.ajax({
    url: 'sample2.json',  // {"lastName":"Yamada","firstName":"Tarou"}
    type: "GET",
    dataType: "json",
    success: function(data) {
      console.log("こんにちは、" + data.lastName + " " + data.firstName + "さん");
      // こんにちは、YamadaTarouさん
    }
  });
});
```

### sample3

```html
<button id="sample3" type="button">サンプル3</button>
```

```js
$("#sample3").on("click", function() {
  $.ajax({
    url: 'sample3.php',
    type: "POST",
    dataType: "json",
    data: {
      "myname": 'yamada',
      "mypass": 'abcde'
    },
    success: function(data) {
      if (data.resultl === "OK") {
        console.log(data.message);
      } else {
        console.log("ログイン失敗");
      }
    }
  });
})
```

```php
$ret = array();
$ret['result'] = "NG";

if ($_POST['myname'] == 'yamada' && $_POST['mypass'] == 'abcde') {
  $ret['result'] = "OK";
  $ret['message'] = "ようこそ".$_POST['myname'];

  header("Content-Type: application/json; charset=utf-8");
  // echo json_encode($ret);
}
```

## ajax()
* jQuery.ajax(url[, setting])  settingはオブジェクト形式で設定

| setting    |-
|-           |-
| url        | 通信先、デフォルトは現在のページ
| type       | methodでもよし。"GET"と"POST"
| data       | 送信するデータ 文字列(クエリ文字列)やオブジェクト形式
| dataType   | 受信するデータのタイプ 自動判別もできるがちゃんと指定する
| beforeSend | 通信開始前に関数を実行
| success    | 通信成功時
| error      | 通信失敗時
| complete   | 通信終了時 errorのときもこれは呼ばれる
| timeout    | タイムアウトの設定 デフォルトは0
| cache      | GETのときキャッシュを利用する 最新のデータを取得したいならfalse デフォルトtrue

### dataType
| dataType |-
|-         |-
| text     | プレーンテキスト
| html     | HTMLデータをプレーンテキストで
| xml      | xmlのドキュメントオブジェクト
| json     | コールバックのdataで、解析後のJSONオブジェクトとして受け取れる(自動perseJSON()的な)
| jsonp    | JSONP使用時 JSONオブジェクト
| script   | scriptはとしてコールバックの前に実行される ドメイン縛りを回避できる

### beforeSend()
* beforeSend(jqXHR, settings)
カスタムヘッダーや通信前の前処理 return false;で通信のキャンセル
  * jqXHR
  \- jQuery用の拡張XMLHttpRequest
  * settings
  \- 普通の

### success()
* success(data, textStatus, jqXHR)
  * data  
    \- 受信したデータ(dataTypeの指定による)
  * textStatus
  \- jQuery用のステータスコード(だいたい'success')
  * jqXHR

### error()
scriptは内容に構文エラーがあっても無視されるよ
* error(jqXHR, textStatus, errorThrown)
  * jqXHR
  * textStatus
  \- jQuery用のステータスコード('timeout', 'error', 'abort', 'parsererror(スペル注意)')
  * error
  \- 投げられたエラー

### complete()
* complete(jqXHR, textStatus) // 引数確認する
  * jqXHR
  * textStatus
  \- jQuery用のステータスコード('success', 'notmodified', 'timeout', 'error', 'abort', 'parsererror(スペル注意)')

## get(), post()
type(またはmethod)にgetやpostを指定した状態

* get(url[, data][, success(data, textStatus, jqXHR)][, dataType])
* post(url[, data][, success(data, textStatus, jqXHR)][, dataType])

```js
$.get('test.html', function(data) {
  $('#result').html(data);
});
```

## load()
要素内に取得したコンテンツをHTMLとして入れ込む。置換する。

* load(url[, data][, complete(responseText, textStatus, XMLHttpRequest)])
  * url
  \- 取得したいURL
  \- 取得したい範囲を指定する場合は、"URL セレクタ"の形式で指定
  * data
  \- 送信するデータの指定
  \- クエリストリング形式の文字列(GETになる)、または通常のオブジェクト(POSTになる)
  * complete
  \- マッチした要素が置換されるときに一つずつ呼び出される
  \- 関数内ではthisで各要素を使える

```js
// #result <- test.html
$('#result').load('test.html');
// #result <- test.html の #container
$('#result').load('test.html #container');
```

### 取得したコンテンツにスクリプトを含む場合
\- セレクターを使用していない(コンテンツのすべてを取り込み)場合は実行される
\- セレクターを使用した場合は実行されない
### 取得先のドキュメントとの同一性
\- jQueryが解析する際に不要な要素を除去する場合があるため、同一とは限らない
ver3.0より前はイベントにもload()があったが別物

## getJSON(), getScript()
dataTypeまで指定した状態のget()

* getJSON(url[, data][success(data, textStatus, jqXHR)])

```js
$.getJSON('test.html', function(data) {
  console.log("こんにちは、" + data.lastName + " " + data.firstName + "さん");
});
```


* getScript(url[success(data, textStatus, jqXHR)])
\- 動的にスクリプトを取得して実行する(グローバル領域で)
\- 当然ドメイン縛りがない

```js
$.getScript("urlurl/url.js");
```

## serialize(), serializeArray(), param()
AJAXの機能というわけじゃないが合わせて使うとうれしい

### serialize()
フォーム要素からクエリ文字列を返す

* URLエンコードも自動で行われる
* "successful controls"(checked="false"やdisabledを除く)のみを対象
* ファイル選択ボックスは対象外
* name属性を使うので設定忘れず

```html
<form id="seri_form">
  <input type="text" name="mytext">

  <label><input type="checkbox" name="mychk" value="strawberry">いちご</label>
  <label><input type="checkbox" name="mychk" value="orange">みかん</label>
  <label><input type="checkbox" name="mychk" value="apple">りんご</label>

  <label><input type="radio" id="radio" name="myrdo" value="taro">太郎</label>
  <label><input type="radio" id="radio2" name="myrdo" value="jiro">次郎</label>

  <input type="button" id="seri_btn" value="表示">
</form>
```

```js
$("#seri_btn").on("click", function(event) {
  let data = $("#seri_form").serialize();
  // 一部のみをシリアライズ
  let pickup = $("input, textarea, select").serialize();

  // そのままdata引数で渡せる
  $.get('url', data, function() {
    // 処理;
  });
});
```

### serializeArray()
フォーム要素からオブジェクトの配列を返す オブジェクトの形式が独特

* URLエンコードは自動じゃないけど、data引数に渡すならそっちでもエンコするので不要
* オブジェクトは{name:キー, value:値}となる {キー:値}ではない
\- チェックボックスなどでは一つのnameに対して複数の値がcheckedになるため

```js
// 配列の形式
[
  {name:"key1", value:"value1"}, // key1: value1ではない
  {name:"key2", value:"value2"}
];
$("#seri_btn").on("click", function(event) {
  let data = $("#seri_form").serializeArray();

  // そのままdata引数で(ry
  // ただし、公式ではクエリ文字列かオブジェクトとしか書いてないらしい
  $.ajax({
    url: 'url',
    type: 'POST',
    data: data,
    dataType: 'text'
  })
});
```

### param()
第一引数(オブジェクトか配列)で渡されたデータをクエリ文字列にして返す
フォームではserialize()、それ以外はparam()という感じ

* param(obj[, traditional = false])
URLエンコードも自動で行われる

```js
let obj = {
  firstName: 'Taro',
  lastName: 'Yamada'
};
let mydata = $.param(obj);

$.ajax({
  url: 'xxx.php',
  type: 'GET',
  data: mydata,
});
```

PHPなど受け取り側の形式に合わせれば階層構造を表現できるが、JSONを使う方が良いかも
traditionalもそれ関係

```js
let obj = {
  name: {
    firstName: 'Taro',
    lastName: 'Yamada'
  },
  age: 35
};
$.param(obj);
// name[firstName]=Taro&
// name[lastName]=Yamada&
// age=35
// みやすさのために改行つき
```

### 配列を送信するには

勝手にやってくれる

```js
let list = ['a', 'b', 'c'];
$.ajax({
  url: 'xxx.php',
  type: 'GET',
  data: list, // list[]=a&list[]b&=list[]=c PHP向き？
});
$.ajax({
  url: 'xxx.php',
  type: 'GET',
  data: list, // list=a&list=b&list=c Perl向き？
  traditional: true // trueだとこうなる
});
```

## ajaxSetup()
ajaxメソッドの引数のデフォルト値を設定 get()や派生メソッドにも反映
ただし、デフォ値の上書きはちょっと不具合リスクなので、特に複数人での開発では毎回書く

```js
$.ajaxSetup({
  url: 'url.php',
  timeout: 5000,
  dataType: 'json'
});
```

## ajaxのイベント
### ローカルイベント
* ローカルイベント(これまでajax通信ごとに設定してきたコールバック)
\- beforeSend, success, error, complete

### グローバルイベント
* グローバルイベント(普通のイベント $(document)につける)
  * イベントタイプ
  \- ajaxSend, ajaxSuccess, ajaxError, ajaxComplete,
  \- ajaxStart, ajaxStop
  * ショートカット用メソッド
  \- ajaxSend(), ajaxSuccess(), ajaxError(), ajaxComplete(),
  \- ajaxStart(), ajaxStop()

#### イベントのタイミングの例
ajaxStart       // 一連の通信
\- ajaxSend      // 通信1
\- ajaxSend      // 通信2
\- ajaxComplete  // 通信1
\- ajaxComplete  // 通信2
ajaxStop        // 一連の通信

#### グローバルイベントでコールバックが受け取る引数
* "ajaxSend"
* "ajaxSuccess"
* "ajaxComplete"
\- (eventObj, jqXHR, 個々のajax()とかで指定したoptions)
* "ajaxError"
\- (eventObj, jqXHR, 個々のajax()とかで指定したoptions, Errorオブジェクト)
* "ajaxStart"
* "ajaxStop"
\- () 引数なし

#### ローディングアイコンの処理
全てのajax通信中に表示する

```js
$(document).on({
  ajaxStart: function() {
    $("loading_icon").show();
  },
  ajaxStop: function() {
    $("loading_icon").hide();
  },
});
```

#### グローバルイベントを発生させない
$.ajax()系のオプションに{global: false}を設定

#### Promiseによるコールバック関数の指定</h4>  使いたいときに

```js
let promise = $.ajax({
  url: 'xxx.php',
  type: 'GET',
  dataType: 'json'
});
promise.done(function() { /* 成功時 */ })
promise.fail(function() { /* 失敗時 */ })
```