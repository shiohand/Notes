# Proxy

- [Proxy](#proxy)
- [ハンドラーメソッド(トラップ)](#ハンドラーメソッドトラップ)

## Proxy

魔改造君 串通す 大人になったら覚える
definePropertyみたいだねえ
https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Proxy


プロパティの設定、取得、forなんちゃら命令、delete演算子、他
これらオブジェクトの基本の動作を差し替える(ログ出力を挟んだり加工したり)

* Proxy(対象オブジェクト, ハンドラ)
\- 対象オブジェクトのハンドラ(動作)を変更

```js
let data = { red: '赤', yellow: '黄'}
let proxy = new Proxy(data, {
  get(target, prop) { // get プロパティの取得
    // プロパティがundefinedのときundefinedではなく'?'が返る
    return prop in target ? target[prop] : '?';
  }
});
console.log(data.red); // 赤
console.log(proxy.red);  // 赤
console.log(data.blue); // undefined
console.log(proxy.blue); // ?
// 設定した動作以外でproxyを通しても普通に使える
proxy.red = 'あか';
console.log(data.red);  // あか
```

既存のオブジェクトに限らない
```js
let data = new Proxy({
  red: '赤',
  yellow: '黄'
},
{
  get(target, prop) { // get プロパティの取得
    // プロパティがundefinedのときundefinedではなく'?'が返る
    return prop in target ? target[prop] : '?';
  }
});
```

## ハンドラーメソッド(トラップ)
https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Proxy/handler

```
isExtensible            (target)
preventExtensions       (target)
getOwnPropertyDescriptor(target, prop)
defineProperty          (target, prop, descriptor)
getPrototypeOf          (target)
setPrototypeOf          (target, prototype)
get                     (target, prop, receiver)
set                     (target, prop, value, receiver)
has                     (target, prop)            // in
deleteProperty          (target, prop)            // delete
ownKeys                 (target)                  // Object.getOwnPropertyNames Object.getOwnPropertySymbols
apply                   (target, thisArg, argumentsList) // 関数呼び出し
construct               (target, argumentsList)   // new
```