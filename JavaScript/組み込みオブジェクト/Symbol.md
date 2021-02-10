# Symbol
ただ単に名前を付ける。重複しない。
ご存じの通りユニーク
引数は説明文的な。参照する予定あるなら
オブジェクトプロパティのキーにできる
ただしfor...inは使えません

これまでは
```
const MONDAY = 0;
const TUESDAY = 1;
```
と無駄な値をおいたり
```
const JANNUARY = 0;
```
と値が被って比較演算子が機能しなくなったり。

```js
// Symbolを作成 let なまえ = Symbol(内容・説明)
// 同地判定のために違う値入れなきゃとか考えなくて良いわけ
let sym1 = Symbol('sym1');
let sym2 = Symbol('sym2');
let sym3 = Symbol('sym2');

console.log(typeof sym1);       // symbol
console.log(sym1.toString());   // Symbol(sym1)
console.log(sym1 === sym2);     // false
console.log(sym2 === sym3);     // false 

// 型変換はなし
console.log(sym1 + ''); // えらー
console.log(sym1 - 0);  // えらー
booleanにはなる
console.log(typeof !!sym1) // boolean

// キーに
let obj = {};
let s = Symbol();
obj[s] = 'hoge';
console.log(obj[s]); // hoge

// 引数を空で定数に入れて使う
const MONDAY = Symbol();
const TUESDAY = Symbol();
const JANNUARY = Symbol();
// かぶらないうれしい
let phone = {
  IPHONE: Symbol('iphone'),
  ANDROID: Symbol('android'),
  OTHER: Symbol('other')
};
// はいべんり。
// プライベートプロパティやイテレータの定義にも使えるけどそれはあとで

```