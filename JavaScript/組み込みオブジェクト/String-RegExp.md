# String-RegExp

- [String](#string)
- [RegExp](#regexp)

## String

|検索|-
|-|-
|indexOf(substr[, start])    |  位置
|lastIndexOf(substr[, start])|  位置
|startsWith(search[, pos])   |  boolean
|endsWith(search[, pos])     |  boolean
|includes(search[, pos])     |  boolean

|部分文字列|-
|-|-
|charAt(n)|-
|slice(start[, end])     |  切り出し[位置指定] 
|substring(start[, end]) |  切り出し[位置指定] (start>end 入れ替える)(endが負数 0として扱う)
|substr(start[, cnt])    |  切り出し[文字数指定]
|split(区切り文字[, limit]) | 区切り文字で分割[最大分割数] return 配列

|正規表現|-
|-|-
|match(reg)        |  一致文字列とサブマッチ文字列()の配列
|replace(reg, rep) |  repにはサブマッチ文字列を$1,$2,$3...って埋め込めるよ
|search(reg)       |  位置を取得 なかったら-1

|大文字小文字
|-
|toLowerCase()
|toUpperCase()

|UTF-16 コード
|-
|charCodeAt(n)
|*fromCharCode(c1, c2...)
|codePointAt(n)
|*fromCodePoint(num...)
 

|その他|-
|-|-
|concat(str) |  連結
|repeat(num) |  num回繰り返し
|trim()
|length      |  2バイト文字までなので4バイト文字があると不正確

## RegExp

* コンストラクタ
\- new RegExp(パターン, フラグ)
\- ここでもサロゲートペア(4byte文字)を使うならuフラグがいるよ

|メソッド|-
|-|-
|パターン.exec(str) | データベースのfetchみたいに、実行するたび次の次のと返してくれる
|パターン.test(str) | boolean