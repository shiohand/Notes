サニタイジング
<?php
// strip_tags() HTMLタグを<>記号を基準に取り除く。タグじゃなくても消えてしまう。
$comments = strip_tags($_POST['comments']);
// htmlentities() コードの中にあると意味を持つ記号をエンティティに変更
$comments = htmlentities($_POST['comments']);
?>