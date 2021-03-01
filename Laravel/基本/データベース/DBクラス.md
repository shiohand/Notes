# DBクラス

- [DBクラス(クエリビルダ)](#dbクラスクエリビルダ)
- [DBクラスの利用](#dbクラスの利用)
- [パラメータ結合](#パラメータ結合)
- [SQLを書いて実行するメソッド](#sqlを書いて実行するメソッド)
  - [`DB::select(SQL文[, パラメータ配列])`](#dbselectsql文-パラメータ配列)
  - [`DB::insert(SQL文[, パラメータ配列])`](#dbinsertsql文-パラメータ配列)
  - [`DB::update(SQL文[, パラメータ配列])`](#dbupdatesql文-パラメータ配列)
  - [`DB::delete(SQL文[, パラメータ配列])`](#dbdeletesql文-パラメータ配列)
- [クエリビルダ](#クエリビルダ)
  - [DB::table(テーブル名)](#dbtableテーブル名)
    - [where()](#where)

## DBクラス(クエリビルダ)
データベースアクセスのためのクラス
SQLを直接実行するのに近い
クエリビルダ機能でデータベースアクセスのメソッド化が可能

受け取る値は連想配列として扱う

## DBクラスの利用

```php
use Illuminate\Support\Facades\DB;
```

## パラメータ結合

select(SQL文, パラメータ配列)
SQL文内に`:プレースホルダ`と置いて、第二引数に連想配列でパラメータを埋め込むことが可能

```php
$param = ['id' => $request->id];
$items = DB::select('select * from people where id = :id]', $param);
```

## SQLを書いて実行するメソッド

### `DB::select(SQL文[, パラメータ配列])`
SELECT 結果のレコードが取り出せる

```php
$items = DB::select('select * from people where id = :id]', $param);
```

### `DB::insert(SQL文[, パラメータ配列])`
INSERT レコードの追加

```php
DB::insert('insert into people (name, mail, age) values (:name, :mail, :age)', $param);
```

### `DB::update(SQL文[, パラメータ配列])`
UPDATE レコードの更新

```php
DB::update('update people set name = :name, mail = :mail, age = :age where id = :id', $param);
```

### `DB::delete(SQL文[, パラメータ配列])`
DELETE レコードの削除

```php
DB::delete('delete from people where id = :id', $param);
```

## クエリビルダ
SQLを全部書くとミスの可能性があり、パラメータの埋め込みなどが絡むと予想外の結果が起こる可能性が高くなる

クエリビルダ -> SQLを使わず、専用のメソッドで設定しながらSQL文を内部生成する

### DB::table(テーブル名)
テーブルのBuilder(データベース用クラス)を取得し、Builderのメソッドによってビルダの設定やテーブルの操作を行う

```php
$items = DB::select('select * from people');
/* ↓ */
$items = DB::table('people')->get();
```
この例ではget()によって全てのデータをコレクションとして受け取っている

メソッド|-
-|-
get()|全データを取得
get([フィールドの配列])|指定したカラムの全データを取得
first()|ひとつめのデータを取得 データが一つしかないときなど
paginate(件数)|詳細はペジネーション.md
simplePaginate(件数)|詳細 ペジネーション.md
insert(連想配列)|フィールド名をキーとした配列でレコードを追加する
update(連想配列)|where()で更新対象を指定したあと
delete()|where()で更新対象を指定したあと

where系|-
-|-
where(フィールド, 値)|`where フィールド = 値`と同等かも
where(フィールド, 演算記号, 値)|`>`, `<=`, `like`など
orWhere(フィールド, 値)|OR条件
orWhere(フィールド, 演算記号, 値)|
whereRaw(条件式, パラメータ配列)|条件式をSQLの文法で追加する プレースホルダは`?`

ほか|-
-|-
orderBy(フィールド名, 順序)|順序は`asc`or`desc`
offset(整数)|offset
limit(整数)|limit
* orderByの第一引数はデフォルトで`created_at`

#### where()

* orWhere
```php
$items = DB::table('people')
->where('name', 'like', '%'.$name.'%')
->orWhere('mail', 'like', '%'.$name.'%')
->get();
```
* whereRaw
```php
->whereRaw('age >= ? and age <= ?', [$min, $max])
```
* offset, limit
```php
->offset($page * 3)
->limit(3)
```
