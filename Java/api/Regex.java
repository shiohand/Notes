package api;

import java.util.regex.Pattern;

public class Regex {
  public static void out(Object o) {
    System.out.println(o);
  }

  public static void 単純な判定() {

    /* bool = Pattern.matches */
    /* bool = str.matches */

    // 電話番号のマッチを確認する
    var tel = new String[] {"080-0000-0000", "084-000-0000", "184-0000"};
    var rx = "\\d[2,4]-\\d{2,4}-\\d{4}";
    for (var t : tel) {
      // matches(パターン, 対象) マッチなら(true)その文字列 でなければ(false)"アンマッチ"
      out(Pattern.matches(rx, t) ? t : "アンマッチ");
      // Stringクラスのmatchesメソッドを使う場合
      out(t.matches(rx) ? t : "アンマッチ");
      // Matcherにもmatchesがある 繰り返すならパターンを毎回コンパイルしなくてよいので有利
    }
    // 結果
    // 080-0000-0000
    // 084-000-0000
    // アンマッチ
  }

  public static void PatternとMatcherを利用() {

    /* ptn = Pattern.compile(reg) */
    /* mtr = ptn.matcher(str) */
    /* mtr .find() */
    /* mtr .start() .end() .group() .group(idx) */

    var str = "会社の電話は0123-99-0000です。自宅は000-123-4567だよ。";
    var ptn = Pattern.compile("(\\d[2,4])-(\\d{2,4})-(\\d{4})"); // new ではないよ
    var mtr = ptn.matcher(str); // new ではないよ
    // マッチ1 0123-99-0000
    // マッチ2 000-123-4567

    while (mtr.find()) { // fetch的なか
      out("開始位置："       + mtr.start());
      out("終了位置："       + mtr.end());
      out("マッチング文字列：" + mtr.group());  // マッチ全体(group[0]) 0123-99-0000
      out("市外局番："       + mtr.group(1)); // サブマッチ1(group[1]) 0123
      out("市内局番："       + mtr.group(2));
      out("加入者番号："      + mtr.group(3));
      out("------");
    }
  }

  public static void Patternにフラグ利用() {

    /* Pattern.compile(String reg[, int flags]) */

    // 主なフラグ
    var flags = new String[] {
      // 定数名 : 埋め込みフラグ文字 説明
      "CASE_INSENSITIVE : i 大文字小文字を区別しない",
      "MULTILINE        : m 複数行モード 行ごとに^(先頭)$(末尾)を扱える",
      "DOTALL           : s ドット(.)が行末記号を含む任意の文字にマッチ",
      "UNICODE_CASE     : u 大文字と小文字を区別しない(Unicodeに準拠)",
      "UNIX_LINES       : d 行末記号は\\nだけ",
      "LITERAL          :   パターンをリテラル文字として解析(\\dとか無効化)",
      "COMMENTS         : x 空白とコメントの有効化"
    };

    out(flags[0]);
    /* CASE_INSENSITIVE */
    var str = "仕事用はmail@ex.comで、プライベート用はMAIL@priv.comです。";
    // オプション付きでコンパイル
    var ptn = Pattern.compile("小文字を想定した正規表現(省略)", Pattern.CASE_INSENSITIVE);
    // Matcherに
    var mtr = ptn.matcher(str);
    while (mtr.find()) {
      out(mtr.group());
      // mail@ex.com
      // MAIL@priv.com
    }

    out(flags[1]);
    /* MULTILINE */
    str = "10人のインディアン。\n1年生になったら";
    // "^\\d*" 先頭の\d*
    ptn = Pattern.compile("^\\d*", Pattern.MULTILINE);
    mtr = ptn.matcher(str);
    while (mtr.find()) {
      out(mtr.group());
      // 10
      // 1
    }

    out(flags[2]);
    /* DOTALL */
    str = "始めまして。\nよろしくお願いします。";
    // ドット(.)は\nなどにはマッチしない DOTALLでマッチさせる
    ptn = Pattern.compile("^.+", Pattern.DOTALL);
    // ないとき : 始めまして。
    // あるとき : 始めまして。\nよろしくお願いします。
    mtr = ptn.matcher(str);
    while (mtr.find()) {
      out(mtr.group());
    }

    // 複数の指定
    // Pattern.MULTILINE | Pattern.CASE_INSENSITIVE
    // 埋め込みフラグ
    // 正規表現に埋め込む 記述した位置より後ろのみ反映される
    // (?文字)で埋め込み (?-)でリセット
    // 基本は先頭       "(?i)正規表現"
    // 意図があれば途中  "一部のみ(?i)区別しない(?-i)とか"
  }

  public static void サブマッチに名前をつける() {

    /* 名前付きキャプチャグループ */
    // (?<名前>) サブマッチに名前を付ける

    var str = "会社の電話は0123-99-0000です。自宅は000-123-4567だよ。";
    var ptn = Pattern.compile("(?<area>\\d[2,4])-(?<city>\\d{2,4})-(?<local>\\d{4})");
    var match = ptn.matcher(str);
    while (match.find()) { // fetch的なか
      out("開始位置："       + match.start());
      out("終了位置："       + match.end());
      out("マッチング文字列：" + match.group());
      out("市外局番："       + match.group("area")); // 名前で指定 0123
      out("市内局番："       + match.group("city"));
      out("加入者番号："      + match.group("local"));
      out("------");
    }
  }

  public static void 正規表現の機能() {
    /* 最短一致 */
    // + や {n,} などの文字数可変の指定後に ? で最短一致
    var str = "<a href=\"https://www.hp.com/\"><img src=\"logo.png\"></a>";
    var ptn = Pattern.compile("<.+?>");
    var match = ptn.matcher(str);
    if (match.find()) {
      out(match.group());
      // <a href="https://www.hp.com/>
      // <img src=\"logo.png\">
      // </a>
    }

    /* 後方参照 */
    // (1つめのグループ)と一致することを示す \1
    // グループが複数あるなら番号指定 \2 \3 \4...
    // strには\\1って書くことになるな
    str = "サポートサイト <a href=\"https://www.hp.com/\">https://www.hp.com</a>";
    // (\w) と \1,  (.+?) と \2 がそれぞれ一致しているパターンを検索
    ptn = Pattern.compile("<(\\w) href=\"(.+?)\">\\2</\\1>");
    match = ptn.matcher(str);
    if (match.find()) {
      out(match.group());
      // <a href="https://www.hp.com/">https://www.hp.com</a> 
    }

    // 名前付きキャプチャグループは、\\k<名前>で指定できる
    // "<(?<tag>\\w) href=\"(?<url>.+?)\">\\k<url></\\k<tag>>"
  }

  public static void サブマッチ目的でないグループを取得しない() {
    /* 参照されないグループ */
    // ()の先頭に ?: を追加で、グループ取得からはずせる
    // (表現のまとまり)* の繰り返し、のような括弧を別扱いに
    var str = "仕事用はmail@ex.comで、プライベート用はMAIL@priv.comです。";
    var ptn = Pattern.compile("(ほにゃほにゃ)@(むにゃにゃ+(?:\\.[a-z0-9]+)*)", Pattern.CASE_INSENSITIVE);
    // Matcherで[*+]の対象をグループ化
    var match = ptn.matcher(str);
    while (match.find()) { // fetch的なか
      out(match.group());
      out(match.group(1)); // 名前で指定 0123
      out(match.group(2));
      // out(match.group(3)); // IndexOutBoundsException
      out("------");
    }
  }

  public static void 正規表現による文字列の置換と特殊変数() {
    /* マッチしたグループを置換後の文字列に利用する */
    /* 番号はMatcherで取れるgroup()と同じ $0 $1 $2... 名前付きは ${名前} */

    /* str.replaceFirst(before, after) str.replaceAll(before, after) */
    var str = "URLをaタグに http://www.hp.com/ 変更";
    var bef = "url用の正規表現";
    var aft = "<a href=\"$0\">$0</a>"; // グループ0(マッチの全体だったね)を挿入
    out(str.replaceAll(bef, aft));
    // URLをaタグに <a href=\"http://www.hp.com/\">http://www.hp.com/</a> 変更
  }

  public static void 正規表現によるsplit() {
    /* 例のごとく、繰り返し処理になるのでPatternを使った方が処理がよい */

    var str = "にわに3わうらにわに51わにわとりがいる";
    var ptn = Pattern.compile("\\d{1,}わ"); // 一桁以上数値と「わ」
    var result = ptn.split(str); // strをsplit (3わ 51わ)
    out(String.join(" ", result));
    // にわに うらにわに にわとりがいる
  }
}