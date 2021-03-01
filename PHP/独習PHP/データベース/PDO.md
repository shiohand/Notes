# PDO

- [PDO (PHP Data Objects)](#pdo-php-data-objects)
- [接続](#接続)
  - [dsn(データベース接続文字列)](#dsnデータベース接続文字列)
  - [接続パラメータの設定](#接続パラメータの設定)
  - [コード例](#コード例)
- [エラー情報を確認](#エラー情報を確認)
- [データベース操作](#データベース操作)
  - [オートインクリメント値の取得](#オートインクリメント値の取得)
- [データの取り出し](#データの取り出し)
- [トランザクション処理](#トランザクション処理)
- [接続パラメータ](#接続パラメータ)
  - [フェッチスタイル PDO::ATTR_DEFAULT_FETCH_MODE](#フェッチスタイル-pdoattr_default_fetch_mode)
  - [エラーモード変更](#エラーモード変更)
  - [他](#他)

## PDO (PHP Data Objects)
データベース抽象化レイヤ
初期状態では MySQL, MariaDB, SQLite, PostgreSQL(Linuxのみ) に対応(ドライバ追加で追加可能)

## 接続
```
$db = new PDO(dsn[, user[, password[, options]]]) // 戻り値 PDOオブジェクト
$db = null; // でなければ、スクリプト終了時に自動的に切断
```

### dsn(データベース接続文字列)
```
MySQL/MariaDB : mysql:host=127.0.0.1:port3307;dbname=データベース
                'mysql:dbname=selfphp; host=127.0.0.1; charset=utf8'など
SQLite3       : sqlite:データベース.sqlite
```
など

### 接続パラメータの設定

* PDO::setAttribute(接続パラメータ, 値)
\- 接続パラメータの書き換え
* PDO::getAttribute(接続パラメータ)
\- 読み取り

接続パラメータの詳細 下

### コード例

接続は関数作っておけば冗長回避
```php
function getDb() {
  $dsn = 'mysql:dbname=selfphp; host=127.0.0.1; charset=utf8';
  $usr = 'selfusr';
  $pw = 'selfpass';

  $db = new PDO($dsn, $usr, $pw);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // 例外モード
  return $db;
}

// 使う
try {
  $db = getDb();
} catch (PDOException $e) {
  print "接続エラー：{$e->getMessage()}";
} finally {
  $db = null;
}
```

## エラー情報を確認
* `$db->errorInfo() サイレントでのエラー取得など`
\- [0]一般エラー [1]使用中のデータベース固有のエラー [2]エラーメッセージ
* `$db->errorCode()`
\- エラーコード '00000'以外はエラー？

* PDO::ATTR_PERSISTENT
\- スクリプト終了後も少しの間切断せず、再利用できるようにして負荷を軽減する
\- (new PDO()の第4引数で有効にする [PDO::ATTR_PERSISTENT => true])

```php
try {
  $db = getDb();
  $db->exec('エラーを出す内容');
} catch (PDOException $e) {
  print "エラーコード：{$e->getCode()}<br>";
  print "エラーメッセージ：{$e->getMessage()}";
}
```

## データベース操作

メソッド|-
-|-
exec(SQL文)  | データベースの変更 戻り値は行数、失敗でfalse
query(SQL文) | データの取得 戻り値はPDOStatement
fetch()|PDOStatementから一つずつキーバリュー取得
fetchAll()|または全て連想配列で取得


### オートインクリメント値の取得
* `$db->lastInsertId()`
\- 直近のID値を取得

## データの取り出し

* `fetch([スタイル = PDO::FETCH_BOTH])`
\- 一行ずつ取り出し(ポインタが移動していく。次がなければfalse)
\- `while($row = $stt->fetch())` など
\- ※foreach($stt as $row) でもfetch()のように取り出せる
* fetchAll([スタイル = PDO::FETCH_BOTH])
\- 全行取り出し(配列で返す)
* fetchColumn([インデックス = 0])
\- 指定した列のみ取り出し
\- 実際はステートメントの段階で1件に絞られていることを前提に利用する

```php
$db->query('SELECT COUNT(*) FROM book');
print $stt->fetchColumn(); // など
fetchObject([クラス = 'strClass'[, コンストラクタに送るパラメータ]])
```

## トランザクション処理
$db->beginTransaction()

```php
$db->commit()
beginTransaction以降の変更はcommitが動くまで反映されない
```
```php
try {
  $db->beginTransaction();
  $db->exec("INSERT INTO book VALUES (...)");
  $db->exec("INSERT INTO book VALUES (2...)");
  $db->commit(); // ここで反映
} catch (PDOException $e) {
  print $e->getMessage();
}
```

## 接続パラメータ

### フェッチスタイル PDO::ATTR_DEFAULT_FETCH_MODE

| フェッチスタイル  | -                                                           |
| ----------------- | ----------------------------------------------------------- |
| PDO::FETCH_ASSOC  | `$row['dish_name'], $row['price'];` // キーが重複 -> 上書き |
| PDO::FETCH_NAMED  | `$row['dish_name'], $row['price'];` // キーが重複 -> 入れ子 |
| PDO::FETCH_NUM    | `$row[0], $row[1];`                                         |
| PDO::FETCH_OBJ    | `$row->dish_name, $row->price;`                             |
| PDO::FETCH_BOTH   | ASSOC, NUM                                                  |
| PDO::FETCH_COLUMN | `$row` (先頭の行の値のみ)                                   |
| PDO::FETCH_BOUND  | `$dish_name` (bindColumnで変数を適用後)                     |
| PDO::FETCH_CLASS  | `$row->dish_name`                                           |

または
クエリに setFetchMode() で指定
クエリからの取り出し時に fetch() らの引数で指定

| 他                | -                       |
| ----------------- | ----------------------- |
| PDO::FETCH_UNIQUE | // キーが重複 -> 上書き |
| PDO::FETCH_GROUP  | // キーが重複 -> 入れ子 |
下

### エラーモード変更

| エラーモード             | -      | -                |
| ------------------------ | ------ | ---------------- |
| PDO::ATTR_ERRMODE        | SILENT | 例外モード       |
| ->PDO::ERRMODE_SILENT    |        |
| ->PDO::ERRMODE_WARNING   |        | 警告エラーモード |
| ->PDO::ERRMODE_EXCEPTION |        | 例外エラーモード |

### 他

| 接続パラメータ           | -       | -                      |
| ------------------------ | ------- | ---------------------- |
| PDO::ATTR_AUTOCOMMIT     | true    | 自動コミット           |
| PDO::ATTR_TIMEOUT        |         |
| PDO::ATTR_CASE           | NATURAL | フィールド名の変換方法 |
| ->PDO::CASE_LOWER        |         |
| ->PDO::CASE_NATURAL      |         |
| ->PDO::CASE_UPPER        |         |
| PDO::ATTR_ORACLE_NULLS   | NATURAL | 空文字とnullの変換     |
| ->PDO::NULL_NATURAL      |         |
| ->PDO::NULL_EMPTY_STRING |         |
| ->PDO::NULL_TO_STRING    |         |
| PDO::ATTR_PERSISTENT     | false   | 持続的接続(下詳細)     |

| 読み取り専用                |
| --------------------------- |
| PDO::ATTR_DRIVER_NAME       |
| PDO::ATTR_CONNECTION_STATUS |
| PDO::ATTR_SERVER_INFO       |
| PDO::ATTR_SERVER_VERSION    |
| PDO::ATTR_CLIENT_VERSION    |