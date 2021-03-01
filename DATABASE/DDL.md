# DDL

## CREATE TABLE

`CREATE TABLE テーブル名 (列名 データ型 制約, ...) [オプション]`

制約|-
-|-
PRIMARY KEY|主キー
PRIMARY KEY (カラム...)|複合キー
AUTOINCREMENT|オートインクリメント
NOT NULL|NULL禁止
DEFAULT 値|非指定時のデフォルト値(たいていNOT NULLとセット)
UNIQUE|
CHECK (条件)|
REFERENCES 相手テーブル名(カラム)|

オプションとして外部キーを追加
`FOREIGN KEY (カラム) REFERENCES 相手テーブル名(カラム)`

```sql
CREATE TABLE `people` (
  `id`    INTEGER PRIMARY KEY AUTOINCREMENT,
  `name`  TEXT NOT NULL,
  `mail`  TEXT,
  `age`   INTEGER
)
```

## DROP TABLE

`DROP TABLE テーブル名`

## ALTER TABLE

`ALTER TABLE テーブル名`

命令|-
-|-
ADD 列名 型 制約|
DROP 列名 型 制約|