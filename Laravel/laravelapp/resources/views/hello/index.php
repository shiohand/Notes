<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello/Index</title>
  <style>
    body {
      font-size: 16pt;
      color: #999;
    }
    h1 {
      font-size: 100px;
      text-align: right;
      color: #f6f6f6;
      margin: -40px 0 -100px;
    }
  </style>
</head>
<body>
  <h1>Index</h1>
  <p>This is a sample page with php-template.</p>
  <p><?php echo date("Y年n月j日") ?></p>
  <p>You are <?php echo $id ?>.</p>
  <p><?php echo $num + 4; ?></p>
</body>
</html>