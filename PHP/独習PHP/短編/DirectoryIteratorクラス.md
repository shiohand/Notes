# DirectoryIterator

- [DirectoryIteratorクラスとは](#directoryiteratorクラスとは)
- [`new DirectoryIterator(パス)`](#new-directoryiteratorパス)
- [オブジェクトのメソッド](#オブジェクトのメソッド)
- [ファイルシステム関数](#ファイルシステム関数)
- [例](#例)

## DirectoryIteratorクラスとは

* 指定されたディレクトリ配下のファイル情報にアクセス
* ファイルやディレクトリを配列のように読み込む

## `new DirectoryIterator(パス)`
DirectoryIteratorオブジェクトを返す
foreach($dir as $file)で取り出す

## オブジェクトのメソッド

メソッド|-
-|-
isDir()       |ディレクトリ
isFile()      |ファイル
isLink()      |シンボリックリンク
getFileName() |ファイル名
getPath()     |パス
getPathName() |パス(ファイル名まで)
getSize()     |サイズ
getCTime()    |作成日時
getMTime()    |最終更新日時
getATime()    |最終アクセス日時

日時はタイムスタンプ
ファイル名の取得では、mb_convert_encodingでUTF-8にするなど気を使う

## ファイルシステム関数
is_dir(パス), is_file(パス), is_link(パス)
basename(パス), dirname(パス), ナシ, filesize(パス)
filectime(パス), filemtime(パス), fileatime(パス)

## 例

```php
// カレントフォルダをオープン
$dir = new DirectoryIterator('./');
// 読み込み
foreach ($dir as $file) {
  if($file->isFile()) {
    '<tr>'
      .'<td>'.mb_convert_encoding($file->getFileName(), 'UTF-8', 'SJIS-WIN').'</td>'
      .'<td>'.$file->getSize().B'</td>'
      .'<td>'.date('Y/m/d H:i:s', $file->getATime()).'</td>'
      .'<td>'.date('Y/m/d H:i:s', $file->getMTime()).'</td>'
    .'</tr>'
  }
}
```