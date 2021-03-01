文字コード
default_charset構成変数はUTF-8でセット
構成変数はini_set('構成変数', '値')で変更できる

mbstring拡張モジュール
  通常のstring操作では2バイト文字に対応していないため、全角の英数を扱うときなどにもmbstring拡張機能がなければ正確に処理できない場合がある。

strlen(文字列)
  バイト数で数えているので2バイト文字を2文字としてしまう
mb_strlen(文字列)
  2バイト文字対応
strtolower(文字列) strtoupper(文字列)
  全角英字非対応
mb_strtolower(文字列) mb_strtoupper(文字列)
  全角英字対応

mb_convert_encoding(文字列, 文字コード)
  SJISなどに変換

mail() 英語基準
mb_send_mail($to, $subject, $body)
  mbstring.language構成変数にJapaneseを指定していること
mb_encode_mimeheader(文字列)
  宛先(to)に日本語を使用しているとき必要
<?php
ini_set('mbstring.language', 'Japanese');
$name = "鈴木タロウ";
// 日本語を含む文字列を変換
$to = mb_encode_mimeheader($name)."<taro@example.com>";
$subject = "ごあいさつ";
$body = "こんにちは、$name さん";
mb_send_mail($to, $subject, $body);
?>

ソートと比較
  文字列として比較など行う場合、Collatorクラスを利用
  new Collator(ロケール文字列) 'en_US'とか'ja_JP'とか '言語コード_国コード'の形
オブジェクトのメソッドとしてsort(), asort(), compare()など使う
<?php
$words = array('ka', 'か', 'が', 'カ', 'ガ');

$en = new Collator('en_US');
$ja = new Collator('ja_JP');
print "Before sorting: ".implode(', ', $words)."\n";
$en->sort($words);
print "en_US sorting: ".implode(', ', $words)."\n";
$ja->sort($words);
print "ja_JP sorting: ".implode(', ', $words)."\n";
?>

出力のローカライズ
クライアントの状態によって表示する言語を変更する
MessageFormatterクラス
new MessageFormatter(ロケール文字列, 文字列)
オブジェクト->format(波括弧に代入する内容の配列)
<?php
// 各ロケール文字列に対応した内容を作る
$messages = array();
// {0}はプレースホルダとして使える
$messages['en_US'] = array('FAVORITE_FOODS' => 'My favorite food is {0}', 'COOKIE' => 'cookie', 'SQUASH' => 'squash');
$messages['ja_JP'] = array('FAVORITE_FOODS' => '私の好きな食べものは{0}です', 'COOKIE' => 'クッキー', 'SQUASH' => 'かぼちゃ');

// フォーマットを設定してオブジェクトを生成
$fmtfavs = new MessageFormatter('ja_JP', $messages['ja_JP']['FAVORITE_FOODS']);
$fmtcookie = new MessageFormatter('ja_JP', $messages['ja_JP']['COOKIE']);

$cookie = $fmtcookie->format(array()); // フォーマット実行 arrayは空
print $fmtfavs = $fmtfavs->format(array($cookie)); // フォーマット実行 {0}に代入する文字列を渡す
// 私の好きな食べものはクッキーです
?>

通貨記号、数値もフォーマットできる
<?php
$msg = "The cost is {0,number,currency}.";

$fmtUS = new MessageFormatter('en_US', $msg);
$fmtDE = new MessageFormatter('de_DE', $msg);
$fmtJP = new MessageFormatter('ja_JP', $msg);
print $fmtUS->format(array(1023.5))."\n"; // $1,023.5.
print $fmtDE->format(array(1023.5))."\n"; // 1.023,5€.
print $fmtJP->format(array(1023.5))."\n"; // ￥1,024.
?>