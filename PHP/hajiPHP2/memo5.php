Composerでパッケージのインストール
  php composer.phar require swiftmailer/swiftmailer
  php composer.phar global require psy/psysh
    global(Composerディレクトリ)にインストールが必要な時

<?php
// Swift_Messageオブジェクト
$message = Swift_Message::newInstance();
$message->setFrom('mail@com');
$message->setTo(array('to@com' => 'name'));
$message->setSubject('title');
$message->setBody('text'); // text/plainのとき
// $message->addPart('html', 'text/html'); // MIMEタイプ指定
// Swift_Mailer(SMTP)
$transport = Swift_SmtpTransport::newInstance('smtp.com', 25); // ホスト, ポート番号
$mailer = Swift_Mailer::newInstance($transport);
$mailer->send($message);

// Swift_Message::newInstance()  setFrom, setTo, setSubject, setBody, addPart
// Swift_SmtpTransport::newInstance()
// Swift_Mailer::newInstance()  send
?>

<!-- Laravel -->
<?php
// app/Http/routes.php

Route::get('/show', function() {
  $now = new DateTime();
  $items = ['Fried Potatoes', 'Boiled Potatoes', 'Baked Potatoes'];
  return view('show-menu', ['when' => $now, 'what' => $items]);
})
?>
<!-- resource/views/show-menu.php -->
<p> At <?php echo $when->format('g:i a') ?>, here is what's available: </p>
<ul>
  <?php foreach ($what as $item) { ?>
  <li><?php echo $item ?></li>
  <?php } ?>
</ul>

<!-- Symfony -->
<?php
// src/AppBundle/Controllers/MenuController.php

// namespace AppBundle\Controller;
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use Symfony\Component\HttpFoundation\Response;
class MenuController extends Controller {
  /**
   * @Route("/show")
   * @Method("GET")
   */
  public function showAction() {
    $now = new DateTime();
    $items = ['Fried Potatoes', 'Boiled Potatoes', 'Baked Potatoes'];
    return $this->render("show-menu.html.twig", ['when' => $now, 'what' => $items]);
  }
}
?>
<!-- app/Resources/views/show-menu.html.twig -->
{% extends 'base.html.twig' %}
{% block body %}
<p> At {{ when|date("g:i a") }}, here is what's available: </p>
<ul>]
  {% for item in what %}
  <li>{{ item }}</li>
  {% endfor %}
</ul>
{% endblock %}

<!-- Zend Framework -->
<?php
// module/Application/src/Application/Controller/MenuController.php

// namespace Application\controller;
// use Zend\Mvc\Controller\AbstractActionController;
// use Zend\View\Model\ViewModel;

class MenuController extends AbstractActionController {
  public function showAction() {
    $now = new DateTime();
    $items = ['Fried Potatoes', 'Boiled Potatoes', 'Baked Potatoes'];

    return new ViewModel(array('when' => $now, 'what' => $items));
  }
}
?>
<?php
// module/Application/config/module.config.php
// controllers定義部分に追加
array( // 中略
  'controllers' => array(
    'invokables' => array(
      'Application\Controller\Index' => 'Application\Controller\IndexController',
      'Application\Controller\Menu' => 'Application\Controller\MenuController' // 新規作成分
    )
  )
)
?>
<!-- module/Application/view/application/menu/show.phtml -->
<p> At <?php echo $when->format('g:i a') ?>, here is what's available: </p>
<ul>
<?php foreach($what as $item) { ?>
<li><?php echo $this->escapeHtml($item) ?></li>
<?php } ?>
</ul>

<?php
// コマンドラインPHP
// php wheather2 郵便番号 で実行する
// $_SERVER['argv'] 0=>'php' 1=>'wheather2' 2=>'郵便番号'
if (isset($_SERVER['argv'][1])) {
  $zip = $_SERVER['argv'][1];
} else {
  print "Please specify a zip code.\n";
  exit();
}
$yql = 'select item.condition from weather forecast where woeid in '.'(select woeid from geo.places(1) where text="'.$zip.'")';
$params = array("q" => $yql, 'format' => 'json', 'env' => 'store://datatables.org/alltableswithkeys');
$url = 'https://query.yahooapis.com/v1/public/yql?'.http_build_query($params);
$response = file_get_contents($url);
$json = json_decode($response);
$conditions = $json->query->results->channel->item->condition;
print "At {$conditions->date} it is {$conditions->temp} degrees and {$conditions->text} in $zip\n";
?>

<!-- 組み込みWebサーバの利用 -->
php -S localhost:8000
  -Sで組み込みWebサーバの使用(今回は8000)
php -S localhost:8000 -t /home/mario/web
  -tはドキュメントルートディレクトリの変更

REPLの利用 コンソールのやつ
php -aで起動
php >
が出る

print strlen('mushrooms'); // 9
$releases = simplexml_load_file("https://secure.php.net/releases/feed.php");
print $releases->entry[0]->title; // PHP 7.0.5 released!
的な


組み込み以外のREPL
  PsySH

<!-- ローカライゼーション -->
mb_convert_encoding(文字列, 文字コード)
mail()
mb_send_mail($to, $subject, $body)
mb_encode_mimeheader(文字列) (toに日本語を使うとき)
<?php
ini_set('mbstring.language', 'Japanese');
$name = '鈴木太郎';
$to = mb_encode_mimeheader($name)."<taro@example.com>";
$subject = "ごあいさつ";
$body = "こんにちは、$name さん";
mb_send_mail($to, $subject, $body);
?>
<?php
// Collatorクラス
$words = array('ka', 'か', 'が', 'カ', 'ガ');

$en = new Collator('en_US'); // en_USのCollator
$ja = new Collator('ja_JP'); // ja_JPのCollator
print "Befor sorting: ".implode(', ', $words)."\n";
$en->sort($words);
print "en_US sorting: ".implode(', ', $words)."\n";
$ja->sort($words);
print "ja_JP sorting: ".implode(', ', $words)."\n";
?>

<!-- 出力のローカライズ -->
<?php

$messages = array();
$messages['en_US'] = array('FAVORITE_FOODS' => 'My favorite food is {0}', 'COOKIE' => 'cookie', 'SQUASH' => 'squash');
$messages['ja_JP'] = array('FAVORITE_FOODS' => '私の好きな食べものは{0}です', 'COOKIE' => 'クッキー', 'SQUASH' => 'かぼちゃ');
// $messages ('en_US', 'ja_JP')
// 必要な値でMessageFormatterを作成
$fmtfavs = new MessageFormatter('ja_JP', $messages['ja_JP']['FAVORITE_FOODS']);
$fmtcookie = new MessageFormatter('ja_JP', $messages['ja_JP']['COKIE']);

$cookie = $fmtcookie->format(array());
// クッキー
// 引数にはプレースホルダに代入するものを入れる
print $fmtfavs = $fmtfavs->format(array($cookie));
// 私の好きな食べものはクッキーです
?>
<?php
$msg = "The cost is {0,number,currency}.";

// 必要な値でMessageFormatterを作成
$fmtUS = new MessageFormatter('en_US', $msg);
print $fmtUS->format(array(1023.5));
?>

<!-- 構成ディレクティブ -->
<?php phpinfo(); // バージョン情報などのまとまったページが表示される ?>

ini_set(構成ディレクティブ名, 値)
ini_get(構成ディレクティブ名)

構成ディレクティブ
date.timezone
display_errors
error_reporting
file_uploads
include_path
log_errors
output_buffering
session.auto_start
session.gc_maxlifetime
session.gc_probability
short_open_tag
track_errors (本番ではOffにしよう)
upload_max_filesize