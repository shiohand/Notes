# XMLHttpRequest

- [XMLHttpRequest](#xmlhttprequest)
- [statusの内容](#statusの内容)
- [リクエストの初期化・送信](#リクエストの初期化送信)
- [JSONP(死語)](#jsonp死語)

## XMLHttpRequest
newして使う
クロスオリジン通信はセキュリティのために制限される なのでphpなどを経由する プロキシ的な

| prop               | w   | -                            |
| ------------------ | --- | ---------------------------- |
| response           |     | レスポンス                   |
| readyState         |     | 通信の状態                   |
| responseText       |     | テキストとして取得           |
| responseXML        |     | XMLとして取得                |
| status             |     | HTTPステータスコード         |
| statusText         |     | HTTPステータの詳細メッセージ |
| responseType       | w   | レスポンスの型               |
| timeout            | w   | 自動終了までの時間           |
| withCredentials    | w   | クロスオリジン通信の認証送信 |
| onreadystatechange | w   | 通信の状態の変化時           |
| ontimeout          | w   | タイムアウト時               |

| s   | メソッド                        | -                            |
| --- | ------------------------------- | ---------------------------- |
|     | open(省略)                      | リクエストの初期化           |
|     | send(body)                      | リクエストの送信             |
|     | abort()                         | 非同期通信を中断             |
| s   | getAllResponseHeaders()         | すべてのレスポンスのヘッダー |
| s   | getResponseHeader(header)       | 指定したレスポンスのヘッダー |
|     | setRequestHeader(header, value) | リクエストのヘッダー追加     |
s は成功時のみ

| イベント  | -              |
| --------- | -------------- |
| loadstart | リクエスト送信 |
| progress  | 送受信中       |
| timeout   | タイムアウト   |
| abort     | 中断           |
| load      | 成功           |
| error     | エラー         |
| loadend   | リクエスト完了 |

## statusの内容

だいたい
| readyStatus | -      |
| ----------- | ------ |
| 4以外       | 通信中 |
| 4           | 完了   |

| status  | -      |
| ------- | ------ |
| 200以外 | エラー |
| 200     | 成功   |

詳細

| readyStatus | -                                               |
| ----------- | ----------------------------------------------- |
| 0           | 未初期化 open()前                               |
| 1           | ロード中 open()後、send()前                     |
| 2           | ロード済 send()後                               |
| 3           | レスポンス一部取得 応答ステータスとヘッダーまで |
| 4           | レスポンス取得済み レスポンス本体まで           |

| status | -                     |
| ------ | --------------------- |
| 200    | OK                    |
| 401    | Unauthorized          |
| 403    | Forbidden             |
| 404    | NotFound              |
| 500    | Internal Server Error |
| 503    | Service Unavailable   |


## リクエストの初期化・送信

* xhr.open(method, url[, async[, user[, password]]])

| 引数     | -                                                       |
| -------- | ------------------------------------------------------- |
| xhr      | XMLHttpRequestオブジェクト                              |
| method   | HTTPメソッド(GET, POST, PUT, DELETEなど)                |
| url      | アクセス先URL クロスオリジンしないので経由するphpなどに |
| async    | true 非同期通信か                                       |
| user     | 認証時ユーザー名                                        |
| password | 認証時パスワード                                        |

* xhr.send(body)

引数
body
POSTの場合にリクエストの本体を指定 文字列の作り方はクエリと同じ('?'は不要)
GETはクエリで送るのでここはnull


## JSONP(死語)

ク゛ロ゛ス゛オ゛リ゛ジ゛ン゛し゛た゛い゛！゛！゛！゛！゛！゛
-> JSONP (JSON with Padding)
1. `<script src=""></script>`でなら外部サーバーのスクリプト呼べることを利用
1. 処理用の関数作る
1. クリックイベントとかで`<script src="うらる?callback=処理用の関数&key=..."></script>`とかする
1. 向こうが 処理用の関数(向こうのデータ); を実行するスクリプトになってくれる
1. 特別なこともなくscriptが実行される
1. わーい
1. え？CSRF？
1. (静かなる死)
