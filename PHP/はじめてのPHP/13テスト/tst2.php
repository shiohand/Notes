テスト対象の分離
テストは処理を小さく分けて雑音を取り除き、効率的に進めましょうという話。
assertEqual(こうなれ, 対象) // ==判定
assertSame(こうなれ, 対象) // ===判定
assertContains(これあれ, 対象)
assertCount(いくつであれ, 対象)
<?php
// いつもの
function validate_corm($submitted) {
  $errors = array();
  $input = array();

  $input['age'] = filter_var($submitted['age'] ?? NULL, FILTER_VALIDATE_INT);
  if ($input['age'] === false) {
    $errors[] = 'Please enter a valid age.';
  }

  $input['price'] = filter_var($submitted['price'] ?? NULL, FILTER_VALIDATE_FLOAT);
  if ($input['price'] === false) {
    $errors[] = 'Please enter a valid price.';
  }

  $input['name'] = trim($submitted['name'] ?? '');
  if (strlen($input['name']) == 0) {
    $errors[] = 'Your name is required.';
  }
  
  return array($errors, $input);
}

// フォームデータ検証のテスト
// validationがちゃんと動くかのテストなのでミスを混ぜる
class IsolateValidationTest extends PHPUnit_Framework_TestCase {
  // age
  public function testDecimalAgeNotValid() {
    // age を小数にしてやったぜ
    $submitted = array('age' => '6.7', 'price' => '100', 'name' => 'Julia');
    list($errors, $input) = validate_form($submitted);
    // 年齢に関するエラー
    $this->assertContains('Please enter a valid age.', $errors);
    $this->assertCount(1, $errors);
  }

  // price
  public function testDollarSignPriceNotValid() {
    // priceに'$'記号つけてやったぜ
    $submitted = array('age' => '6', 'price' => '$52', 'name' => 'Julia');
    list($errors, $input) = validate_form($submitted);
    // 年齢に関するエラー
    $this->assertContains('Please enter a valid price.', $errors);
    $this->assertCount(1, $errors);
  }

  // data
  public function testDataOK() {
    // 'Julia' を ' Julia' にしてやったがvalidate_formが修正してくれるはずだぜ
    $submitted = array('age' => '15', 'price' => '39.95', 'name' => ' Julia');
    list($errors, $input) = validate_form($submitted);
    // エラーないはずだ
    $this->assertCount(0, $errors);
    // まとめて確認
    $this->assertCount(3, $input);
    $this->assertSame(15, $input['age']);
    $this->assertSame(39.95, $input['price']);
    $this->assertSame('Julia', $input['name']);
  }
}
?>