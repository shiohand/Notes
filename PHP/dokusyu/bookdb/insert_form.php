<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>データの登録</title>
</head>
<body>
<form action="insert_process.php" method="post">
  <div>
    <label for="isbn">ISBNコード：</label><br>
    <input type="text" id="isbn" name="isbn" size="25" maxlength="20">
  </div>
  <div>
    <label for="title">書名：</label><br>
    <input type="text" id="title" name="title" size="35" maxlength="150">
  </div>
  <div>
    <label for="price">価格：</label><br>
    <input type="text" id="price" name="price" size="6" maxlength="5">円
  </div>
  <div>
    <label for="publish">出版社：</label><br>
    <input type="text" id="publish" name="publish" size="25" maxlength="30">
  </div>
  <div>
    <label for="published">刊行日：</label><br>
    <input type="text" id="published" name="published" size="15" maxlength="10">
  </div>
  <div><input type="submit" value="登録"></div>
</form>
</body>
</html>