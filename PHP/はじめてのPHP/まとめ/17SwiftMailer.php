メール
Swift Mailerの利用
  Swift_Message::newInstance()
    メッセージ-obj->set(○○)
      setFrom('アドレス') // array('アドレス' => '表示名')でも
      setTo('アドレス')   // array('アドレス' => '表示名')でも
      setSubject('')
      setBody('内容')
  Swift_SmtpTransport::newInstance('ホスト', ポート番号)
  Swift_Mailer::newInstance(トランスポートobj)
  メーラーobj->send(メッセージobj)

<?php
// Swift_Messageオブジェクトの作成
$message = Swift_Message::newInstance();
// 内容を入れていく
// From
$message->setFrom('自分');
// To
$message->setTo(array('相手' => 'きみ'));
// Subject
$message->setSubject('タイトル');

// Body
$message->setBody('本文'
);
// Body(HTMLのすがた)
$message->setBody('<p>本文</p>', "text/html"); // 第2引数にMIMEタイプを指定！
?>

SMTPトランスポートのオブジェクトを用意して内容を送信
<?php
// Swift_SmtpTransportオブジェクトの作成
$transport = Swift_SmtpTransport::newInstance('smtp.example.com', 25);
// 上を利用したSwift_Mailerオブジェクトの作成
$mailer = Swift_Mailer::newInstance($transport);
// send(Swift_Messageオブジェクト)で送信
$mailer->send($message);
?>
その他ファイルの添付、ヘッダの追加、開封確認のリクエスト、SSLでのメールサーバへの接続などいろりお昨日がある。
→続きはWebへ(swiftmailer.org)