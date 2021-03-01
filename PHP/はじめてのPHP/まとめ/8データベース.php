データベースへの接続
new PDO('{DSN接頭辞}:{DSNオプション}', '{ユーザ名}', '{パスワード}');
<?php
try {
  $db = new PDO('mysql:host=localhost;dbname=restaurant', 'penguin', 'top^hat');
} catch (PDOException $e) {
  print $e->getMessage();
}
?>

エラーモード
  // デフォルト サイレント
  PDO::ERRMODE_EXCEPTION // 例外エラーモード
  PDO::ERRMODE_WARNING // 警告エラーモード
$db->errorInfo() サイレントでのエラー取得など
  [0]一般エラー [1]使用中のデータベース固有のエラー [2]エラーメッセージ
<?php
// サイレント
$result = $db->exec( "INSERT INTO x (field) VALUES (val)");
if ($result === 'false') {
  $error = $db->errorInfo();
  print "SQL Error={$error[0]}, DB Error={$error[1]}, Message={$error[2]}";
}
// エラーモードのセット
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

データベースの変更
exec(SQL文)
  戻り値は行数、失敗でfalse
<?php
try {
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $q = $db->exec(
    ""
  );
} catch (PDOException $e) {
  print '変更できませんでした: '.$e->getMessage();
}
?>
データの取得
query(SQL文)
  戻り値はデータにアクセスできるPDOStatement
fetch(), fetchAll()
  PDOStatementから一つずつキーバリュー取得、または全て連想配列で取得
<?php
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch()) {
  print "{$row['dish_name']}, {$row['price']} \n"; // $row[0], $row[1]でもよい
}
// メソッドチェーンでもよい
// $dish_one = $db->query("")->fetch();
?>
フェッチスタイル 取得形式の変更
  データベースに　setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 値)　で指定
  クエリに　setFetchMode()　で指定
  クエリからの取り出し時に　fetch()　らの引数で指定
PDO::FETCH_NUM   $row[0], $row[1];
PDO::FETCH_ASSOC $row[dish_name], $row[price];
PDO::FETCH_OBJ   $row->dish_name, $row->price;
<?php
// データベースに指定するなら setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 値)
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
// クエリに指定するなら setFetchMode()
$q = $db->query('SELECT dish_name, price FROM dishes');
$q->setFetchMode(PDO::FETCH_ASSOC);
// 取り出し時に指定するなら fetch()の引数
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch(PDO::FETCH_NUM)) {
  print implode(', ', $row)."\n"; // $row[0], $row[1]\n
}
?>

プリペアステートメント PDOの機能 サニタイジング
prepare(SQL文) プレースホルダ '?'。
execute(array) 挿入する値。配列。
$stmt = $db->prepare('SQL文 ?'); // セット
$stmt->execute(array()); // 挿入して実行
<?php
// ステートメントにセット
$stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?,?,?)');
// 実行
$stmt->execute(array($_POST['new_dish_name'], $_POST['new_price'], $_POST['is_spicy']));
?>
quote() と strtr()
  クエリに入れられる形の文字列にした上、ワイルドカードをエスケープする。
  'LIKE ?'のようなプレースホルダはprepareで対応できないため。
<?php
$dish = $db->quote('受け入れる文字(検索文とか)');
// 置き換えたい記号あったら
$dish = strtr($dish, array('_' => '\_', '%' => '\%'));
$stmt = $db->query("文字列 $dish")
?>