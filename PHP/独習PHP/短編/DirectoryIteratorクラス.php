DirectoryIterator
  指定されたディレクトリ配下のファイル情報にアクセス
  ファイルやディレクトリを配列のように読み込む

new DirectoryIterator(パス)
  DirectoryIteratorオブジェクトを返す
  foreach($dir as $file)で取り出す

オブジェクトのメソッド
isDir()       ディレクトリ
isFile()      ファイル
isLink()      シンボリックリンク
getFileName() ファイル名
getPath()     パス
getPathName() パス(ファイル名まで)
getSize()     サイズ
getCTime()    作成日時
getMTime()    最終更新日時
getATime()    最終アクセス日時
  日時はタイムスタンプ
  ファイル名の取得では、mb_convert_encodingでUTF-8にするなど気を使う

ファイルシステム関数
is_dir(パス), is_file(パス), is_link(パス)
basename(パス), dirname(パス), ナシ, filesize(パス)
filectime(パス), filemtime(パス), fileatime(パス)

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DirectoryIterator クラス</title>
</head>
<body>
<table border="1">
  <tr>
    <th>ファイル</th>
    <th>サイズ</th>
    <th>最終アクセス日</th>
    <th>最終更新日</th>
  </tr>
  <?php
  // カレントフォルダをオープン
  $dir = new DirectoryIterator('./');
  // 読み込み
  foreach ($dir as $file) {
    if($file->isFile()) { ?>
    <tr>
      <td><?php print mb_convert_encoding($file->getFileName(), 'UTF-8', 'SJIS-WIN'); ?></td>
      <td><?php print $file->getSize(); ?>B</td>
      <td><?php print date('Y/m/d H:i:s', $file->getATime()); ?></td>
      <td><?php print date('Y/m/d H:i:s', $file->getMTime()); ?></td>
    </tr>
<?php }
  }
?>
</table>
</body>
</html>