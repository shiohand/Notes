<?php
print <<<_HTML_
<form method="post" action="#">
</form>
_HTML_;
?>

<?php
// ヒアドキュメント
<<<_HTML_
<h1>この間はHTMLとして出力</h1>
_HTML_;
<<<HTMLBLOCK
<h2>区切り文字はなんでもいいみたいだ？</h2>
<p>先頭はアルファベットかアンダースコアのみ<br>
終わるときの区切り文字は他の記述と一緒じゃいけない</p>
HTMLBLOCK;
?>

<?php
if (isset($_POST['user'])) { // isset() 値があるか否か
  print "Hello, ";
  print $_POST['name'];
  print "!";

} else { // 値がなかったらフォームを表示
print <<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Your Name: <input type="text" name="user" />
<br/>
<button type="submit">Say Hello</button>
</form>
_HTML_;
// $_SERVER[PHP_SELF]は現在のページ PHP_SELF → URL
// action="$_SERVER[PHP_SELF]" なのでto自分
}
?>

<?php
// データベースからの情報の表示 メソッドはあとでやるから気にしないで

$db = new PDO('sqlite:dinner.db'); // dinner.dbを使うよの準備
$meals = array('breakfast', 'lunch', 'dinner');
if(isset($_POST['meal'])) {
  if (in_array($_POST['meal'], $meals)) { // $mealsがあったら
    
    // dbから全取得（SQL読んだまんま）
    $stmt = $db->prepare('SELECT dish, price FROM meals WHERE meal LIKE ?');
    // LIKEの?部分に埋めるやつかな？
    $stmt->execute(array($_POST['meal']));
    // 　結果を取得
    $rows = $stmt->fetchAll();

    if (count($rows) == 0) {
      // $rowsが0件なら「ありません」
      print "No dishes available.";
    } else {
      // あるならそれをテーブルに出力
      print '<table>';
      print '<tr><th>Dish</th><th>Price</th></tr>';
      foreach ($rows as $row) {
        // dishとpriceね
        print '<tr><td>$row[0]</td><td>$row[1]</td></tr>';
      }
      print '</table>';
    }
  } else { // $mealsがなかったら
    print "Unknown meal.";
  }
} else {
  echo "no post";
}
?>