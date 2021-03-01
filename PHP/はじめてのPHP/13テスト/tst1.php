単体テスト
  少量のコードを監査する
  当たり前みたいなテストでも、プログラムが大きくなるほど積み重ねが大事になる
PHPUnit
  PHPコードのテストを記述するためのデファクトスタンダード
  テスト自体も少量のコード
PHPUnitのインストール
  省略！

テストの記述
<?php
function resutaurant_check($meal, $tax, $tip) {
  $tax_amount = $meal * ($tax / 100);
  $tip_amount = $meal * ($tip / 100);
  $total_amount = $meal + $tax_amount + $tip_amount;
  return $total_amount;
}
?>

<?php
include 'resutaurant_check.php'; // 今回は真上にあるけどさ
class RestaurantCheckTest1 extends PHPUnit_Framework_TestCase {
  // extendsしたテスト用クラスを作成し、記述。
  public function testWithTaxAndTip() {
    $meal = 100;
    $tax = 10;
    $tip = 20;
    $result = resutaurant_check($meal, $tax, $tip);
    // assertEquals(得られるべき結果, 実際に得られた結果) で比較
    $this->assertEquals(130, $result);
  }
}
?>

PHPUnitプログラム側
ファイルを送信
  phpunit.phar RestaurantCheckTest.php
結果
  PHPUnit 4.8.11 by SebastianBergmann and contributors.
  .
  Time: 121 ms, Memory: 13.50Mb
  OK (1 test, 1assertion) // OKらしい

失敗する場合
<?php
include 'resutaurant_check.php'; // 今回は真上にあるけどさ
class RestaurantCheckTest2 extends PHPUnit_Framework_TestCase {
  public function testWithTaxAndTip() {
    $meal = 100;
    $tax = 10;
    $tip = 20;
    $result = resutaurant_check($meal, $tax, $tip);
    $this->assertEquals(130, $result);
  }
  public function testWithNoTip() {
    $meal = 100;
    $tax = 10;
    $tip = 0;
    $result = resutaurant_check($meal, $tax, $tip);
    $this->assertEquals(120, $result);
  }
}
?>
結果
PHPUnit 4.8.11 by SebastianBergmann and contributors.
  .F // 失敗のF
  Time: 129 ms, Memory: 13.50Mb
  There wa 1 failure:
  1) RestaurantCheckTest::testWithNoTip
  Failed asserting that 110.0 matches expected 120. // 110だったけど！？って
  RestaurantCheckTest.php:20 // 20行目だよって
  FAILURES!
  Tests: 2, Assertions: 2, Failures: 1.

チップの計算方法をテスト(チップの計算は税抜き時点？税込み時点？みたいな)
<?php
include 'resutaurant_check.php'; // 今回は真上にあるけどさ
class RestaurantCheckTest3 extends PHPUnit_Framework_TestCase {
  public function testWithTaxAndTip() {
    $meal = 100;
    $tax = 10;
    $tip = 20;
    $result = resutaurant_check($meal, $tax, $tip);
    $this->assertEquals(130, $result);
  }
  public function testWithNoTip() {
    $meal = 100;
    $tax = 10;
    $tip = 0;
    $result = resutaurant_check($meal, $tax, $tip);
    $this->assertEquals(120, $result);
  }
  public function testTipIsNotOnTax() {
    $meal = 100;
    $tax = 10;
    $tip = 10;
    $checkWithTax = resutaurant_check($meal, $tax, $tip);
    $checkWithoutTax = resutaurant_check($meal, 0, $tip);
    $expectedTax = $meal * ($tax / 100);
    // ちゃんと合計が合うかなって。
    $this->assertEquals($checkWithTax, $checkWithoutTax + $expectedTax);
  }
}
?>