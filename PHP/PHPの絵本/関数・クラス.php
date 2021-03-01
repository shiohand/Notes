
コールバック関数
<?php
function Hellofunc() {
  print "Hello";
}
function callfunc(callable $f) {
  $f();
  print " しおりさん";
}
callfunc("Hellofunk"); // 関数名は文字列で
?>

無名関数とコールバック関数
<?php
function callfunc2(callable $f) {
  $f();
  print " しおりさん";
}
callfunc2(function () {
  print "こんにちは";
});
?>
無名関数のスコープ
use (変数)
  外の変数を引数で渡されたときみたいに使える
  無名関数が宣言されている場所の変数のみ
<?php
$a = "おはよう";
$b = "しおりさん";
// 通常の関数
function func1($p) {
  global $b; // グローバルで引き込む
  print $p;
  print $b;
}
func1($a);
// 無名関数 function()のあとに use ()
$func2 = function($p) use ($b) {
  print $p;
  print $b;
};
$func2($a);
?>

func_num_args()   引数の数
func_get_arg(値)  引数のうちの一つを取得
func_get_args()   配列で取得
<?php
function print_arg_val() {
  $a = func_num_args();
  for ($i=0; $i < $a; $i++) { 
    $b = func_get_arg($i); // 順に取り出してprint
    print $b;
  }
}
function print_arg_arr() {
  $c = func_get_args();
  foreach ($c as $d) { // foreachで順にprint
    print $d;
  }
}
print_arg_val('A', 'B', 'C');
print_arg_arr('A', 'B', 'C');
?>


ジェネレータ
<?php
function ABC() {
  yield 'A';
  yield 'B';
  yield 'C';
}

foreach(ABC() as $c) {
  print "{$c}";
}
?>

戻り値はジェネレータであることに注意
<?php
function Count246() {
  for ($i=0; $i <= 3; $i++) { 
    yield $i * 2;
  }
}
$a = Count246(); // 代入
foreach ($a as $n) {
  print "{$n}";
}
?>

ジェネレータの戻り値
returnの使用 getReturn();
<?php
function Count246b() {
  for ($i=0; $i <= 3; $i++) { 
    yield $i * 2;
  }
  return "おわり";
}
$a = Count246(); // 代入
foreach ($a as $n) {
  print "{$n}";
}
print $a->getReturn();
?>

ジェネレータの委譲
yield from ジェネレータを引き継ぐ
<?php
function Count12345() {
  yield 1;
  yield 2;
  yield from Count345(); // 3度目で↓へ
}
function Count345() {
  yield 3;
  yield 4;
  yield 5;
}
foreach (Count12345() as $n) { // 受け取りは一緒
  print "{$n}";
}
?>


無名クラス
？
<?php
// 普通クラス
class Shiori {
  public function sayHello() {
    print "Hello";
  }
}
function Hello($s) {
  $s->sayHello();
}
$a = new Shiori();
Hello($a);
?>
<?php
// 無名クラス
function Hello2($s) {
  $s->sayHello2();
}
Hello2(new class {
  public function sayHello2() {
    print "Hello";
  }
});
?>


トレイト
  継承とは関係なくクラスにメソッドを追加するしくみ。
  定義はclassとほどんと同じ。
  使用はuse

<?php
trait OtherMethod {
  public function getHello() {
    return "Hello"; // いっしょや！
  }
}
class ShioriT {
  use OtherMethod; // インポート的な？
  public function sayHello() {
    print $this->getHello();
  }
}
$s = new ShioriT();
$s->sayHello();
?>