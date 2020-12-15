普通の関数 のthis
アロー関数 のthis
アロー関数を使わずthis引き継ぎ
コンストラクタ のthis
イベントリスナー のthis
call() apply() bind() のthis

-----

# this

## 普通の関数 のthis

* this === レシーバオブジェクト
\- object.method(this) なら this === object
* グローバル関数ならundefined
\- 更にthis.propとかしたらエラー(undefined.propはできないよね)
* 非strictならグローバルオブジェクトのwindow

function内で新たに定義したfunctionや無名関数に注意

```js
let greet = function() {
  console.log(this.hello); // strictならエラー
}
let obj = {
  hello: 'こんにちは',
  'まちがい': function() { // obj['まちがい'], this === obj
    setTimeout(function() { // window['setTimeout'], this === window
      console.log(this.hello); // undefined
    }, 1000);
  },
  '従来': function() {
    setTimeout(function() {
      console.log(this.hello); // こんにちは
    }.bind(this), 1000); // function() {}.bind(関数内でthisにしたいもの)
  },
  'アロー': function() {
    setTimeout(() => {
      console.log(this.hello); // こんにちは
    }, 1000);
  }
}
```

## アロー関数 のthis

* 関数定義時のコンテキスト(スコープ)のthisを引き継ぐ
* メソッドにアロー関数使ってもundefinedになるだけ
* できないこと：　call(), apply(), yield
this使わないなら楽してアローでいいんだ

```js
const groval_show = () => console.log(this); // strictならundefined
let obj = {
  val: 'hoge',
  show: function() {
    console.log(this); // Object {val: 'hoge'}
    let funcB = () => {
      console.log(this); // Object {val: 'hoge'}
    }
    funcB();
  },
  g_show: groval_show // 追記:なにこれ？なんか書こうとして忘れたのかも
}
obj.show();
obj.g_show();
```

## アロー関数を使わずthis引き継ぎ

適当な変数にthisを退避させる

```js
let obj = {
  val: 'hoge',
  checkThis: function() {
    let self = this; // thisを退避
    console.log(self.val); // hoge
    function innerCheckThis() {
      console.log(self.val); // hoge
    }
  }
}
```

## コンストラクタ のthis
生成されたインスタンスのthis

## イベントリスナー のthis
イベントをつけた要素

## call() apply() bind() のthis
第一引数がthis

```js
function sum(val1, val2) {
  console.log(this.val + val1 + val2);
}
let obj1 = {val: 1};
let obj2 = {val: 2};

' call(that, ...args) ';
sum.call(obj1, 1, 1); // thisはobj1
sum.call(obj2, 1, 1); // thisはobj2

' apply(that, args) ';
sum.apply(obj1, [1, 1]); // thisはobj1
sum.apply(obj2, [1, 1]); // thisはobj2

' bind(that, ...args) ';
// 一回作ればそれきり 複数作って使い分け可能
// setTimeout や addEventListener などのコールバックで便利に使う
let obj1Sum = sum.bind(obj1);
let obj2Sum = sum.bind(obj2, 2, 2); // 引数の束縛

obj1Sum(1, 1); // thisはobj1
obj2Sum();     // thisはobj2
```