PHPUnit
  テストのデファクトスタンダード
インストール
  実行可能形式に chmod a+x phpunit.phar
  実行          ./phpunit.phar -version
  (PHPコマンドラインでは実行だけ)

テスト用のクラスを作成
  PHPUnit_Framework_TestCaseを継承
テスト用のメソッドを作成
  test〇〇という名前でメソッドを作成
テスト
  継承したメソッドを利用
  assertEquals // ==判定
  assertSame // ===判定
  assertContains // 含まれるか
  assertCount // 要素数の一致か

<?php
// PHPUnit_Framework_TestCase を継承
class SampleCheckTest extends PHPUnit_Framework_TestCase {
  // test〇〇という名前でメソッドを作成
  public function testSample() {
    $テストの結果 = テストするメソッド('メソッドに限らないが');
    $返ってくるはずの答え = '文字列に限らないが';
    // 継承したメソッドを利用
    $this->assertEquals($返ってくるはずの答え, $テストの結果);
  }
}
?>
PHPUnitプログラム側へ渡す (コードはtst1.phpへ)

ファイルを送信
  phpunit.phar RestaurantCheckTest.php
結果
  PHPUnit 4.8.11 by SebastianBergmann and contributors.
  .
  Time: 121 ms, Memory: 13.50Mb
  OK (1 test, 1assertion) // OKらしい

結果(失敗の例)
  PHPUnit 4.8.11 by SebastianBergmann and contributors.
  .F // 失敗のF
  Time: 129 ms, Memory: 13.50Mb
  There was 1 failure:
  1) RestaurantCheckTest::testWithNoTip
  Failed asserting that 110.0 matches expected 120. // 120のはずなのに110だったけど！？って
  RestaurantCheckTest.php:20 // 20行目だよって
  FAILURES!
  Tests: 2, Assertions: 2, Failures: 1.

validationがちゃんと動くかのテストの例
<?php
class IsolateValidationTest extends PHPUnit_Framework_TestCase {
  public function testDecimalAgeNotValid() { // age
    // age を小数にしてやったぜ
    $submitted = array('age' => '6.7', 'price' => '100', 'name' => 'Julia');
    list($errors, $input) = validate_form($submitted);
    // ちゃんとエラー処理されたかテスト
    $this->assertContains('Please enter a valid age.', $errors);
    $this->assertCount(1, $errors);
  }
  public function testDollarSignPriceNotValid() { // price
    // priceに'$'記号つけてやったぜ
    $submitted = array('age' => '6', 'price' => '$52', 'name' => 'Julia');
    list($errors, $input) = validate_form($submitted);
    $this->assertContains('Please enter a valid price.', $errors);
    $this->assertCount(1, $errors);
  }
  public function testDataOK() { // data
    // 'Julia' を ' Julia' にしてやったがvalidate_formが修正してくれるはずだぜ
    $submitted = array('age' => '15', 'price' => '39.95', 'name' => ' Julia');
    list($errors, $input) = validate_form($submitted);
    // エラーないはずだ
    $this->assertCount(0, $errors);
    // 他全部確認
    $this->assertCount(3, $input);
    $this->assertSame(15, $input['age']);
    $this->assertSame(39.95, $input['price']);
    $this->assertSame('Julia', $input['name']);
  }
}
?>
