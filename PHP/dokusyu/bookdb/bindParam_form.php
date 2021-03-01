<?php
require_once '../DbManager.php';
require_once '../Encode.php';

try {
  $db = getDb();
  $stt = $db->query('SELECT * FROM book ORDER BY published DESC');
  $cnt = 0; // 連番用
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>既存データの更新</title>
</head>
<body>
<form action="bindParam_process.php" method="post">
<input type="submit" value="更新">
<table border="1">
  <tr>
    <th>ISBNコード</th><th>書名</th><th>価格</th><th>出版社</th><th>刊行日</th>
  </tr>
  <?php
  while($row = $stt->fetch(PDO::FETCH_ASSOC)) {
    $cnt++;
  ?>
  <tr>
    <!-- isbn表示 <input:hidden> -->
    <!-- <input type="text" name="項目{idx}" value="{登録情報}"> -->
    <td>
      <?php echo e($row['isbn']) ?>
      <input type="hidden" name="isbn<?php echo e($cnt) ?>" value="<?php echo e($row['isbn']) ?>">
    </td>
    <td>
      <input type="text" name="title<?php echo e($cnt) ?>" value="<?php echo e($row['title']) ?>" size="35">
    </td>
    <td>
      <input type="text" name="price<?php echo e($cnt) ?>" value="<?php echo e($row['price']) ?>" size="5">
    </td>
    <td>
      <input type="text" name="publish<?php echo e($cnt) ?>" value="<?php echo e($row['publish']) ?>" size="12">
    </td>
    <td>
      <input type="text" name="published<?php echo e($cnt) ?>" value="<?php echo e($row['published']) ?>" size="12">
    </td>
  </tr>
  <?php
  }
} catch (PDOException $e) {
  print "エラーメッセージ：{$e->getMessage()}";
}
?>
</table>
<input type="hidden" name="cnt" value="<?php echo e($cnt) ?>">
</form>
</body>
</html>
