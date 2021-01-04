# Laravelをはじめる

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
`> Laravel new [プロジェクト名]`

もしくはcomposerから
`> composer create-project laravel/laravel [プロジェクト名] --prefer-dist`

### サーバーを実行
`> php artisan serve`
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
- プロジェクトフォルダをhtdocsにドーン

プロジェクト名/public が公開されるWebページの入るフォルダ
URLは "http://[プロジェクト名]/public/[ファイル名]" となる

"http://[プロジェクト名]/[ファイル名]"で表示できるようにするなどの変更は httpd.conf ファイルで

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

