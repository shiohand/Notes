<?php

// 通ってきたリクエストがPOSTだったら結果を表示
// でなければsubmit前なのでフォームを表示

echo "フォームで名前を入力して出力";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  print "Hello, ".$_POST['my_name'];
} else {
  print <<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Your name: <input type="text" name="my_name">
<br>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}

?>