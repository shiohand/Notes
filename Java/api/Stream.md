# Stream

## ストリームの基本クラス

| -        | -              | -               |
| -------- | -------------- | --------------- |
| 文字     | XxxReader      | XxxWriter       |
| バイナリ | XxxInputStream | XxxOutputStream |

## java.ioパッケージの主なクラス

| 文字      | バイナリ  |                      |
| --------- | --------- | -------------------- |
| File      | File      | ファイル             |
| CharArray | ByteArray | 文字配列(バイト配列) |
| Buffered  | Buffered  | バッファー           |
| Piped     | Piped     | パイプ               |
|           | Object    | オブジェクト         |
| String    |           | 文字列               |

### 他のクラス

* InputStreamReader OutputStreamWriter
\- バイナリストリーム→文字ストリームへの変換
* PrintWriter PrintStream
\- 任意のデータ型の値を出力(System.outフィールドの戻り値らしい)

基本的にファイルを使うなら、FileXxxx経由で
In/OutputStream経由なら必要ならIn/OutputStreamReaderを噛んで

#### BufferedReader

* readLine()

#### BufferedWriter

* write(str[, offset, len])
* newLine()
\- 改行

#### Files

* newBufferedWriter(path[, charset][, options])
\- BufferedWriterを返す
* newBufferedReader(path[, charset][, options])
\- BufferedReaderを返す

```java
var reader = Files.newBufferedReader(Paths.get("C:\\practice\\sample.txt"));
var writer = Files.newBufferedWriter(Paths.get("C:\\practice\\data.log"));
```

#### BufferedInputStream
* read()
\- byteだがintで返る
#### BufferedOutputStream
* write(int)
\- byteをint型で渡す

```java
var in = new BufferedInputStream(new FileInputStream("C:/practice/input.png"));
var out = new BufferedOutputStream(new FileOutputStream("C:/practice/output.png"));
```

#### ObjectOutputStream

* writeObject(obj)

#### ObjectInputStream

* readObject()
\- 戻り値はObject型

```java
var out = new ObjectOutputStream(new FileOutputStream(file));
var in = new ObjectInputStream(new FileInputStream(file));

// フィールドを使うときは
var obj = (キャスト)in.readObject());
// キャストするならClassNotFoundExceptionも
```

## java.nio.file.Files

* newBufferedReader(Path path[, Charset cs]) throws IOException
\- BufferedReaderを返す

* newBufferedWriter(Path path[, Charset cs][, OpenOption... options]) throws IOException
\- BufferedWriterを返す

### OpenOptionの例

* java.nio.file.StandardOpenOption

| 定数              | -                                                     |
| ----------------- | ----------------------------------------------------- |
| CREATE            | 新規作成(存在する場合はしない)                        |
| APPEND            | write 追記モード                                      |
| CREATE_NEW        | 新規作成(存在する場合はエラー)                        |
| DELETE_ON_CLOSE   | 閉じる時にファイルを削除                              |
| TRUNCATE_EXISTING | ファイルが存在する && write のときは長さを0に切り詰め |

### Charsetの例
* java.nio.charset.StandardCharsets
\- UTF_8
* java.nio.charset.Charset
\- forName("Windows-31J")

* write​(Path path, Iterable<? extends CharSequence> lines, OpenOption... options) throws IOException
\- イテラブルをまとめて書き込む

```java
new ArrayList<String>Arrays.asList("str1", "str2", "str3");
write(path, list, StandardCharsets.UTF_8);
```

## java.nio.file.Paths

* get(String first, String... more)
\- Pathを返す


## Java7以前

```java
var reader = new BufferedReader(
  new InputStreamReader(
    new FileInputStream("C:/practice/data.log), "UTF-8"))
var writer = new BufferedWriter(
  new OutputStreamWriter(
    new FileOutputStream("C:/practice/data.log), "UTF-8"))
```

| クラス            | -                                        |
| ----------------- | ---------------------------------------- |
| FileInputStream   | ファイルをバイトストリームとして扱う     |
| InputStreamReader | バイトストリームと文字ストリームの橋渡し |
| BufferedReader    | バッファ                                 |


## ちょっとめも try-with-resource

例外処理 try-with-resource tryでリソースを作って使える
別のアプリとの共有リソースを使う場合はこれが原則

```java
try (
  var writer = new Writer() // 自動openされる
) {
  writer.write(); // 使える
  // 終了後に自動close()される 普通にメソッドを呼ぶより確実
} catch (IOException e) {
  e.printStackTrace();
}
```