# Object

| 基本                     | -                                                                |
| ------------------------ | ---------------------------------------------------------------- |
| constructor              | 自分がインスタンス化されたときに使用されたコンストラクターを取得 |
| toString()               |
| toLocaleString()         |
| valueOf()                |
| *assign(target, src,...) | オブジェクトをマージ 同名プロパティは上書き                      |
| *create(proto[, props])  | newでもオブジェクトリテラルでもない作成法。必要なら学べ。        |
| is(val1, val2)           | ふたつが等しいか判定                                             |

| プロパティ                           | -                                    |
| ------------------------------------ | ------------------------------------ |
| hasOwnProperty(prop)                 | 引数で渡したプロパティがあるか       |
| propertyIsEnumerable(prop)           | 引数で渡したプロパティはenumerableか |
| *defineProperties(obj, props)        |
| *defineProperty(obj, prop, desc)     |
| *getOwnPropertyDescriptor(obj, prop) |
| *getOwnPropertyNames(obj)            |
| *getOwnPropertySymbols(obj)          |

| イテラブル             | -                                              |
| ---------------------- | ---------------------------------------------- |
| *values(obj)           | valueのiterableを返す                          |
| *keys(obj)             | keyのiterableを返す                            |
| *entries(obj)          | [key, value]のiterableを返す                   |
| *fromEntries(iterable) | [key, value]のiterableをオブジェクトにして返す |

| プロトタイプ                | -                                 |
| --------------------------- | --------------------------------- |
| *getPrototypeOf(obj)        | プロトタイプ取得                  |
| *setPrototypeOf(obj, proto) | プロトタイプ追加                  |
| isPrototypeOf(obj)          | 自分はobjのプロトタイプであるか？ |

| 変更可否                | -                         |
| ----------------------- | ------------------------- |
| *preventExtensions(obj) | プロパティ追加だけ禁止    |
| *freeze(obj)            | 追加削除書き換え禁止      |
| *seal(obj)              | 追加削除禁止 書き換えおｋ |
| *isExtensible(obj)      |
| *isFrozen(obj)          |
| *isSealed(obj)          |

不変にしたあと何か代入すると無視される, 'use strict'している場合はエラーも出る

* constructorプロパティ
var obj = {};
var func = function() {};
var date = new Date();
obj.constructor;  // function Object() {}
func.constructor; // function Function() {}
date.constructor; // function Date() {}

* Object
is(vq, v2)
  同値比較との違い
  → NaN, Nan が true
    +0, -0   が false

* assign(target, ...src)
\- 第一引数にマージ かつ戻り値はマージ後のtarget
\- コピーされるもの
\- → 列挙可能(enumerable)且つ直接所有(prototypeからの継承でない)
```js
// マージ
let objA = {a: 'a'};
let objB = {b: 'b'};
let objC = {c: 'c'};
let margeObj = Object.assign(objA, objB, objC);
objA; // Object {a: 'a', b: 'b', c: 'c'}
objA === margeObj; // true

// シンボル型プロパティのコピー(どうなるの？)
let objD = {d: 'd'};
let objSym = { [Symbol('sym')]: 2};
let copyObj = Object.assign(objD, objSym);
objD; // Object {d: 'd', Symbol(sym): 2}

// 参照はありませんっていう
let human = {name: 'なまえ'};
let person = Object.assign({}, human);
human.name = '名前';
person; // Object {name: 'なまえ'}
```

* オブジェクトを複製

```js
let obj = {val: 'hoge'};

// assign()
let copyObj = Object.assign({}, obj);
// スプレッド演算子
let copyObj2 = [...obj];
```