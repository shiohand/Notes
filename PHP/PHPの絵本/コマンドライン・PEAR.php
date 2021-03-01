
PEAR
拡張モジュールやアプリケーションが登録されたライブラリ
  ライブラリ、コード配布とパケージ管理、コード作成に関する標準スタイル、PHP拡張モジュール・コミュニティらいぶらり（PECL）
  コミュニティをサポートするためのWebサイト
  など
PECL
C言語で書かれた拡張モジュールが登録されたライブラリ
  もともとはPEARの最上位ノードの一つ。現在は独立。

PEARのパッケージの一部
  HTML_QuickForm2 HTML_Table
  HTTP2 HTTP_Download2
  Image_Text
  Mail
  PEAR_info
  Text_Password
  XML_Query2XML XML_Serializer

コマンドラインでのPHPの実行
  なんとか.phpを実行

標準入出力
  CLI環境で通常使われる入力方法
    STDIN  標準入力
    STDOUT 標準出力
    STDERR 標準エラー出力
<?php
// 標準入力からのデータ受け取り
$stdin = fgets(STDIN, 4096);
print $stdin;
?>

ファイル操作
ls -l コマンド パーミッションを確認
chmodコマンド パーミッションを変更する
chmod o+w     Otherに書き込み権限を与える
chmod g-r     Groupに読み込み権限を与えない
  続きはwebで

$_FILES['userfile']
  ['name']      アップロード前のファイル名
  ['type']      ファイルの種類(ブラウザが情報を提供しているときに限る)
  ['size']      アップロードファイルのサイズ
  ['tmp_name']  アップロードファイルのサーバー上で保存するための一時ファイル名
  ['error']     エラーコード取得

  XAMPPのフォルダ構成
  Apache  Apacheが格納されているフォルダ
  cgi-bin CGIスクリプト配置用
  htdocs  Apacheが公開するフォルダ(スタートメニューにもショートカットがある)
  mysql   データベース管理システム用(MySQLまたはMariaDB)
  perl    Perlが格納されているフォルダ 
  php     PHPが格納されているフォルダ
  以下略

データベースSQLite3を利用するための準備
php.iniのextension=php_pdo_sqlite.dllを有効可

PEARのインストール
  必要になったら。