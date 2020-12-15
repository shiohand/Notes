# ユーティリティ、ユーティリティ関数

$.xxx のメソッド 個々のオブジェクトのそれとは違うので注意

## each(), map(), grep()

### each()

* each(array, function(idx, val))
* each(obj, function(key, val))
\- 第一引数に対してeach()

### map()

* map(array, function(val, idx))
* map(obj, function(val, key))
\- 第一引数に対してmap()
\- コールバックの引数に注意 thisが使えない(window)ので第一引数を使うことがある

### grep()

filter()的なこと
* grep(array, function(val, idx), invert)
\- コールバックがtrueを返した要素を取り出す
\- invert boolean trueで取り出す要素を反転(falseを取り出す)

## merge(), extend()

### merge()

* merge(arr1, arr2)
\- arr1にarr2を付け足す
\- 第一引数の配列が書き変わるので注意

### extend()

assign()的なこと
* extend([deep], target, obj1[, objN])
\- obj1にobjNを結合 同名プロパティは上書きされていく
\- targetが書き変わるので注意
\- \- ({}, obj)とすれば新しいオブジェクトを生成
  * deep
\- trueでディープコピー
  * target
\- デフォルトはjQueryなので注意。ユーティリティ関数の追加などに使える。しかしその場合も省略ではなく指定して行うべきだと思う私は

```js
function example(options) {
  let defaults = {
    color: 'white',
    animation: false,
    duration: 100
  };
  let settings = $.extend({}, defaults, options);
  // ......
}
```

```js
let chara1 = {
  attr: 'human',
  skill: {
    jump: 100
  }
};
let chara2 = {
  attr: 'wizard',
  skill: {
    magic: 200,
    fire: 300
  }
};
// 普通にコピーすると、多階層なskillの内容は無視され、chara1のskillのみ残る
// ディープコピーではskillの内側までmergeできる
let merged = $.extend(true, {}, chara1, chara2);
// マージ後
// {
//   attr: 'wizard',
//   skill: {
//     jump: 100,
//     magic: 200,
//     fire: 300
//   }
// }
```

## inArray(), makeArray(), parseJSON()

### inArray()

* inArray(val, array[, fromIndex])
\- valがあればその位置 なければ-1
\- 比較は===
* makeArray(obj)
\- array_likeを配列にする NodeListなども
* parseJSON()
\- 廃止予定
\- 素のJSON.parse()を使う