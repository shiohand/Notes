# HTTP経由

- [モジュールの用意](#モジュールの用意)
- [HttpClient](#httpclient)
  - [HttpRequest](#httprequest)
  - [HttpResponse](#httpresponse)
  - [HttpClient.Builder](#httpclientbuilder)
  - [HttpRequest.Builder](#httprequestbuilder)
  - [HttpResponse.BodyHandler<T>](#httpresponsebodyhandlert)
  - [URI](#uri)
- [HTTP POST](#http-post)
  - [HttpRequest.BodyPublishers](#httprequestbodypublishers)

## モジュールの用意

java11移行ではHttpClientクラスを利用

java.net.httpモジュールの適用

```
module もじゅーる {
  requires java.net.http;
}
```

## HttpClient

| メソッド         | -                                         |
| ---------------- | ----------------------------------------- |
| *newHttpClient() | HttpClient生成 newBuilder().build()と同じ |
| *newBuilder()    | Builderオブジェクト生成                   |

| メソッド                                            | -                                |
| --------------------------------------------------- | -------------------------------- |
| send(HttpRequest, HttpResponse.BodyHandler<T>)      | HttpResponse<T> リクエストを送信 |
| sendAsync(HttpRequest, HttpResponse.BodyHandler<T>) | CompletableFuture 非同期処理     |

CompletableFutureオブジェクト .thenAccept(処理する関数)

### HttpRequest

| メソッド           | -                                  |
| ------------------ | ---------------------------------- |
| *newBuilder([URI]) | HttpClient.Builderオブジェクト生成 |

### HttpResponse

| メソッド     | -                                              |
| ------------ | ---------------------------------------------- |
| body()       | 本文を取得 戻り値はsend()時のBodyHandlerによる |
| headers()    | HttpHeaders                                    |
| request()    | HttpRequest                                    |
| statusCode() | int ステータスコード                           |
| uri()        | URI                                            |

### HttpClient.Builder

| メソッド                             | -                                                |
| ------------------------------------ | ------------------------------------------------ |
| authenticator(Authenticator)         | 認証コード設定                                   |
| connectTimeout(Duration)             | タイムアウト時間設定                             |
| cookieHandler(CookieHandler)         | クッキー取得設定用ハンドラー                     |
| executor(Executor)                   | 非同期に使用するExecutor                         |
| followRedirects(HttpClient.Redirect) | サーバーが発行したリダイレクトに従うか指定       |
| priority(int)                        | HTTP/2リクエストの既定の優先度設定               |
| version(HttpClient.Version)          | 可能な場合に特定のHTTPプロトコルバージョンを要求 |
| build()                              | HttpClient生成                                   |

build()以外、戻り値はBuilder自身なのでメソッドチェーン可能

HttpClient
```java
var client = HttpClient.newBuilder()
  .version(HttpClient.Version.HTTP_1_1)
  .connectTimeout(Duration.parse("PT3S")) // タイムアウト3秒
  .build(); // 生成
```

### HttpRequest.Builder

| メソッド                        | -                                   |
| ------------------------------- | ----------------------------------- |
| DELETE()                        | リクエストメソッド設定              |
| GET()                           | リクエストメソッド設定 デフォルト   |
| POST(HttpRequest.BodyPublisher) | リクエストメソッド設定 受け取り処理 |
| PUT(HttpRequest.BodyPublisher)  | リクエストメソッド設定 受け取り処理 |
| setHeader(name, value)          | 上書き                              |
| header(name, value)             | 追加                                |
| headers(headers...)             | 追加                                |
| timeout(Duration)               | タイムアウト                        |
| uri(URI)                        | URI設定                             |
| version(HttpRequest.Version)    | HTTPバージョン設定                  |
| build()                         | HttpRequest生成                     |

### HttpResponse.BodyHandler<T>

取得したレスポンスの処理を行う

| メソッド                      | -              |
| ----------------------------- | -------------- |
| ofString([Charset])           | String         |
| ofLines()                     | Stream<String> |
| ofFile(path[, OpenOption...]) | Path           |
| ofInputStream()               | InputStream    |
| ofByteArray()                 | byte[]         |

HttpResponse
```java
var req = HttpRequest.newBuilder()
  .uri(URI.create("https://url/"))
  .build(); // 生成
var res = client.send(req, HttpResponse.BodyHandlers.ofString());
System.out.println(res.body());
```

非同期 sendAsync()
```java
var req = HttpRequest.newBuilder().build();
client.sendAsync(req, HttpResponse.BodyHandlers.ofString())
  .thenAccept(response -> {System.out.println(response.body())});
```

### URI

*create(str)
他

## HTTP POST

### HttpRequest.BodyPublishers

POST, PUTメソッドで利用 ofXxxxでリクエスト本体を生成

| メソッド                                       | -                         |
| ---------------------------------------------- | ------------------------- |
| ofBytearray(byte[][, offset, length])          | バイト配列の内容          |
| ofInputStream(Supplier<? extends InputStream>) | InputStreamから           |
| ofFile(path)                                   | ファイルの内容            |
| ofstring(str[, Charset])                       | 文字列 jsonとかで使うかな |

```java
var client = HttpClient.newHttpClient();
var req = HttpRequest.newBuilder()
  .uri(URI.create("https://uri/"))
  .header("Content-Type", "application/json")
  .POST(HttpRequest.BodyPublishers.ofString(  // HttpRequest.BodyPublishers
    "{\"name\" : \"人間の姓名\"}"))            // json形式のStringを作っているだけ
  .build();
var res = client.send(req, HttpResponse.BodyHandlers.ofString());
System.out.println(res.body());
```