# Laravelをはじめる

- [導入](#導入)
- [Laravelでの開発の流れ](#laravelでの開発の流れ)
  - [プロジェクトの作成](#プロジェクトの作成)
  - [サーバーを実行](#サーバーを実行)
  - [gitからクローンしてきたあと](#gitからクローンしてきたあと)
  - [デプロイ](#デプロイ)
- [アプリケーションの構成](#アプリケーションの構成)
  - [appフォルダ](#appフォルダ)
  - [ファザード](#ファザード)

Laravel6はPHP7.2以降

## 導入
コマンドライン

```
> composer self-update
> composer global require Laravel/installer
```

パス C:\Users\なまえ\Appdata\Roaming\Composer\vendor\bin

## Laravelでの開発の流れ

* プロジェクトの作成
* プログラミング
* サーバーで実行(Laravelに内蔵)
* デプロイ(本番環境にアップロード)

### プロジェクトの作成
ディレクトリに移動
```
> Laravel new [プロジェクト名]
```

もしくはcomposerから
```
> composer create-project laravel/laravel [プロジェクト名] --prefer-dist
```

### サーバーを実行
```
> php artisan serve
```
localhost:8000にアクセスして起動を確認
つけっぱにしておいて、終了時はctrl+[c]

### gitからクローンしてきたあと
'なんたらartisan on line 18'エラー
githubからクローンしてきたときとか、環境の違いでvendorが不足するので追加
環境ごとに変わるのでこれら関連は初期状態でgitignoreに入ってくれている

```
copy .env.example .env
php artisan key:generate
php artisan cache:clear
```

これらの意味
https://qiita.com/chimayu/items/82d9d457a056829b3b2e
https://mebee.info/2020/04/28/post-9674/
http://vdeep.net/laravel-git-clone

### デプロイ
* プロジェクトフォルダをhtdocsにドーン

プロジェクト名/public が公開されるWebページの入るフォルダ
URLは `http://[プロジェクト名]/public/[ファイル名]` となる

`http://[プロジェクト名]/[ファイル名]`で表示できるようにするなどの変更は httpd.conf ファイルで

xampp/apache/conf/httpd.conf の末尾に追記

```xml
Alias / "[xamppまでのパス]/xampp/htdocs/[プロジェクト名]/public/"
<Directory "/xampp/htdocs/[プロジェクト名]/public/">
  Options Indexes FollowSymLinks MultiViews
  AllowOverride all
  Order allow,deny
  Allow from all
</Directory>
```

## アプリケーションの構成
Laravelアプリケーションの中身

| フォルダ  | 内容 |
| --------- | - |
| app       | ★ アプリケーションのプログラム部分 |
| bootstrap | アプリケーション実行時の最初の処理のまとまり。cssのあれではない |
| config    | 設定関係のファイル |
| database  | データベース関連ファイル |
| public    | 外部にそのまま公開されるファイルが入る |
| resources | ★ プログラムに使用するリソースとか |
| routes    | ★ ルート情報 ルーティング |
| storage   | アプリケーションやプログラムが保存する、ログファイルなどいろいろ |
| tests     | ユニットテスト関係のファイル |
| vendor    | フレームワーク本体のプログラム |

開発時には app にスクリプトファイルを追加

| ファイル名                      | 内容 |
| ------------------------------- | - |
| .editorConfig                   | エディタに関する汎用設定ファイル |
| .env, .env.example              | 動作環境に関する設定 |
| .gitattributes, .gitignore      | git利用に関する情報 |
| .styleci.yml                    | StyleCi(コードチェッカー)のファイル |
| artisan                         | サーバー実行で使うコマンド |
| composer.json, composer.lock    | composerの利用に関するファイル |
| package.json, package-lock.json | npmで利用する |
| phpunit.xml                     | PHPUnitに関するファイル |
| esrver.php                      | サーバー起動時用のプログラム |
| webpack.mix.js                  | webpack(JavaScriptパッケージツール)で利用する |
| yam.lock                        | yam(パッケージマネージャ)のファイル |

### appフォルダ

| フォルダ   | 内容 |
| ---------- | - |
| Console    | コンソールプログラム |
| Exceptions | 例外処理 |
| Http       | アクセスしたときの処理<br>基本的なプログラムはここに |
| Providors  | プロバイダと呼ばれるプログラムを配置 |
| User.php   | ユーザー認証に関するスクリプト                       |

### ファザード

組み込まれている各種の機能を簡単に呼び出すためのクラス