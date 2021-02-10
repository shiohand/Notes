# Promise

* (Promise - JavaScript | MDN
\- https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Promise)
* (JavaScript イベントループの仕組みをGIFアニメで分かりやすく解説 | コリス
\- https://coliss.com/articles/build-websites/operation/javascript/javascript-visualized-event-loop.html)
* (JavaScriptの非同期処理Promise、AsyncとAwaitの仕組みをGIFアニメで解説 | コリス
\- https://coliss.com/articles/build-websites/operation/javascript/javascript-visualized-promises-async-await.html)
* (とほほのPromise入門
\- http://www.tohoho-web.com/ex/promise.html)

## 内部プロパティ(内部処理用なので呼び出す機会はまあ無い)

* state
\- 待機:pending
\- 成功:fulfilled
\- 失敗:rejected
* value
\- undefined

## コンストラクタ

* Promise((resolve, reject) => {}) // この関数をexecutorとか言うらしい

| -                                  | -               |-
| ---------------------------------- | --------------- |-
| 関数実行前のプロパティ             | state:pending   | value:undefined |
| resolve(result) 呼び出すと成功判定 | state:fulfilled | value:result    |
| reject(result)  呼び出すと失敗判定 | state:rejected  | value:result    |

※引数のresultはPromiseオブジェクトのvalueに入る

  newする → 関数実行 → stateに結果、valueにデータが入ったPromiseができる

## メソッド
* then((value) => {})
\- fulfilledのとき、実行される。valueを利用できる
* catch((error) => {})
\- rejectedのとき、実行される。valueを利用できる
* finally(() => {})
\- 成功失敗に関わらず必ず呼び出される

```js
'しんぷるさんぷる';
new Promise((resolve, reject) => {
  try {
    const data = '材料その１';
    // resolve()実行 成功判定
    resolve(data);
  } catch(e) {
    // 例外が出たらここに来てreject()実行 失敗判定
    reject(new Error(e));
  }
});
// 今回の結果
// Promise { "fulfilled" }
// <state>: "fulfilled"
// <value>: "材料その１"
```

```js
' Promiseを返す関数にしてみる ';
function prms(data) {
  return new Promise((res, rej) => {
    try {
      setTimeout(() => {
        res(data * 2);
      }, 500);
    } catch(e) {
      rej(new Error(e));
    }
  });
}
prms(100).then((data) => { console.log(data)}); // 200
// 今回の結果
// Promise { "fulfilled" }
// <state>: "fulfilled"
// <value>: "200"
```

```js
' さんぷる２ ';
function getImage(file) {
  return new Promise((res, rej) => {
    try {
      const data = readFile(file);
      res(data);
    } catch(e) {
      rej(new Error(e));
    }
  });
}
' then catch finally ';
getImage(file)
  .then(image => console.log(image))    // resolveだった
  .catch(error => console.log(error))   // rejectだった
  .finally(() => console.log('done!')); // どちらにしろ実行
```

※コンストラクタの引数は (res)=>{res()} や (res, rej)=>{rej()} でもよい
※常にresolveまたは常にrejectの場合、.then()ではなく .resolve() や .reject() でもよい ?

```js
// 必要な関数を作って
function compressImage(image) {
  return new Promise(res => {
    console.log('compressImage');
    res(image);
  })
}
function applyFilter(compressedImage) {
  return new Promise(res => {
    console.log('applyFilter');
    res(complessedImage);
  })
}
// 連結
getImage('file')
  .then(image => compressImage(image))
  .then(compressedImage => applyFilter(compressedImage))
  .catch(error => console.log(error))
  .finally(() => console.log('done!'));
```

DEKITA-!!

* Promise.all(promises)
\- 複数のプロミスを判定 すべてがresolveで成功 すべてのvalueが配列で返る
* Promise.race(promises)
\- 複数のプロミスを判定 いずれかがresolveで成功 最も早く成功したプロミスのvalueが返る

```js
Promise.all([
  getImage('1'),
  getImage('2'),
  getImage('3')
]).then(
  res => console.log(res), // 配列にそれぞれのvalueが入っている
  rej => console.log(rej)
);
Promise.race([
  getImage('1'),
  getImage('2'),
  getImage('3')
]).then(
  res => console.log(res), // 1,2,3のどれか
  rej => console.log(rej)
);
```
