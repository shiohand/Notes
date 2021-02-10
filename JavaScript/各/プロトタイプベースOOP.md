# (旧来)プロトタイプベースのオブジェクト指向

- [コンストラクタ](#コンストラクタ)
- [静的メソッド・プロパティ](#静的メソッドプロパティ)
- [prototype](#prototype)
- [プロトタイプチェーン](#プロトタイプチェーン)
- [getter setter](#getter-setter)

## コンストラクタ
```js
var Cls = function(name, age) {
  this.name = name;
  this.age = age;
  this.func = function() { console.log('funk') };
};
var nc = new Cls('なまえ', 10);
```

new忘れによるグローバルスコープの汚染の注意(classでは不要)
→ if (!(this instanceof Obj)) { return new Obj(args) } で回避

## 静的メソッド・プロパティ
```js
// prototypeを介さない追加
Cls.prop = '1.0';
Cls.method = function() {};
```

## prototype
```js
' メソッドはprototypeで持ちましょう(メモリ節約できる) ';
Cls.prototype = {
  getName: function() {
    return this.name;
  },
  // ES6からオブジェクトのメソッド定義が簡潔になった
  setName(name) {
    this.name = name;
  }
}
Cls.prototype.getAge = function() {
  return this.age;
}
```

## プロトタイプチェーン

継承元 ベースオブジェクト --- 継承先 サブオブジェクト
プロトタイプでつなぐことで実現
継承ツリーの根源がObject型 ＝ Object.prototypeは全てのオブジェクトに継承される
```js
var SubCls = function(name, age) {
  this.name;
  this.age;
}
SubCls.prototype = new Cls(); // インスタンスを登録
var snc = new SubCls('なまえ', 30);
snc.getAge(); // 30
// スコープチェーン → snc SubCls.prototype(=さっきのインスタンス) Cls.prototype
```

## getter setter

```js
' get setキーワードによる追加 ';
let obj = {
  _name: '', // 忘れないように クラスだったらいらねんだけど → クラス
  get name() { // getキーワード
    return this._name;
  },
  set name(val) { // setキーワード
    this._name = val;
  }
  // obj.nameでget、obj.name = valでsetできるようになった
}
' ガチでカプセル化したいときはクロージャにしてしまう ';
let obj = (function() {
  let _name; // かくれプロパティ的な
  return { // くろーじゃしぐさ
    get name() {
      return this._name;
    },
    set name(val) {
      this._name = val;
    }
  }
})(); // クロージャ覚えてる？ →関数.html

' definePropertyでの追加 ';
let obj = function(){
  let _name;
  Object.defineProperty(this, 'name', {
    get: function() { // get()でもいいよ
      return this._name;
    },
    set: function(val) {
      this._name = val;
    },
    enumerable: true,
    confiburable: true
  });
};
```
