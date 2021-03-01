<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>画像のアップロード</title>
</head>
<body>
<form action="bindValue_process.php" method="post" enctype="multipart/form-data">
  <label for="photo">アップロードする画像：</label>
  <input type="file" name="photo" id="photo" size="50">
  <input type="submit" value="アップロード">
</form>
</body>
</html>