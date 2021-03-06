# CharSequence

- [CharSequence interface (※以下CharS)](#charsequence-interface-以下chars)
- [String](#string)
- [StringBuilder](#stringbuilder)
- [StringBuffer  (同期処理対応)](#stringbuffer--同期処理対応)
- [java.util.regex](#javautilregex)
  - [Pattern](#pattern)
  - [Matcher](#matcher)

## CharSequence interface (※以下CharS)

String,StringBuilder,StringBufferなどのインターフェース

| メソッド                        | -                                |
| ------------------------------- | -------------------------------- |
| length()                        | 2バイト対応 サロゲートペア非対応 |
| charAt(int index)               | サロゲートペア非対応             |
| compare(CharS cs1, CharS cs2)   |
| subSequence(int start, int end) | substring的な                    |


## String

| メソッド                             | -                                       |
| ------------------------------------ | --------------------------------------- |
| *valueOf(だいたい)                   |
| substring(int begin[, int end])      | 負数やbegin>end、endの文字数超過はerror |
| concat(String str)                   | 連結                                    |
| repeat(int count)                    | count文繰り返した文字列                 |
| replace(char old, char new)          | 全て                                    |
| replace(CharS old, CharS new)        | 全て                                    |
| replaceAll(String old, String new)   | 全て 正規表現                           |
| replaceFirst(String old, String new) | 最初 正規表現                           |
| toLowerCase(Locale locale)           |
| toUpperCase(Locale locale)           |

* スペース除去
Java10以前は trim / trimLeft / trimRight 全角を含まない

| メソッド        | -                |
| --------------- | ---------------- |
| strip()         | 前後スペース削除 |
| stripLeading()  | 前方のみ         |
| stripTrailing() | 後方のみ         |

* 比較

| メソッド                        |
| ------------------------------- |
| compareTo(String str)           |
| compareToIgnoreCase(String str) |

* 検索 みつからなければ -1

| メソッド                                                                     |
| ---------------------------------------------------------------------------- |
| indexOf(String str[, int index])                                             |
| lastIndexOf(String str[, int index])  第二引数、戻り値ともに先頭からの文字数 |

* 判定

| メソッド |
| -------- |
isEmpty() 空文字
isBlank() 空文字とスペース(全角やタブ含む)
equals(String str)
equalsIgnoreCase(String str)
contentEquals(CharS　cs)
contentEquals(StringBuffer sb)
matches(String regex)
contains(CharS s)
startWith(String pre[, int offset])
endWith(String suf)

* codePoint(サロゲートペア対応)

| メソッド                                  | -                              |
| ----------------------------------------- | ------------------------------ |
| codePointAt(int index)                    |
| codePointBefore(int index)                | 一つ前                         |
| codePointCount(int begin, int end)        | 文字数 (0, str.length())など   |
| offsetByCodePoints(int index, int offset) | indexからcodePoint文字目の位置 |

* 整形

*format([Locale loc, ]String format, Object... args)
  // 書式指定子->書式指定子.txt
  // ロケールはLocale.GERMANなど 日付表現などが変わることがある

* 配列

| メソッド                               | -                                           |
| -------------------------------------- | ------------------------------------------- |
| sprit(String 区切り[, int 最大分割数]) | 区切り文字は正規表現 空文字はだと一文字ずつ |
| *join(CharS 区切り, Iterable elems)    |
| *join(CharS 区切り, CharS... elems)    | 可変長もあるよ                              |

* 変換
  * lines()
  \- 戻り値 `Stream<String> lines.forEach(System.out::println);`など
  * toCharArray()

## StringBuilder
## StringBuffer  (同期処理対応)
equals()が無い 比較はtoString経由かな(※以下SB)

| コンストラクタ              | -                        |
| --------------------------- | ------------------------ |
| StringBuilder()             | 16bit                    |
| StringBuilder(String str)   | strで初期化 容量はstr+16 |
| StringBuilder(int capacity) | 容量指定                 |
| StringBuilder(CharS seq)    | seqをコピー 容量はseq+16 |
| StringBufferも同じく        |

| メソッド                                        | -                                       |
| ----------------------------------------------- | --------------------------------------- |
| substring(int begin[, int end])                 | 負数やbegin>end、endの文字数超過はerror |
| append(だいたい)                                |
| append(CharS s, int start, int end)             |
| delete(int start, int end)                      |
| deleteCharAt(int index)                         |
| insert(int offset, だいたい)                    |
| insert(int offset, CharS s, int start, int end) | サブシーケンスを                        |
| replace(int start, int end, String str)         | 指定範囲を置換                          |
| setCharAt(int index, char ch)                   |
| setLength(int newLength)                        | 長さを設定                              |
| ensureCapacity(int min)                         | 容量をmin以上に                         |
| reverse()                                       | 逆順に                                  |

* 比較

| メソッド          |
| ----------------- |
| compareTo(SB str) |

* 検索 みつからなければ -1

| メソッド                             | -                                      |
| ------------------------------------ | -------------------------------------- |
| indexOf(String str[, int index])     |
| lastIndexOf(String str[, int index]) | 第二引数、戻り値ともに先頭からの文字数 |

* codePoint(サロゲートペア対応)

| メソッド                                  | -                              |
| ----------------------------------------- | ------------------------------ |
| codePointAt(int index)                    |
| codePointBefore(int index)                | 一つ前                         |
| codePointCount(int begin, int end)        | 文字数 (0, str.length())など   |
| offsetByCodePoints(int index, int offset) | indexからcodePoint文字目の位置 |


## java.util.regex


| 集合演算が可能  | -                                      |
| --------------- | -------------------------------------- |
| `[a-z&&[def]]`  | d、e、またはf (交差)                   |
| `[a-z&&[^bc]]`  | a - z (bとcを除く): `[ad-z]` (減算)    |
| `[a-z&&[^m-p]]` | a - z (m - pを除く): `[a-lq-z]` (減算) |
| (?<名前>)       | サブマッチに名前を付ける               |
| (?:)            | サブマッチに含めない                   |

```
+ や {n,} などの文字数可変の指定後に ?
  最短一致 "<.+?>" など
\数値, \\k<名前>
  後方参照 サブマッチを利用
  "<(\\w) href=\"(.+?)\">\\2</\\1>"
  "<(?<tag>\\w) href=\"(?<url>.+?)\">\\k<url></\\k<tag>>" など
$数値
  マッチしたグループを置換後の文字列に利用する
  "<a href=\"$0\">$0</a>" など
```

### Pattern

* 基本
```java
Pattern p = Pattern.conpile("pat");
Matcher m = p.matcher("target");
boolean b = m.matches();
または
boolean b = Pattern.matches("pat", "target"); // 効率低下
```

| メソッド                         | -                                           |
| -------------------------------- | ------------------------------------------- |
| compile(String reg[, int flags]) | Patternにコンパイル                         |
| matcher(CharS input)             | Matcherを作成                               |
| matches(String reg, CharS input) | boolean コンパイルとマッチ                  |
| pattern()                        | 元の正規表現を取得                          |
| split(CharS input[, int limit])  | Stringのsplitの、文字列の方を渡すバージョン |
| splitAsStream(CharS input)       | `Stream<String>`                            |

flagsの例
```
CASE_INSENSITIVE : i 大文字小文字を区別しない
MULTILINE        : m 複数行モード 行ごとに^(先頭)$(末尾)を扱える
DOTALL           : s ドット(.)が行末記号を含む任意の文字にマッチ
UNICODE_CASE     : u 大文字と小文字を区別しない(Unicodeに準拠)
UNIX_LINES       : d 行末記号は\\nだけ
LITERAL          :   パターンをリテラル文字として解析(\\dとか無効化)
COMMENTS         : x 空白とコメントの有効化
  // 複数の指定
  Pattern.MULTILINE | Pattern.CASE_INSENSITIVE
  // 埋め込みフラグ
  (?文字)で埋め込み (?-)でリセット
  記述した位置から反映される
  基本は先頭　     "(?i)正規表現"
  意図があれば途中  "一部のみ(?i)区別しない(?-i)とか"
```

### Matcher

* matches
\- 入力シーケンス全体とパターンをマッチ
* lookingAt
\- 入力シーケンスの先頭から始めてパターンをマッチ
* find
\- 入力シーケンスを走査して、パターンとマッチする次の部分のシーケンスを検索

| メソッド           | -                                                   |
| ------------------ | --------------------------------------------------- |
| matches()          | 領域全体をパターンとマッチ                          |
| lookingAt()        | マッチを先頭から始める                              |
| find()             | bool 次の部分シーケンスを検索                       |
| find(int start)    | bool 指定されたインデックス以降の次の部分シーケンス |
| pattern()          | Pattern この正規表現によって解釈されるパターン      |
| reset(CharS input) | Matcherをリセット、引数があれば再設定               |

| メソッド                                             | -                                |
| ---------------------------------------------------- | -------------------------------- |
| replaceAll(String str)                               | 部分シーケンスを置換文字列に置換 |
| replaceAll(Function<MatchResult, String> replacer)   | サブシーケンスを置換関数で       |
| replaceFirst(String str)                             |
| replaceFirst(Function<MatchResult, String> replacer) |