データベースからのデータの取得

<?php
try {
  $db = new PDO('mysql:host=db.example.com;dbname=restaurant', 'penguin', 'top^hat;');
  // 処理処理;
} catch (PDOException $e) {
  print '接続に失敗しました: '.$e->getMessage();
}
?>

query(クエリ)で取得、fetch()で1行ずつ読み出し fetchAll()で全て読み出し
<?php
// query() 結果を$qに取得
$q = $db->query('SELECT dish_name, price FROM dishes');
// fetch() falseがでるまで1行ずつ読み出し
while ($row = $q->fetch()) {
  print "$row[dish_name], $row[price] \n"; // $row[0], $row[1]でもよい
}
// メソッドチェーンしてもよき
$dish_one = $db->query('SELECT dish_name, price FROM dishes ORDER BY price LIMIT 1')->fetch();
print "$dish_one[0], $dish_one[1]";
// fetch(all)
$q = $db->query('SELECT dish_name, price FROM dishes');
$rows = $q->fetchAll();
?>

フェッチスタイル 取得形式の変更
  データベースに　setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, 値)　で指定
  クエリに　setFetchMode()　で指定
  クエリからの取り出し時に　fetch()　らの引数で指定
PDO::FETCH_NUM
  数値キーだけの配列で受け取る(普通の配列) $row[0], $row[1];
PDO::FETCH_ASSOC
  文字列キーだけの配列で受け取る(連想配列) $row[dish_name], $row[price];
PDO::FETCH_OBJ
  オブジェクトで受け取る $row->dish_name, $row->price;
<?php
// データベースに指定するなら
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
// クエリに指定するなら
$q = $db->query('SELECT dish_name, price FROM dishes');
$q->setFetchMode(PDO::FETCH_ASSOC);
// 取り出し時に指定するなら
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch(PDO::FETCH_NUM)) {
  print implode(', ', $row)."\n"; // $row[0], $row[1]\n
}
$q = $db->query('SELECT dish_name, price FROM dishes');
while ($row = $q->fetch(PDO::FETCH_OBJ)) {
  "{$row->dish_name} has price {$row->price} \n";
}
?>

プリペアステートメント
ユーザが料理名を検索できるフォームと仮定
入力値にある%とかのワイルドカードはエスケープしないでくれる
エスケープしたいときについては次のブロック
<?php
$stmt = $db->prepare('SELECT dish_name, price FROM dishes WHERE dish_name LIKE ?');
$stmt->execute(array($_POST['dish_search']));
while ($row = $stmt->fetch()) {
  // 処理;
}
?>
%などもエスケープしたいとき
<?php
// quote() PDOの機能 クォーテーション的なイメージ
$dish = $db->quote($_POST['dish_search']);
// strtr() 別にデータベース用の関数ではない。文字列の置き換え。
$dish = strtr($dish, array('_' => '\_', '%' => '\%'));
$stmt = $db->query("SELECT dish_name, price FROM dishes WHERE dish_name LIKE $dish");
?>