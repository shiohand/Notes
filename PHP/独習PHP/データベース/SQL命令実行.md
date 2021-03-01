# SQL命令実行

- [プリペアステートメント](#プリペアステートメント)
- [バインド](#バインド)
- [実行](#実行)

## プリペアステートメント

* `$stt = $db->prepare(SQL命令[, options])`
\- 戻り値 PDOStatementオブジェクト
\- `?` か `:任意` でプレースホルダ

## バインド

* `$stt->bindValue(プレースホルダ, 値[, 型 = PDO::PARAM_STR])`
\- プレースホルダに値をセット(bindValue時点で反映)
\- ?の場合は第1引数に何個目の?か(1個目は1)を指定(対応がわかりにくい)
* `$stt->bindParam(プレースホルダ, 代入する変数[, 型 = PDO::PARAM_STR[, データ長]])`
\- プレースホルダに値をセット(execute時点で反映)

bindValue -> 値はbindValue実行時の計算
bindParam -> 値はexecute時の計算(executeまでにbindしておく) フォームの入力値を連番加工して代入とか

* `$stt->bindColumn(列名, &変数[, 型[, 最大長]])`
  指定した列の値を変数で受け取れる

| パラメータ型            | -                             |
| ----------------------- | ----------------------------- |
| PDO::PARAM_BOOL         |
| PDO::PARAM_NULL         |
| PDO::PARAM_INT          |
| PDO::PARAM_STR          |
| PDO::PARAM_LOB          | ラージオブジェクト バイナリ型 |
| PDO::PARAM_STMT         | クエリ                        |
| PDO::PARAM_INPUT_OUTPUT | 他の定数と組み合わせて使う    |

## 実行

* `$stt->execute()`
\- 実行
\- $stt->rowCount()で更新された行数を取得できる(SELECTはものによる)

```php
// bindValue() bindColumn()
$stt = $db->prepare('SELECT * FROM photo WHERE id = ?');
$stt->bindValue(1, $_GET['id'] ? : 1);
$stt->execute();
// 列と変数のマッピング
$stt->bindColumn('type', $type, PDO::PARAM_STR);
$stt->bindColumn('data', $data, PDO::PARAM_LOB);
// レコードの取得 PDO::FETCH_BOUND
if ($stt->fetch(PDO::FETCH_BOUND)) { // 成功したら出力
  header("Content-Type: $type");
  print $data;
}
```
