# XxxController

## シングルアクションコントローラ

```php
/* web.php */
Route::get('/hellosingle', [HelloSingleController::class]);
/* HelloSingleController.php */
public function __invoke() {}
```

## ルートパラメータの利用

```php
/* web.php */
Route::get('/hello/{id}/{pass?}', [HelloController::class, 'index']);
/* HelloController.php */
public function index(Request $request, $id, $pass='unknown') {}
```
## Requestの主なメソッド

| input系                       | - |
| ----------------------------- | - |
| all()                         | 全ての入力 |
| input()                       | ファイルを除いた全ての入力 |
| input(キー)                   | 指定したキーの入力 |
| input(キー[, デフォルト値])   | デフォルト値設定 |
| query()                       | クエリストリングのみの入力 |
| query(キー)                   | 指定したキーの入力 |
| query(キー[, デフォルト値])   | デフォルト値設定 |
| file(キー)                    | 指定したファイルを取得 |
| boolean(キー)                 | 1、"1"、true、"true"、"on"、"yes"とか |
| only(...キーまたは配列)       | 指定したキーのみ |
| except(...キーまたは配列)     | 指定したキー以外 |
| has(キーまたは配列)           | bool 指定したキーのすべてが存在するか |
| hasAny(配列)                  | bool 指定したキーのいずれかが存在するか |
| hadfile(キー)                 | bool 指定したキーにファイルが存在するか |
| filled(キーまたは配列？)      | bool 指定したキーに値が存在し、空でないか |
| flush()                       | 全ての入力をフラッシュに保存 |
| flushOnly(キーまたは配列)     | 選択したキーのみ保存 |
| flushExcept(キーまたは配列？) | 選択したキー以外保存 パスワードなど |

* inputのキーは、値が配列の場合は`names.2`などドット記法で選択可能
* フラッシュデータはバリデーション失敗時に前の値を保持するためのやつ セッションを利用
* 入力は`$request`の動的プロパティとして呼び出し可能 `$request->キー`

| パス      | - |
| --------- | - |
| url()     | URL(クエリ文字列を含まない) |
| fullUrl() | URL |
| root()    | ルートディレクトリまで |
| path()    | ルートディレクトリより後 ルーティングで書くやつ |

| メソッド           | - |
| ------------------ | - |
| is(パターン)       | bool リクエストURIが指定したパターンにあうか |
| method()           | `POST`か`GET` |
| isMethod(メソッド) | bool postとかPOSTとか？ |

* パターンは文字列で、ワイルドカードあり('hello/*', '*/hello')など

## RedirectResponseクラス

| メソッド                           | - |
| ---------------------------------- | - |
| header(ヘッダ名, 内容)             | ヘッダ情報の追加 |
| withHeaders([ヘッダ名 => 内容...]) | ヘッダ情報の一括追加 |
| cookie(キー, 値)                   | 第三引数以降 `$minutes, $path, $domain, $secure, $httpOnly` |
| withCookie(Cookieの配列)           | クッキーを付加する |
| withCookies(Cookieの配列)          | 複数のクッキーを付加する |
| withInput()                        | フォームの値などinputを持ち越す |
| withErrors(MessageProvider)        | エラーメッセージを持ち越す |

### ResponseFactoryクラス

| メソッド                     | - |
| ---------------------------- | - |
| view(テンプレート名[, 配列]) | テンプレート |
| json(配列)                   | JSON |
| download(パス[, ファイル名]) | ファイル名はダウンロード時の |
| file(パス)                   | 表示のみ(画像とかPDFとか) |

### Redirectorクラス

| メソッド                               | - |
| -------------------------------------- | - |
| back()                                 | 直前のページ |
| refresh()                              | 現在のページ |
| route(ルート名[, ルートパラメータ])    | 名前付きルート |
| action(アクション[, ルートパラメータ]) | アクションを指定 |
| json(テキスト)                         | JSON |
| away(パス)                             | 外部のページ |
