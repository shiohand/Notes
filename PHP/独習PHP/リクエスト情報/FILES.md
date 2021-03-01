# FILES

- [利用](#利用)
- [$_FILESの内容](#_filesの内容)
- [multipleのときの値の入り方](#multipleのときの値の入り方)
- [pathinfo(ファイルパス)](#pathinfoファイルパス)
- [getimagesize()](#getimagesize)
- [move_uploaded_file(tmpのファイルパス, 保存先パス)](#move_uploaded_filetmpのファイルパス-保存先パス)

## 利用

```php
<!-- file1.php -->
<form action="file2.php" method="post" enctype="multipart/form-data">
  <label for="upfile">ファイルのパス：</label>
  <input type="hidden" name="max_file_size" value="1000000"><!-- input前に設定する。書き換えられる可能性はある -->
  <input type="file" name="upfile" id="upfile" size="40"><!-- multipleならupfile[] -->
  <input type="submit" value="アップロード">
</form>
```

* `enctype="multipart/form-data"`
\- ファイルのインプットを使用する場合

```php
<!-- file2.php -->
<?php
$perm = ['gif', 'jpg', 'jpeg', 'png']; // 許可する拡張子
$ext = pathinfo($_FILES['upfile']['name']); // アップロードファイルの情報を取得
if ($_FILES['upfile']['error'] !== UPLOAD_ERR_OK) { // アップロードができているか
  $msg = [
    // UPLOAD_ERR_OK => 'アップロードに成功しました。(エラーはないということ)',
    UPLOAD_ERR_INI_SIZE => 'php.iniのupload_max_filesize制限を超えています。',
    UPLOAD_ERR_FORM_SIZE => 'HTMLのMAX_FILE_SIZE 制限を超えています',
    UPLOAD_ERR_PARTIAL => 'ファイルが一部しかアップロードされていません。',
    UPLOAD_ERR_NO_FILE => 'ファイルはアップロードされませんでした。',
    UPLOAD_ERR_NO_TMP_DIR => '一時保存フォルダが存在しません。',
    UPLOAD_ERR_CANT_WRITE => 'ディスクへの書き込みに失敗しました。',
    UPLOAD_ERR_EXTENSION => '拡張モジュールによってアップロードが中断されました。'
  ]; // 定数の中身はUPLOAD_ERR_OKから0,1,2...
  $err_msg = $msg[$_FILES['upfile']['error']];
} else if (!in_array(strtolower($ext['extension']), $perm)) { // 拡張子チェック
  $err_msg = '画像以外のファイルはアップロードできません。';
} else if (!@getimagesize($_FILES['upfile']['tmp_name'])) { // 内容が画像かのチェック
  $err_msg = 'ファイルの内容が画像ではありません';
} else { // アップロード処理
  $src = $_FILES['upfile']['tmp_name'];
  $dest = mb_convert_encoding($_FILES['upfile']['name'], 'SJIS_WIN', 'UTF-8'); // 文字コード対応
  if (!move_uploaded_file($src, 'doc/'.$dest)) { // 実際使うときは外のフォルダにしよう
    $err_msg = 'アップロード処理に失敗しました。';
  }
}
if (isset($err_msg)) {
  dir('<div style="color:Red;">'.$err_msg.'</div>');
}
// リダイレクト
header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/file1.php');
?>
```

## $_FILESの内容
name, type, size, tmp_name, error
typeはコンテンツタイプ, tmp_nameはtmpファイル名

## multipleのときの値の入り方
```
['upfile']['name'][0]
['upfile']['name'][1]
...
['upfile']['type'][0]
['upfile']['type'][1]
...
```

## pathinfo(ファイルパス)
連想配列を返す
dirname, basename, extension(拡張子), filename など
拡張子などは$_FILESからも取得できるが、クライアント側で偽造が可能なため使用しない

## getimagesize()
画像サイズを取得
画像でなかった場合は警告を発し、falseを返す。
エラー制御演算子で警告を無視させれば、拡張子に頼らないチェックが可能

## move_uploaded_file(tmpのファイルパス, 保存先パス)
ファイルがアップロードされたものと違ったり、保存先に書き込めなかったりした場合にfalse
