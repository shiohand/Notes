キーワードや関数は大文字小文字の区別ができない。
IFとかPRiNtとか<?phP ?>とかなんでも。まあ使わんけど
<?php
print number_format(1);
print Number_Format(21);
print NUMBER_FORMAT(321);
?>

○名前空間
宣言
  namespace 親名前空間\名前空間
利用
  use \親名前空間\名前空間;
  名前空間\Class::method()
  use \親名前空間\名前空間\Class as なまくー;
  なまくー::method();

○変数の未初期化状態 null
呼び出して表示とかだけなら(例えばprintではnull表示なので)問題ないが
利用しようとするのはnullぽ程度に無理
なのでコンストラクタの失敗とかで存在しない変数を定義してしまってもそれはnullの変数ができるだけなのでエラーとかは出ず、出力する程度であればただ何も表示されないだけなので気を付けるべし。（問題集の中では、親クラスのprivate変数を子クラスのコンストラクタから初期化しようとしてバグ）

○アクセス修飾子
public すべて
protected サブクラス
private 自クラスのみ

〇$_SERVER[]
PHP_SELF    REQUEST_METHOD QUERY_STRING
PATH_INFO   SERVER_NAME    DOCUMENT_ROOT
REMOTE_ADDR HTTP_REFERER   HTTP_USER_AGENT
            (REFERRERが正しいけど慣習)

現在のリクエストのパス部分 formのactionに入れておけば楽
  action=""に入れる PHP_SELF丸覚え
通常のリクエストの結果か、POSTなら'POST'が入っている
  method=""部分 リクエスト
?以降のクエリ部分
  クエリ文字列
URL末尾のパス部分
  パス情報
Webサイト名。仮想ドメインなら仮想ドメイン名。
  サーバー名
なんかWebサーバーコンピュータ上のディレクトリらしいよ
  ルートディレクトリ
リクエスト者のIPアドレス
  REMOTE先の住所
訪問者の踏んだリンクのあるURL 偽装できるけど
  HTTPのref
ブラウザ情報 偽装できるけど
  HTTPのユーザーエージェント

○バリデーション/サニタイジング
filter_input(取得対象, 対象変数, フィルタ[, オプション])
  正しければ値そのまま, 誤りならfalse, 入力がなければnull
取得対象  INPUT_GET/POST/COOKIE/SERVER/ENV
対象変数  'キーになる部分'
フィルタ  FILTER_VALIDATE_BOOLEAN/FLOAT/INT/EMAIL/URL/IP/MAC
オプション
  INT    min_range, max_range
  FLOAT  decimal, min_range, max_range
利用例
  $input['age'] = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT,
    array('options' => array('min_range' => 18, 'max_range' => 65)));
  // optionを連想配列にを、array('option' => の値として渡す)

filter_var(対象変数, フィルタ[, オプション])
  もあるらしい

htmlentities() 主に使う
strip_tags() 変換基準がザルな方

○データベース エラーモード フェッチスタイル
PDO::ATTR_ERRMODE
  PDO::ERRMODE_EXCEPTION
  PDO::ERRMODE_WARNING
PDO::ATTR_DEFAULT_FETCH_MODE
  PDO::FETCH_NUM   $row[0], $row[1];
  PDO::FETCH_ASSOC $row[dish_name], $row[price];
  PDO::FETCH_OBJ   $row->dish_name, $row->price;


〇ファイル操作
open()の第二引数
  rb  R  既存ファイルのみ     絶対読む
  wb  W  読み込み時に内容消去  絶対書く
  ab  W  末尾開始           逆張り
  xb  W  新規ファイルのみ     ニュービー感
  cb  W  内容を空にしない     wbじゃない方
  末尾+(rb+, cb+など)       読み書き可能

fgetcsv(), fputcsv()
  csvフォーマット
CSVファイル使うよ宣言が必要
<?php
// CSVファイル使うよ宣言
header('Content-Type: text/csv');
// CSVファイルを別のプログラムで表示すべきだよ宣言
header('Content-Disposition: attachment; filename="dishes.csv"');
?>

〇クッキーとセッション
setcookie() や session_start() はプログラムの一番上に 


〇
strftime()
  日付時間データをロケールの設定に基づいてフォーマット


メソッド
strcasecmp
substr(文字列, 始, 文字数)
substr(文字列, -x, x) → 末尾x文字
str_replace(前, 後, 文字列)
strtr(文字列, array('前' => '後', '前' => '後'...))

戻り値:boolean
  array_key_exists(値, 配列) // キーで探す
  in_array(値, 配列) // 値で探す
戻り値:キー
  array_search // 値で探す

  implode(区切り文字, 配列)
  explode(区切り文字, 文字列)


<?php
// 文字列の絡む比較
"1 abc" > "1 abc"; // 辞書
"123" > "123";     // 数値
"123" > 123;       // 数値
"1 abc" > 123;     // 数値(どちらかが数値型)
strcmp($a, $b);    // 常に辞書

// 宇宙演算子 値で返す オブジェクトなども
// 等しければ0、つまりfalseなので、!(否定)すればbooleanとしても使える
1 <=> 1; // 等 ０  0
1 <=> 2; // 小 負 -1
2 <=> 1; // 大 正  1
strcmp($a, $b); // 常に辞書 宇宙演算子と同じ
strcasecmp($a, $b); // 大文字小文字を区別しない
?>

http_build_query(連想配列)  クエリに変換