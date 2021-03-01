# MySQL

## コマンド

起動

起動
mysql -u root -p


CREATE DATABASE quick_laravel CHARACTER SET utf8;
GRANT ALL PRIVILEGES ON quick_laravel.* TO quickusr@logalhost IDENTIFIED BY 'quickpass';

使用するデータベースに変更
USE quick_laravel;
インポート
source c:\quick.sql