php.iniの設定
SMTP = メール送信サーバー名を指定
sendmail_from = 送信元のメールアドレスを指定

mb_send_mail(to, subject, body)
<?php
$header = "From:".mb_encode_mimeheader("管理者")."<PHP@ank.co.jp>"; // 日本語部分があるならmb_encode_mimeheader(文字列[, 文字コード])
$mailto = "shiori@ank.co.jp";
$subject = "絵本シリーズ";
$message = "PHPの絵本\r\n第２版";
if(mb_send_mail($mailto, $subject, $message, $header)) {
  print " 送信しました。";
} else {
  print " 送信エラー";
}
?>

全てUTF-8で送りたいが、古いメーラーではJISにしか対応していない可能性がある。
その場合はJISに変換

<?php
$header = "From:".mb_encode_mimeheader("管理者", "ISO-2022-JP")."<PHP@ank.co.jp>";
$mailto = "shiori@ank.co.jp";
$subject = mb_encode_mimeheader("絵本シリーズ", "ISO-2022-JP"); // えんこーど
$message = mb_convert_encoding("PHPの絵本\r\n第２版", "ISO-2022-JP"); // こんばーと
if(mb_send_mail($mailto, $subject, $message, $header)) {
  print " 送信しました。";
} else {
  print " 送信エラー";
}
?>