Did you know that <?php echo file_get_contents('http://numbersapi.com/09/27') ?>

<?php
// $params = array('api_key' => 'NOB_API_KEY', 'q' => 'black pepper');
// $url = "http://api.nal.usda.gov/ndb/search?".http_build_query($params);
// $options = array('header' => 'Content-Type: application/json');
// $context = stream_context_create(array('http' => $options));
// $responce = file_get_contents($url, false, $context);
$responce = file_get_contents(
  "http://api.nal.usda.gov/ndb/search?".http_build_query(
    array(
      'api_key' => 'NOB_API_KEY',
      'q' => 'black pepper'
    )
  ),
  false,
  stream_context_create(
    array(
      'http' => array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => http_build_query(
          array(
            'name' => 'black pepper',
            'smell' => 'good'
          )
        )
      )
    )
  )
);
$info = json_decode($responce);
foreach ($info->list->item as $item) {
  print "The ndbno for {$item->name} is {$item->udbno}.\n";
}
?>
<?php
$params = array('api_key' => 'NOB_API_KEY', 'q' => 'black pepper');
$url = "http://api.nal.usda.gov/ndb/search?".http_build_query($params);

$c = curl_init($url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($c);

if ($result === false) {
  print "Error #".curl_errno($c)."\n";
  print "Uh-oh! cURL says: ".curl_error($c)."\n";
} else if ($info['http_code'] >= 400) {
  print "The server sais HTTP error {$info['http_code']}.\n";
} else {
  print "A successful result!\n";
}
?>
<?php
$url = 'http://php7.example.com/post-server.php';

$form_data = array('name' => 'black pepper', 'smell' => 'good');

$c = curl_init($url);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($form_data));
$result = curl_exec($c);
print $result;
?>
<?php
$value = $_COOKIE['c'] ?? 0;
$value++;
setcookie('c', $value);
print 'Cookies: '.count($_COOKIE)."\n";
foreach ($_COOKIE as $k => $v) {
  print "$k: $v\n";
}
?>
<?php
$c = curl_init('http://php7.example.com/cookie-server.php');
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_COOKIEJAR, __DIR__.'/saved.cookies');
curl_setopt($c, CURLOPT_COOKIEFILE, __DIR__.'/saved.cookies');
$res = curl_exec($c);
print $res;
?>
<?php
$response_data = array('now' => time());
header('Content-Type: application/json');
print json_encode($responce_data);
?>
<?php
if (! (isset($_GET['key']) && ($_GET['key'] == 'pineapple'))) {
  http_response_code(403);
  $response_data = array('error' => 'bad key');
} else {
  $responce_data = array('now' => time());
}
header('Content-Type: application/json');
print json_encode($responce_data);
?>
<?php
$is_https - (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on'));
if (! $is_https) {
  $newUrl = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  header("Location: $newUrl");
  exit();
}

$formats = array('application/json', 'text/html', 'text/plain');
$default_format = 'application/json';

if (isset($_SERVER['HTTP_ACCEPT'])) {
  if (in_array($_SERVER['HTTP_ACCEPT'], $formats)) {
    $format = $_SERVER['HTTP_ACCEPT'];
  } else {
    http_response_code(406);
    exit();
  }
} else {
  $format = $default_format;
}

$responce_data = array('now' => time());
header("Content-Type: $format");
if ($format == 'application/json') {
  print json_encode($responce_data);
} else if ($format == 'text/html') { ?>
<html>
<head>
  <title>Clock</title>
</head>
<body>
  <time><?php echo date('c', $responce_data['now']) ?></time>
</body>
</html>
<?php
} else if ($format == 'text/plain') {
  print $responce_data['now'];
}
?>
<?php
include 'restaurant-check.php';

class RestaurantCheckTest extends PHPUnit_Framework_TestCase {
  public function testWithTaxAndTip() {
    $meal = 100;
    $tax = 10;
    $tip = 20;
    $result = restaurant_check($meal, $tax, $tip);
    // 必要な値を作ったのでテスト実行
    $this->assertEquals(130, $result);
  }
}
// このクラスをPHPUnitで実行 phpunit.phar RestaurantCheckTest.php
?>
<?php
include 'isolate-validation.php';
class IsolateValidationTest extends PHPUnit_Framework_TestCase {
  public function testDicimalAgeNotValid() {
    $submitted = array('age' => '6.7', 'price' => '100', 'name' => 'Julia');
    list($errors, $input) = validate_form($submitted);
    $this->assertContains('Please enter a valid age', $errors);
    $this->assertCount(1, $errors);
  }
  public function testDollorSignPriceNotValid() {
    $submitted = array('age' => '6', 'price' => '$52', 'name' => 'Julia');
    list($errors, $input) = validate_form($submitted);
    $this->assertContains('Please enter a valid price', $errors);
    $this->assertCount(1, $errors);
  }
  public function testValidDataOK() {
    $submitted = array('age' => '15', 'price' => '39.95', 'name' => ' Julia');
    list($errors, $input) = validate_form($submitted);
    $this->assertCount(0, $errors);
    $this->assertSame(15, $input['age']);
    $this->assertSame(39.95, $input['price']);
    $this->assertSame('Julia', $input['name']);
  }
}
?>
<?php
$d = new DateTime();
print "It is now: {$d->format('r')}\n";
print $d->format('m/d/y');
$d->setDate($_POST['yr'], $_POST['mo'], $_POST['dy']);
$d->setTime($_POST['hr'], $_POST['mmn']);
print $d->format('r');
if (checkdate($_POST['yr'], $_POST['mo'], $_POST['dy'])) {
  echo $_POST['yr'], $_POST['mo'], $_POST['dy'];
}
$daysToPrint = 4;
$d = new DateTime('next Tuesday');
print "<select name=\"day\">\n";
for ($i = 0; $i < $daysToPrint; $i++) {
  print " <option>{$d->format('l F jS')}</option>\n"; // 曜日 月 日th
  $d->modify("+2 day");
}
print "</select>";
?>
<?php
$now = new DateTime();
$birthdate = new DateTime('1990-05-12');
$diff = $birthdate->diff($now);

if (($diff->y > 13) && ($diff->invert == 0)) {
  print 'You are more than 13 years old.';
} else {
  print 'Sorry, too young.';
}
// date_default_timezone_set(); タイムゾーン設定
?>
