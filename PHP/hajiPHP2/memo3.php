file_get_contents(ファイル);
file_put_contents(ファイル, 内容);
<?php
$fh = fopen('people.txt', 'rb');
while ((! feof($fh)) && ($line = fgets($fh))) {
  $line = trim($line);
  $info = explode('|', $line);
  print '<li><a href="mailto:'.$info[0].'">'.$info[1].'</a></li>'."\n";
}
fclose($fh);
?>
<?php
try {
  $db = new PDO('sqlite:/temp/restaurant.db');
} catch (PDOException $e) {
  print "Couldn't connect to database: ".$e->getMessage();
  exit();
}

$fh = fopen('dishes.txt', 'wb');
$q = $db->query("SELECT dish_name, price FROM dishes");
while($row = $q->fetch()) {
  fwrite($fh, "The price of $row[0] is $row[1] \n");
}
fclose($fh);

$fh = fopen('dishes.csv', 'rb');
$stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy) VALUES (?, ?, ?)');
while((! feof($fh)) && ($info = fgetcsv($fh))) {
  // 0.料理名 1.値段 2.辛さ
  $stmt->execute($info);
  print "Inserted $info[0]\n";
}
fclose($fh);

$fh = fopen('dish-list.csv', 'wb');
$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');
while($row = $dishes->fetch(PDO::FETCH_NUM)) {
  fputcsv($fh, $row);
}
fclose($fh);
?>
<?php
header('Content-type: text/csv');
header('Content-Disposition: attachment; filename=dishes.csv"');
$fh = fopen('php://output', 'wb'); // ちょっと特殊
$dishes = $db->query('SELECT dish_name, price, is_spicy FROM dishes');
while ($row = $dishes->fetch(PDO::FETCH_NUM)) {
  fputcsv($fh, $row);
}
?>
<?php
if (file_exists('/usr/local/htdocs/index.html')) {
  print "Inde file is there.";
} else {
  print "No index file in /usr/local/htdocs.";
}
$template_file = 'page-template.html';
if (is_readable($template_file)) {
  $template = file_get_contents($template_file);
} else {
  print "Can't read template file.";
}
$log_file = '/var/log/users.log';
if (is_writable($log_file)) {
  $fh = fopen($log_file, 'ab');
  fwrite($fh, $_SESSION['username'].'at'.strftime('%c')."\n");
  fclose($fh);
} else {
  print "Can't write to log file.";
}
?>
<?php
// パスを入れられると困るときの無害化
$user = str_replace('/', '', $_POST['user']);
$user = str_replace('..', '', $user);

if (is_readable("/usr/local/data/$user")) {
  print 'User profile for '.htmlentities($user).':<br>';
  print file_get_contents("/usr/local/data/$user");
}
// realpath()版
// 一旦文字列に
$filename = realpath("/usr/local/data/{$_POST['user']}");
// 確認
$len = '/usr/local/data/';
if (('/usr/local/data/' == substr($filename, 0, $len)) && is_readable($filename)) {
  print 'User profile for '.htmlentities($_POST['user']).':<bt>';
  print file_get_contents($filename);
} else {
  print "Invalid user entered.";
}
?>
<?php
setcookie('userid', 'ralph', time() + 60 * 60);
$d = new DateTime("2019-10-01 12:00:00");
setcookie('much-longer-userid', 'ralph', $d->format('U'));
setcookie('short-userid', 'ralph', 0, '/~alice'); // パスで利用範囲決定
setcookie('short-userid', 'ralph', 0, '/', '.example.com'); // ドメイン。関係のないページで送らないように
setcookie('short-userid', 'ralph', 0, null, null, true, true); // https制限(必須), httponly(javascriptからのアクセスを禁止)
?>
<?php
session_start();

if (isset($_SESSION['count'])) {
  $_SESSION['count'] = $_SESSION['count'] + 1;
} else {
  $_SESSION['count'] = 1;
}
print "You've looked at this page {$_SESSION['count']} times.";
?>

<?php
require 'FormHelper.php';

session_start();
ini_set('session.gc_probablity', 1); // 期限切れセッションの削除の割合
ini_set('session.gc_maxlifetime', 600);
// ini_set('session.○○', 値)
// name
// あとは順番通りcookie_lifetime, cookie_path, domain, secure, heeponly

$main_dishes = array(
  'cuke' => 'Braised Sea Cucumber',
  'stomach' => 'Sauteed Pig\'s Stomach',
  'tripe' => 'Sauteed Tripe with Wine Sauce',
  'taro' => 'Stewed Pork wigh Taro',
  'giblets' => 'Baked Giblets with Salt',
  'abalone' => 'Abalone with Marrow and Duck Feet'
);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors, $input) = validate_form();
  if ($errors) {
    show_form($errors);
  } else {
    process_form($input);
  }
} else {
  show_form();
}

function show_form($errors = array()) {
  $form = new FormHelper();

  if ($errors) {
    $errorHtml = '<ul><li>';
    $errorHtml .= implode('</li><li>', $errors);
    $errorHtml .= '</li</ul>';
  } else {
    $errorHtml = '';
  }
  print <<<_FORM_
  <form method="POST" action="{$form->encode($_SERVER['PHP_SELF'])}">
    $errorHtml
    Username: {$form->input('text', ['name' => 'username'])} <br>
    Password: {$form->input('text', ['name' => 'password'])} <br>
    {$form->input('submit', ['value' => 'Order'])}
  </form>
  _FORM_;
}

function validate_form() {
  $input = array();
  $errors = array();

  $users = array('allice' => 'dog123', 'bob' => 'my^pwd', 'charlie' => '**fun**');

  $input['username'] = $_POST['username'] ?? '';
  if (! array_key_exists($input['username'], $users)) {
    $errors[] = 'Please enter a alid username and password.';
  } else {
    $saved_password = $users[$input['username']];
    $submitted_password = $_POST['password'] ?? '';
    // password_veryfy(比べるパスワード(未ハッシュ化), 保存されているパスワード(既ハッシュ化))
    if (! password_verify($saved_password, $submitted_password)) {
      $errors[] = 'Please enter a valid username and password.';
    }
  }
  return array($errors, $input);
}

function process_form($input) {
  $_SESSION['username'] = $input['username'];
  print "Whelcome, {$_SESSION['username']}";
}
?>
<?php
session_start();
if (isset($_SESSION['order']) && (count($_SESSION['order']) > 0)) {
  print '<ul>';
  foreach ($_SESSION['order'] as $order) {
    $dish_name = $main_dishes[$order['dish']];
    print "<li> {$order['quantitiy']} of $dish_name </li>";
  }
  print '</ul>';
} else {
  print "You haven't ordered anything.";
}
?>
