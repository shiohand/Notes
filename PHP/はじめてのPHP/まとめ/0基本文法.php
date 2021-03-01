<?php
// require include
require 'ファイル名.php';
include 'ファイル名.php';
require_once('ミス防止.php');
// ファイルの探し方
// 絶対パス、相対パス　→　そのまま
// そのほか　→　構成ディレクティブinclude_pathってやつ、なければ現在地

// コメント
# こめ
// こめ
/* こめ */

// 変数
$変数 = '識別子　アンダーバーおｋ。一文字目は数字がだめ';
"{$変数展開}はダブルクォーテーション内で";
// $inst->method()とかも入るよ　ハイライトきもいけど
?>

型
int, integer
float, double, real
string
bool, boolean
array
object
resource
null
callable なんか関数名とかメソッド名とかなんとか

<?php
// クォーテーション
'シングルクォーテーション';
  'エスケープ文字\\は使えるが\nなどのセットや変数展開は使えない';
"ダブルクォーテーション";
  "\n, \t, \x0ff, とか特殊な出力がきく";

// ヒアドキュメント
<<<識別子
<h1>ダブルクォーテーション同様</h1>
<p>{$変数展開}が可能</p>
識別子;
// ナウドキュメント
$text = <<<'識別子'
<h1>シングルクォーテーション同様</h1>
<p>識別子をシングルクォーテーションで囲む</p>
識別子;
// "識別子"もヒアドキュメント

// 文字列
print "出力";
echo "出力";

// 文字列結合
"普通に" + "ぷらす";
"文字列の"."結合のピリオド";
?>

配列
<?php
$apple = 'red';

$arr = ['apple' ,'banana', 'grape'];
$arr2 = array('apple' ,'banana', 'grape');
$arr3 = array(0 => 'apple', 1 => 'banana', 2 => 'grape');

$arr4 = ['apple' => 'red', 'banana' => 'yellow', 'grape' => 'purple'];
$arr5 = array('apple' => 'red', 'banana' => 'yellow', 'grape' => 'purple');
?>

if文 for文 条件式
elseif
foreach ($array as $val)
foreach ($array as $key => $val)
<?php
if('条件式') {}
elseif('条件式') { 'else ifでもいいよ'; }
else {}

while (! '条件式') {}

for ($i = 0; $i < count($arr); $i++) {
  echo $i, ".", $arr[$i], ' 値の更新が複数可能だったりはJavaといっしょ<br>';
}
foreach ($arr as $val) {
  echo $val.'<br>';
}
foreach ($arr2 as $key => $val) {
  echo $key.' '.$val.'<br>';
  echo "...代入などして扱うなら{$arr2[$key]}に。<br>";
}
?>

関数, クラス, 例外処理
○アクセス修飾子
public    すべて
protected サブクラス
private   自クラスのみ
  デフォルトはpublic
  varを使って宣言したプロパティはpublic

<?php
// 関数の宣言と呼び出し
function func1($引数) {
  // 処理;
}

// 引数
// デフォルト値の指定可能（オプション引数）
function func2($name, $color = "ff0000") {}
// 引数を省略できる。デフォルト値は変数ではいけない。

// 引数の型の指定
// array, bool, callable, float, int, string, クラス名
// 戻り値の型の指定（return）
function func3(string $name) {}
function func4(): bool { return true; }

// OOP
// クラス　メソッド　プロパティ　インスタンス　コンストラクタ　静的メソッド
class ParCls {
  public function __construct() {}
}

class Cls extends ParCls{
  public $prop1;
  public static $prop2;
  public function method1() {}
  public static function method2() {}
  
  // コンストラクタ
  public function __construct() {
    // 親のコンストラクタ
    parent::__construct();
  }
  public function get_objs() {
    // this(自インスタンス)とself(自クラス)
    $this->prop1;
    self::$prop2;
  }
}

$inst = new Cls();
// プロパティ、メソッドの呼び方。後ろは名前だけなので注意
$inst->prop1; $inst->method1();
// クラスオブジェクト
Cls::$prop2; Cls::method2();


// 例外処理
throw new Exception('内容');
// Exceptionオブジェクトを生成、発行
try {} catch (Exception $e) {}
// try-catch構文 $eからスタックトレース（停止時に動作していた全関数一覧）を得る
$e->getMessage()
// 例外の生成時に渡せれたメッセージ（エラー内容）の取得
?>