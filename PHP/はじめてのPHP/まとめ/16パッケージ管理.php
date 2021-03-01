Composerのインストール
普通に公式からダウンロード・インストール
コマンドでダウンロード・実行
  curl -sS https://getcomposer.org/installer | php

composer.json
  プロジェクトに関する設定やインストールしたパッケージを管理
composer.lock
  パッケージのバージョンを管理

プログラムへパッケージを追加(今回はSwiftMailer)
コマンドでインストール
  php composer.phar require swiftmailer/swiftmailer
    現在地のvendorディレクトリにインストールし、composer.jsonを更新する
  おわり！もう使える。 // require "vendor/autoload.php";

バージョン管理システムと連携
  composer.json, composer.lockだけ同期
  php composer.phar install コマンドで他の人も同じパッケージが揃えられる

Composerパッケージリポジトリ(利用可能パッケージの一覧サイト)
  Packagist キーワード検索できる。