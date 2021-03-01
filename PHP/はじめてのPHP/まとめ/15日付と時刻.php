DateTimeオブジェクト

format 記述子 onenoteにメモした
 年月日 Y/m/d // 大きいY、m, d
0年月日 y/n/j // 小さいy, mの手前, じゃないほうのj
12時/0 g/h
24時/0 G/H
分秒    i/s   // iがいっぱいだからi 
月名    M     // 大きいM
略月    F     // とにかくF
曜日    l     // とにかくl
略曜    D     // ○○DayのD

<?php
$d = new DateTime(); // 指定なしは現在時刻
// 例えば 2016年10月20日12時
print "It is now: {$d->format('r')}\n"; // rはRFC-2822フォーマット
// It is now: Thu, 20 Oct 2016 12:00:00 +0000
print $d->format('m/d/y')
// 10/20/16
?>

new DateTime()
  フォーマット http://www.php.net/datetime.formats

// 時間指定の例
一般的なログフォーマット  3/Mar/2015:17:34:45 +0400
時刻だけ  10:36 am
日付だけ  5/11
ミリ秒も  2015-03-10 17:34:45.326425
形式様々  March 5th 2017
タイムスタンプ  @381718923
// 相対指定
曜日    next Tuesday
過去    last day of April 2015
加減    November 1, 2012 + 2 weeks

setDate() 日付
setTime() 時刻
  オブジェクトの内容を変更
<?php
$d = new DateTime();
// フォームから受け取った値を使用したい
$d->setDate($_POST['yr'], $_POST['mo'], $_POST['dy']);
$d->setTime($_POST['hr'], $_POST['mn']);
print $d->format('r');
?>

checkdate(日付)
  boolean 月と日がそれ単体で有効な日付かの検証
  例えば setDate(2016, 3, 35); は4月4日として判断されるので注意
<?php
if (checkdate(3, 35, 2016)) { // 35日はないのでfalse
  print 'March 35, 2016.';
}
if (checkdate(2, 29, 2017)) { // うるう年ならtrue
  print 'February 29, 2017.';
}
?>

modify(期間)
  相対的に時刻を移動
<?php
$daysToPrint = 4;
$d = new DateTime('next Tuesday');
print "<select name=\"day\">\n"; // ['day']で受け取る
for ($i = 0; $i < $daysToPrint; $i++) { // 4日分
  print " <option>{$d->format('l F jS')}</option>\n"; // 曜日 月 日th
  $d->modify("+2 day"); // 二日足して次のループへ
}
print "</select>";
?>

diff(時刻1, 時刻2)
  期間の計算
  時刻1->diff(時刻2) で二つの時刻の差をDateIntervalで返す
  時刻1 - 時刻2
DateIntervalのプロパティ
y 年 year
m 月 month
d 日 day
h 時間 hour
i 分 minit
s 秒 second
f マイクロ floatかな？
days 日付間の総日数
invert 期間が正の数なら0を、0または負の数なら1を返す。
<?php
$now = new DateTime();
$birthdate = new DateTime('1990-05-12');
$diff = $birthdate->diff($now);

if (($diff->y > 13) && ($diff->invert == 0)) {
  print 'You are more than 13 years old.';
} else {
  print 'Sorry, too young.';
}
?>

タイムゾーンの設定
  iniファイルでdate.timezoneを設定する
  毎回date_default_timezone_set()で設定する
  設定がない場合UTC(経度0度)