<?php
// データベースを利用
$db_name = 'enq.db';

// 配列作成
$enq1 = array('有名だから', '家から近いから', '興味があったから', '尊敬する人がいるから', 'そのほか');
$enq2 = array('雰囲気', '給料', '会社の人たち', 'オフィス環境', 'そのほか');
$enq3 = array('秘密', '男性', '女性');

$ext = file_exists('enq.db');

if(isset($_POST['submit']) && isset($_POST['ques1']) && isset($_POST['ques2'])) {
  $db = new SQLite3($db_name);

  if(!$ext) {
    $query = "CREATE TABLE enq(ans1 int, ans21 int, ans22 int, "."ans23 int, ans24 int, ans25 int, ans31 int)";
    $result = $db->exec($query);
  }
  // 問1の入力内容を格納
  for ($i=0; $i < count($enq1); $i++) { 
    if($_POST['ques1'] == $i) { // 一致したものを入れる
      $ans11 = $i;
      break;
    }
  }
  // 問2の入力内容を格納
  for ($i=0; $i < count($enq2); $i++) { 
    $ans2[$i] = 0;
  }
  for ($i=0; $i < count($_POST[$ques2]); $i++) { 
    $ans2[$_POST['ques2'][$i]] = 1;
  }
  // 問3の入力内容を格納
  for ($i=0; $i < count($enq3); $i++) { 
    if($_POST['sex'] == $i) {
      $ans31 = $i;
      break;
    }
  }
  // 入力内容をデータベースに書き込む
  $query = "INSERT INTO enq VALUES ($ans11, {$ans2[0]}, {$ans2[1]}, "."{$ans2[2]}, {$ans2[3]}, {$ans2[4]}, $ans31)";
  $result = $db->exec($query);

  $db->close();
}

// ヘッダ出力
header("Content-Type: text/html;charset=UTF-8");

function show_result() {
  global $enq1, $enq2, $enq3, $ext, $db_name;
  if(!$ext) {
    print '<p class="errMsgt">回答がありません</p>';
    exit;
  }
  // 変数初期化
  for ($i=0; $i < count($enq1); $i++) { 
    $res1[$i] = 0;
  }
  for ($i=0; $i < count($enq2); $i++) { 
    $res2[$i] = 0;
  }
  for ($i=0; $i < count($enq3); $i++) { 
    $res3[$i] = 0;
  }

  // 読み込みと集計
  $db = new SQLite3($db_name);
  $result = $db->query("SELECT * FROM enq");
  while($cols = $result->fetchArray(SQLITE3_ASSOC)) {
    $res1[$cols['ans11']]++; // インクリメント
    $res2[0] += $cols['ans21'];
    $res2[1] += $cols['ans22'];
    $res2[2] += $cols['ans23'];
    $res2[3] += $cols['ans24'];
    $res2[4] += $cols['ans25'];
    $res3[$cols['ans31']]++;
  }
  // 表を作成
  print '<table>';
  print '<tr><th>問1</th><th class="ans">結果</th></tr>';
  for ($i=0; $i < count($enq1); $i++) { 
    print '<tr><td>{$enq1[$i]}</td><td>{$res1[$i]}</td></tr>';
  }
  print '</table>\n';
  print '<table>';
  print '<tr><th>問2</th><th class="ans">結果</th></tr>';
  for ($i=0; $i < count($enq2); $i++) { 
    print '<tr><td>{$enq2[$i]}</td><td>{$res2[$i]}</td></tr>';
  }
  print '</table>\n';
  print '<table>';
  print '<tr><th>問3</th><th class="ans">結果</th></tr>';
  for ($i=0; $i < count($enq3); $i++) { 
    print '<tr><td>{$enq3[$i]}</td><td>{$res3[$i]}</td></tr>';
  }
  print '</table>\n';

  $db->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>アンケートサンプル</title>
</head>
<body>
  <form action="enqlite.php" method="post">
  <?php
    // 終了画面 または 結果画面
    if(isset($_POST['submit']) && isset($_POST['ques1']) && isset($_POST['ques2'])) {
      print '<p>ご協力ありがとうございました</p>\n';
      print '<p><input type="submit" name="back" value="前に戻る"></p>\n';
      print '</form></body></html>';
      exit;
    } else if (isset($_POST['show_result'])) {
      show_result();
      print '</form></body></html>';
      exit;
    }
  ?>

  <!-- 終了画面でも結果画面でもない 通常画面 -->
  <!-- class="errMsg"はデフォルトでは消えている -->
  <p>簡単なアンケートです。ぜひご協力ください。<br>
  <span class="errMsg">注：問1, 問2は必須項目です</span></p>
  <p>問1.当社を見学したいと思ったのはなぜですか？</p>
  <?php
    for ($i=0; $i < count($enq1); $i++) { 
      print '<div><input type="radio" name="ques1" value="'.$i.'">'.$enq1[$i].'</div>'."\n";
    }
  ?>
  <p>問2.当社で気に入った点は何ですか？（複数選択可）</p>
  <?php
    for ($i=0; $i < count($enq2); $i++) { 
      print '<div><input type="checkbox" name="ques2[]" value="'.$i.'">'.$enq2[$i].'</div>'."\n";
    }
  ?>
  <p>問3.あなたの性別を教えてください</p>
  <div><select name="sex">
  <?php
  print '<option value="0" selected>'.$enq3['0'].'</option>';
  print '<option value="1">'.$enq3['1'].'</option>';
  print '<option value="2">'.$enq3['2'].'</option>';
  ?>
  </select></div>
  <p><input type="submit" name="submit" value="送信"><input type="reset"></p>
  </form>
</body>
</html>