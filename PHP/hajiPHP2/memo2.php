<?php
class Entree {
  private $name;
  protected $ingredients = array();

  public function __construct($name, $ingredients) {
    if (! is_array($ingredients)) {
      throw new Exception('$ingredients must be array');
    }
    $this->name = $name;
    $this->ingredients = $ingredients;
  }
  public function getName() {
    return $this->name;
  }
  public function hasIngredient($ingredient) {
    return in_array($ingredient, $this->ingredients);
  }
}

try {
  $drink = new Entree('Glass of Milk', 'milk'); // 第二引数がarrayじゃない
  if ($drink->hasIngredient('milk')) {
    print "Yummy!";
  }
} catch (Exception $e) {
  print "Could'nt create the drink:".$e->getMessage();
}

class ComboMeal extends Entree {
  public function __construct($name, $entrees) {
    parent::__construct($name, $entrees);
    foreach ($entrees as $entree) {
      if (! $entree instanceof Entree) {
        throw new Exception('Elements of $entrees must be Entree objects');
      }
    }
  }
  public function hasIngredient($ingredient) {
    foreach ($this->ingredients as $entree) { // 単品の内容掘り下げて探す
      if ($entree->hasIngredient($ingredient)) {
        return true;
      }
    }
    return false;
  }
}

$soup = new Entree('Chicken Soup', array('chicken', 'water'));
$sandwich = new Entree('Chicken Sandwich', array('chicken', 'bread'));
// いいけどちょっと分かりにくい
$combo = new ComboMeal('Soup + Sandwich', array($soup, $sandwich));

foreach (['chicken', 'water', 'pickles'] as $ing) {
  if ($combo->hasIngredient($ing)) {
    print "Something in the combo contains $ing.\n";
  }
}
?>

名前空間
宣言
  namespace 親名前空間\名前空間
利用
  use \親名前空間\名前空間;
  名前空間\Class::method()
  use \親名前空間\名前空間\Class as なまくー;
  なまくー::method();

$_SERVERの変数
QUERY_STRING     追加のパス情報のクエリ文字列部分 ?含まず
PATH_INFO        追加のパス情報
SERVER_NAME      PHPエンジンの動作している場所
DOCUMENT_ROOT    サーバのルートパス
REMOTE_ADDR      クライアントIP
REMOTE_HOST      クライアントホスト名
HTTP_REFERER     遷移元
HTTP_USER_AGENT  クライアントの環境

filter_input(INPUT_POST, 'name', FILTER_VALIDATE_INT, array('options' => array('option' => 'value')))
new DateTime(strtotime('yyyy-m-d'))
  作れる

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ($form_errors = validate_form()) { // バリデーションでエラーがあったら
    show_form($form_errors); // 入力フォームの表示
  } else {
    process_form(); // 完了フォームを表示
  }
} else {
  show_form(); // 入力フォームの表示
}
function process_form() {
  print "Hello, {$_POST['my_name']}";
}
function show_form($errors = array()) { // 引数なしのときは空
  if ($errors) {
    print 'Please correct these errors: <ul><li>';
    print implode('</li><li>', $errors); // liとして並べる
    print '</li></ul>';
  }
  print<<<_HTML_
<form action="{$_SERVER['PHP_SELF']}" method="post">
Your name: <input type="text" name="my_name">
<br>
<input type="submit" value="Say Hello">
</form>
_HTML_;
}

function validation_form() {
  $errors = array(); // エラーがあれば配列に追加していく
  $input = array(); // 入力済みのものを追加していく
  // name
  $input['name'] = trim($_POST['name'] ?? '');
  if (strlen($input['name']) == 0) {
    $errors[] = "Your name is required.";
  }
  // age
  $input['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, array('options' => array('min_range' => 18, 'max_range' => 65))); // 型判定
  if (is_null($input['age']) || ($input['age'] === false)) { // 値が入らなかったかfalseで
    $errors[] = 'Please enter a valid age between 18 and 65.';
  }
  // email
  $input['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // 型判定
  if (! $input['email']) {
    $errors[] = 'Please enter a valid email address.';
  }
  // price
  $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
  if (is_null($input['price']) || ($input['price'] === false) || ($input['price'] < 10) || ($input['price'] > 50.00)) { // オプション使わなかったらこうだけど使え
    $errors[] = 'Please enter a valid price between $10 and &50.';
  }
  // date
  $range_start = new DateTime('6 months ago'); // 6ヶ月後
  $range_end = new DateTime(); // 今
  // 年月日別範囲確認
  $input['year'] = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1900, 'max_range' => 2100)));
  $input['month'] = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 12)));
  $input['day'] = filter_input(INPUT_POST, 'day', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1, 'max_range' => 31)));
  // checkdate()で確認
  if ($input['year'] && $input['month'] && $input['day'] && checkdate($input['month'], $input['day'], $input['year'])) {
    $submitted_date = new DateTime(strtotime($input['year'].'-'.$input['month'].'-'.$input['day']));
    // 日付範囲と比較
    if (($range_start > $submitted_date) || ($range_end < $submitted_date)) {
      $errors[] = 'Please choose a date less than six months old.';
    }
  } else { // checkdate()失敗
    $errors[] = 'Please enter a valid date.';
  }
  return array($errors, $input); // エラーがなくても空の配列を返す
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $defaults = $_POST; // 受け取った値を全部
} else { // postじゃない
  $defaults = array(
    'delivery' => 'yes',
    'size' => 'medium',
    'main_dish' => array('taro', 'tripe'),
    'sweet' => 'cake'
  );
}
// textarea
print '<textarea name="comments">';
print htmlentities($defaults['comments']);
print '</textarea>';

// select
$sweets = array(
  'puff' => 'Sesami Seed Puff',
  'square' => 'Coconut Milk Gelatin Square',
  'cake' => 'Brown Suger Cake',
  'ricemeat' => 'Sweet Rice and Meat'
);
print '<select name="sweet">';
foreach ($sweets as $option => $label) {
  print '<option value="'.$option.'"';
  if ($option == $defaults['sweet']) { // selected
    print ' selected';
  }
  print "> $label</option>\n";
}
print '</select>';

// select multiple
$main_dihses = array(
  'cuke' => 'Braised Sea Cucumber',
  'stomach' => 'Sauteed Pig\'s Stomach',
  'tripe' => 'Sauteed Tripe with Wine Sauce', // 今回のデフォルト
  'taro' => 'Stewed Pork with Taro',          // 今回のデフォルト
  'giblets' => 'Baked Giblets with Salt',
  'abalone' => 'Abalone with Marrow and Duck Feet'
);
print '<select name="main_dish[]" multiple>';
// selectedがあるべき値をキーにした配列(array_key_exists()用)
$selected_options = array();
foreach ($defaults['main_dish'] as $option) {
  $selected_options[$option] = true;
}
// <option>出力
foreach ($main_dishes as $option => $label) {
  print '<option value="'.htmlentities($option).'"';
  if (array_key_exists($option, $selected_options)) {
    print ' selected';
  }
  print '>'.htmlentities($label).'</option>';
  print "\n";
}
print '</select>';

// checkbox
print '<input type="checkbox" name="delivery" value="yes"';
if ($defaults['delivery'] == 'yes') {
  print ' checked';
}
print '>Delivery?';

// radio
$checkbox_options = array(
  'small' => 'Small',
  'medium' => 'Medium',
  'large' => 'Large'
);
foreach ($checkbox_options as $value => $label) {
  print '<input type="radio" name="size" vlaue"'.$vlaue.'"';
  if ($defaults['size'] == $value) {
    print ' checked';
  }
  print "> $label ";
}
?>
