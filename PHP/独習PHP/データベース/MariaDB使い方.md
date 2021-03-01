# MariaDB使い方

- [環境変数登録](#環境変数登録)
  - [ルートパスワード変更(12345)](#ルートパスワード変更12345)
  - [MariaDB monitor 起動と終了](#mariadb-monitor-起動と終了)
  - [通常利用のためのユーザを追加(selfusr, selfpass)](#通常利用のためのユーザを追加selfusr-selfpass)
- [デフォルトのデータベース](#デフォルトのデータベース)
  - [データベースの作成](#データベースの作成)
- [SQL命令](#sql命令)
  - [選択中のデータベースの操作](#選択中のデータベースの操作)

## 環境変数登録

### ルートパスワード変更(12345)
```
mysqladmin -u root password
New password: 新規パスワード
Confirm new password: 確認入力
```

### MariaDB monitor 起動と終了
```
mysql -u root -p
Enter password: パスワード
MariaDB [(none)]> 以降入力
MariaDB [(none)]> exit;
```

### 通常利用のためのユーザを追加(selfusr, selfpass)
```
GRANT ALL PRIVILEGES ON selfphp.* TO selfusr@localhost IDENTIFIED BY 'selfpass';
```

## デフォルトのデータベース

* mysql, information_schema, performance_schema
\- MariaDBの基本的な情報を管理
* test
\- テスト用データベース
* phpmyadmin
\- XAMPPのデータベース管理ツールで利用

### データベースの作成
```
CREATE DATABASE データベース名 CHARACTER SET utf8;
```

## SQL命令

| 命令                          | -                                             |
| ----------------------------- | --------------------------------------------- |
| `SHOW DATABASES`              | サーバ内のデータベース                        |
| `USE データベース`            | データベースの選択(MariaDB [ﾃﾞｰﾀﾍﾞｰｽ]>)に変わる |
| `SHOW TABLES`                 | 選択中のデータベースの内容                    |
| `SHOW FIELDS FROM テーブル名` | テーブルのフィールド一覧                      |

| データ型            | オプション     | -                          |
| ------------------- | -------------- | -------------------------- |
| INT                 | [(len)]        |
| FLOAT               | [(len, dec)]   |
| DOUBLE              | [(len, dec)]   |
| DECIMAL             | [(len[, dec])] | 文字列として格納された数値 |
| CHAR                | (len)          |
| VARCHAR             | (len)          |
| TEXT                |
| DATETIME            |
| DATE                |
| TIME                |
| BLOB                |                | バイナリ                   |
| LONGBLOB            |                | バイナリ                   |
| ENUM(var1, var2...) |                | 単一選択可能               |
| SET(var1, var2...)  |                | 複数選択可能               |

| 列フラグ       |
| -------------- |
| [NOT] NULL     |
| AUTO_INCREMENT |
| PRIMARY KEY    |
| DEFAULT 'var'  |
| UNIQUE         |

### 選択中のデータベースの操作
ふつうにSQL

例)
```sql
CREATE TABLE member (
  id INT PRIMARY KEY AUTO_INCREMENT,  
  nam varchar(255) NOT NULL,
  sex CHAR(1) DEFAULT '男',
  old INT NOT NULL,
  enter DATE NOT NULL,
  memo VARCHAR(255) DEFAULT NULL
);

INSERT INTO member (nam, sex, old, enter, memo) VALUES ('斎藤花子', '女', 22, '2016-04-10', '紹介割引適用');
INSERT INTO member (nam, old, enter, memo) VALUES ('鈴木次郎', 30, '2016-04-21', '再入会');
INSERT INTO member (nam, old, enter) VALUES ('佐藤和夫', 40, '2016-05-07');
INSERT INTO member VALUES (5, '山本和美', '女', 22, '2016-05-11', NULL);
```