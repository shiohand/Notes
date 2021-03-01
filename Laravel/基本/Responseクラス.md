# Responseクラス

## レスポンスオブジェクトの作成

view(テンプレート名[, 配列])やredirect(パス)は、簡易にreturnできるように用意されたヘルパ関数

ヘッダーを付与する場合など、レスポンスを加工したい場合はレスポンス関連のオブジェクトを利用する

レスポンスオブジェクトはだいたいメソッドチェーン設定していく
(ResponseFactoryクラスとRedirectorクラスは別)

* `response(コンテンツ, ステータスコード)`
\- Responseクラス
* `redirect(パス)`
\- RedirectResponseクラス
* `response()`
\- ResponseFactoryクラス
* `redirect()`
\- Redirectorクラス

## Responseクラス

| メソッド                           | - |
| ---------------------------------- | - |
| header(ヘッダ名, 内容)             | ヘッダ情報の追加 |
| withHeaders([ヘッダ名 => 内容...]) | ヘッダ情報の一括追加 |
| cookie(キー, 値)                   | 第三引数以降 `$minutes, $path, $domain, $secure, $httpOnly` |
| withCookie(Cookieの配列)           | クッキーを付加する |

* バリデーション.mdのバリデータの生成と動作設定でちょっとやった
* MessageProviderはValidatorとかが使ってるインターフェース

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

## ResponseFactoryクラス

| メソッド                     | - |
| ---------------------------- | - |
| view(テンプレート名[, 配列]) | テンプレート |
| json(配列)                   | JSON |
| download(パス[, ファイル名]) | ファイル名はダウンロード時の |
| file(パス)                   | 表示のみ(画像とかPDFとか) |

## Redirectorクラス

| メソッド                               | - |
| -------------------------------------- | - |
| back()                                 | 直前のページ |
| refresh()                              | 現在のページ |
| route(ルート名[, ルートパラメータ])    | 名前付きルート |
| action(アクション[, ルートパラメータ]) | アクションを指定 |
| json(テキスト)                         | JSON |
| away(パス)                             | 外部のページ |
