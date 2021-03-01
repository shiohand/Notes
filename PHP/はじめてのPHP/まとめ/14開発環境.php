バージョン管理
  Git

管理しやすくする規約
  PSR-4 (PHP Standard Recommendation (PHP標準勧告))
  ファイル名とクラス名を一致させる(Java的な) １ファイル１クラス
  名前空間とディレクトリ構造を一致させる(Javaのパッケージ的な)

課題管理(イシュートラッキング)システム
  バグ、機能要求、対処する必要のある作業リストの保持
  作業の担当者への割り当て
  優先度, 推定時間, 進捗・完了状況, コメントなどと作業の関連付け
  課題背景のソート、検索、理解

  課題にIDを割り当てる。
  関連するコードを書くときなどに付記して区別でき、便利。

  管理システムはいろいろあるが、MantisBTはPHPで作られていてメジャー

環境とデプロイ(本番環境への反映)
  開発環境と本番環境をわける。
  開発環境
    ローカル
  本番環境
    クラウドホスティングプロバイダやデータセンターのサーバ上に構築
    AWSやGCPなど
  環境固有の構成情報とコードは分離させる
    構成情報は別ファイルで管理、プログラムは構成ファイルを読み込んで利用
  parse_ini_file(ファイル名)
    iniファイルをロード、連想配列として設定値を返す

  parse_ini_file(ファイル名)の利用
  // config.ini
    ; データベース情報
    dsn="mysql:host=db.dev.example.com;dbname=devsnacks"
    dbuser=devuser
    dbpassword=raisins
  // 構成ファイルの読み込み
    $config = parse_ini_file('config.ini')
    $db = new PDO($config['dsn'], $config['dbuser'], $config['dbpassword']);

PHPエンジンのパフォーマンスデータの収集
  プロファイラを利用(Xdebug, XHProfなど)