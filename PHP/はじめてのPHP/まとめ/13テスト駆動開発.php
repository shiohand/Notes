テスト駆動開発 TDD:Test-Driven Development
テストを有効活用するためのプログラミングのテクニック
コード書く前にテスト書いておいて、そこを目指す感じにしようって感じかと思う感じ

やってみそ(→tst3.php)
新機能:restaurant_check()の第4引数に、チップ計算に税金を含めるか否かのboolを追加したい
<?php
class RestaurantCheckTest1 extends PHPUnit_Framework_TestCase {
  public function testTipShouldIncludeTax() {
    $meal = 100;
    $tax = 10;
    $tip = 10;
    // 税込み計算(true)指定
    $result = restaurant_check($meal, $tax, $tip, true);
    // 完成時には121になっているはず
    $this->assertEquals(121, $result);
  }
  public function testTipShouldNotIncludeTax() {
    $meal = 100;
    $tax = 10;
    $tip = 10;
    // 税抜き計算(false)指定
    $result = restaurant_check($meal, $tax, $tip, false);
    // 完成時には120になっているはず
    $this->assertEquals(120, $result);
  }
}
?>
結果
  PHPUnit 4.8.11 by Sebastion Bergmann and contributors.
  ...F.
  Time: 138 ms, Memory: 13.50Mb
  There was 1 failure:
  1) RestaurantCheckTest::testTipShouldIncludeTax
  Failed asserting that 120.0 matches expected 121.
  RestaurantCheckTest.php:40
  FAILURES!
  Tests: 5, Assertions: 5, Failures: 1.

↑を通過できるようになるのがゴール

計算ロジックの変更など

変更後のテスト結果
  PHPUnit 4.8.11 by Sebastion Bergmann and contributors.
  .....
  Time: 120 ms, Memory: 13.50Mb
  OK (4 tests, 5 assertions)

ゴール！