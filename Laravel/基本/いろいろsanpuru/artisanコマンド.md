# 生成まとめ

- [ルーティング](#ルーティング)
- [コントローラ](#コントローラ)
- [ビュー](#ビュー)
- [サービスプロバイダ](#サービスプロバイダ)
- [ミドルウェア](#ミドルウェア)
- [フォーム](#フォーム)
  - [フォームリクエスト](#フォームリクエスト)
  - [ルール](#ルール)
- [データベース](#データベース)
  - [導入](#導入)
  - [モデル](#モデル)
  - [モデルファクトリー](#モデルファクトリー)
  - [セッションテーブル](#セッションテーブル)
  - [マイグレーション シーディング](#マイグレーション-シーディング)
- [テスト](#テスト)
- [認証](#認証)
- [hoka](#hoka)

## ルーティング
`routes/web.php`

## コントローラ
`php artisan make:controller XxxController`
`app/Http/Controllers/XxxController.php`

リソースコントローラ
`php artisan make:controller --resource`

## ビュー
レイアウト
`resource/views/layouts/コントローラ名app.blade.php`
ビュー
`resource/views/コントローラ名/アクション名.blade.php`

## サービスプロバイダ
`php artisan make:provider XxxServiceProvidor`
`app/Providers/XxxServiceProvidor.php`

ServiceProviderを登録
`config/app.php`
`providers`の値である配列に`\App\Providers\XxxServiceProvider::class`

## ミドルウェア

`php artisan make:middleware XxxMiddleware`
`app/Http/Middleware/XxxMiddleware.php`

登録
`app/Http/Kernel.php`
`$routeMiddleware`に`'ミドルウェア名' => XxxMiddleware::class`
グループ
`$middlewareGroups` に`'グループ名' => [...ミドルウェアクラス],`
グローバル
`$middleware`に`\App\Http\Middleware\HelloMiddleware::class`

web.phpで利用
`Route::get('hello', [HelloController::class, 'index'])->middleware('ミドルウェア名');`


## フォーム

### フォームリクエスト
`php artisan make:request XxxRequest`
`app/Http/Request/XxxRequest.php`

アクションの引数をXxxRequestに差し替える

### ルール
`php artisan make:rule 名前`
`app/Rules/名前.php`


## データベース

### 導入
`laravelapp/database`内にsqliteファイル作成

`config/database.php`の`'default' => env('DB_CONNECTION', 'mysql')`を使用するデータベースに

環境変数の設定
`.env`の`DB_CONNECTION`に利用するデータベースを設定
SQLiteの場合、他はSQLiteのデフォルト値を利用するため、DB_HOSTからDB_PASSWORDまでを競合しないように削除

### モデル
`php artisan make:model Xxx`
`app/Models/Xxx.php`

モデル用コントローラ？
`php artisan make:controller XxxController`

主キー変更
`$primaryKey`に文字列かその配列

### モデルファクトリー
`php artisan make:factory XxxFactory --model=Xxx`
`database/factories/XxxFactory.php`

### セッションテーブル
`php artisan session:table`

### マイグレーション シーディング
`php artisan make:migration create_xxx_table`
`database/migrations/日付_テーブル名_table.php`

`php artisan migrate`

`php artisan make:seeder create_xxx_table`
`database/seeds/xxxTableSeeder.php`

`php artisan db:seed`
`php artisan db:seed --class=XxxSeeder`

マイグレーションを全てロールバックして再構築、シーディング
`php artisan migrate:refresh --seed`
データベースを全て削除して再構築、シーディング
`php artisan migrate:fresh --seed`

## テスト
`php artisan make:test XxxTest`
`tests/Feature/XxxTest.php`

ターミナルで`vendor\bin\phpunit`を実行

## 認証
セットアップ

## hoka

モデルとファクトリー個別に生成する
`php artisan make:model Post`
`php artisan make:factory PostFactory --model=Post`

モデルとファクトリーを生成する
`php artisan make:model Post --factory`
`php artisan make:model Post -f # 省略オプション`

モデルとファクトリー、マイグレーション、シーダー、コントローラを生成する
`php artisan make:model Post --all`
`php artisan make:model Post -a # 省略オプション`