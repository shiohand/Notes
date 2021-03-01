<?php
namespace SpaceKun; // SpaceKun\spaceChan とかもあり
class Fruit {
  public static function munch($bite) {
    print "Here is a tiny munch of $bite.";
  }
}
class Neko {
  public static function neru() {
    print 'korokoro';
  }
}
?>

名前空間
  階層構造が作れて便利だよ君
  名前空間を宣言していないファイルは全て現在の名前空間がトップレベル名前空間
namespace 名前; // クォーテーション不要。
  名前空間の宣言(変更とも言えるか) コードの先頭 メタタグ的な。
  ファイル全体に有効ということかー。

呼び出し時は \名前空間\呼び出すもの となる。Math\random()的な。System\out\prinln()的な。
<?php
\SpaceKun\Fruit::munch('banana');
?>

宣言
  namespace 親名前空間\名前空間
利用
  use \親名前空間\名前空間;
  名前空間\Class::method()
  use \親名前空間\名前空間\Class as なまくー;
  なまくー::method();