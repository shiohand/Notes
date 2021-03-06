# Array Map Set
*実行時にオブジェクトを書き換えるもの

## Array
| -                        | -                        |
| ------------------------ | ------------------------ |
| length                   |
| indexOf(値[, index])     | なければ-1               |
| lastIndexOf(値[, index]) | なければ-1               |
| includes(値[, index])    | boolean (ES2016らしいよ) |

イテラブル
| -         | -                  |
| --------- | ------------------ |
| entries() | 全てのキーと値取得 |
| keys()    | 全てのキー取得     |
| values()  | 全ての値取得       |

静的メソッド
| -                                | -                                                                                                                         |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------------------- |
| Array.isArray(obj)               |
| Array.from(alike[, map[, this]]) | iterable、array-likeを配列にできる<br>第二引数に関数を渡すとmapしてくれる<br>第三引数には第二引数の関数のthisを指定できる |
| Array.of(...elm)                 | 可変長引数で配列に変換                                                                                                    |

結合・置換
| -                                         | -                                           |
| ----------------------------------------- | ------------------------------------------- |
| concat(ary)                               | 配列の連結                                  |
| join(区切り文字)                          | 区切り文字で文字列に                        |
| slice(start[, end])                       | 切り出し[位置指定]                          |
| *splice(start, 要素数[, ...置き換える値]) | 置き換え、除去、挿入                        |
| *copyWithin(位置, start[, end])           | 要素数を維持してstart~endを指定位置にコピー |
| *fill(値[, start[, end]])                 | 固定値で置き換え                            |


|追加・削除
|-
| *pop()
| *push(...値)
| *shift()
| *unshift(...値)

|並べ替え
|-
| *reverse()
| *sort([fnc])

  (a, b) => a - b;                値で昇順
  (a, b) => a.length - b.length;  lengthで昇順
  arr = ['金', '銀', '銅'];
  (a, b) => arr.indexOf(a) - arr.indexOf(b);  配列の要素順で昇順

| コールバック             | -                                          |
| ------------------------ | ------------------------------------------ |
| forEach(fnc[, that])     | 順に処理                                   |
| map(fnc[, that])         | 順に加工 できた配列を返す                  |
| every(fnc[, that])       | fncが全てtrueか false見つけた時点で終了    |
| some(fnc[, that])        | fncが一つ以上trueか true見つけた時点で終了 |
| filter(fnc[, that])      | trueのみ抽出した配列返す                   |
| find(fnc[, that])        | 一つ目のtrueの値                           |
| findIndex(fnc[, that])   | 一つ目のtrueのインデックス                 |
| reduce(fnc[, init])      | init(初期値)を引き継いでいって処理         |
| reduceRight(fnc[, init]) | reduce逆                                   |

  fnc 中の関数, that thisを変更する
  中の関数の……第一引数 値, 第二引数 添字, 第三引数 元の配列
  ['elm1', 'elm2'].forEach((value, index, array) => { 処理; });

## Map

* コンストラクタ
`new Map([...['key', 'val']])`
* オブジェクトをキーに設定できる(キーは===判定)
  * for...ofの例
    `for(let [key, val] of map) {}`
    `for(let key of map.keys()) {}`
  * NaNの判定
    通常は NaN !== NaN だが、Mapでは===となる

size
set(key, val)
get(key)
has(key)
delete(key)
clear()

keys()
values()
entries()
forEach(fnc[, that])

## Set
* コンストラクタ
  `new Set([...val])`
* NaNの判定
  通常は NaN !== NaN だが、Setでは===となる

size
add(val)
has(val)
delete(val)
clear()

entries()
values()      keys()でも同じ
forEach(fnc[, that])

## ほかよ
new Array(5); // 要素数5のundefinedの配列 空の配列を作るときに使う
new Array(2); // 空の配列ではなく[2]ほしいときは使えない
Array.of(2);  // Array.ofを利用

* arr.fill(value[, start[, end]])
\- 指定した値を配列の各要素に設定 埋め尽くしてやる

```js
let arr = new Array(5);
arr.fill('X');      // ['X', 'X', 'X', 'X', 'X'] 'X' で 全部
arr.fill('A', 2, 3) // ['X', 'X', 'A', 'X', 'X'] 'A' で 2-3
arr.fill('B', 3)    // ['X', 'X', 'A', 'B', 'B'] 'B' で 3-
arr.fill('C', -2)   // ['X', 'X', 'A', 'C', 'C'] 'C' で -2-
```

* arr.copyWithin(target, start[, end])
\- 指定した範囲の要素を、指定した位置から貼れるだけ貼る

```js
let arr = [0, 1, 2, 3, 4, 5];
arr.copyWithin(2, 4);    // [0, 1, 4, 5, 4, 5] 4-  で 2-
arr.copyWithin(3, 1, 2); // [0, 1, 4, 1, 4, 5] 1-2 で 3-
arr.copyWithin(0, 1);    // [1, 4, 1, 4, 5, 5] 1-  で 0-
```