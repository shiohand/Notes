# Promiseというデザインパターン
非同期処理のコールバックを簡単に

* (Promise - JavaScript | MDN
  https://developer.mozilla.org/ja/docs/Web/JavaScript/Reference/Global_Objects/Promise)
* (JavaScript イベントループの仕組みをGIFアニメで分かりやすく解説 | コリス
  https://coliss.com/articles/build-websites/operation/javascript/javascript-visualized-event-loop.html)
* (JavaScriptの非同期処理Promise、AsyncとAwaitの仕組みをGIFアニメで解説 | コリス
  https://coliss.com/articles/build-websites/operation/javascript/javascript-visualized-promises-async-await.html)
* (とほほのPromise入門
  http://www.tohoho-web.com/ex/promise.html)

前工程「終了したら連絡する！」 生成
後工程「連絡きたら開始する！」 消費
後工程「俺も」「私も」「おいも」 消費者たち
Promiseは後工程たちを把握しておいて前工程が終わったのを伝えに行くオブジェクトのイメージ？

## コールバック地獄とは

* 同期処理とは
\- 上から順に実行していく
\- 上の処理が終わるまで次の処理に行かない
* 非同期処理とは
\- 上から順に実行していく
\- 上の処理が開始したら終了を待たずに次の処理に行く

例えばこの場合
```js
function first() { console.log('スレ立て'); }
function second() { console.log('軽やかに2get'); }
function third() { console.log('2getしてごめんなさい'); }
first();
setTimeout(second, 500);
third();
```
上の即時関数が動き出したら中の処理を待たずに次の行に進む
よって軽やかに2getできない

内部処理まで掘り下げればこうなる

```
CALL STACK
  in  first()
  out first()                 // スレ立て
  in  setTimeout(second, 500)
  out setTimeout(second, 500)
    (WEB API in  second())    // 中のコールバックがWEB APIに渡る
      (WEB API 500タイマー起動)
  in  third();
  out third();                // 2getしてごめんなさい
      (WEB API 500タイマー終了)
    (WEB API out second())
    (QUEUE in  second())
    (QUEUE out second())
    (EVENT LOOP in  second())
    (EVENT LOOP スタックが空であることを確認)
    (EVENT LOOP out second())
  in  second();
  out second();               // 軽やかに2get
```

(JavaScript イベントループの仕組みをGIFアニメで分かりやすく解説 | コリス - https://coliss.com/articles/build-websites/operation/javascript/javascript-visualized-event-loop.html)

仮にsetTimeoutのタイマーが0だったとしても、WEB API、QUEUEと経由している間にthird()は実行される
なるほど！
もしthird()がsecond()の中にあれば、スタックだがイベントループだかですれちがいする心配はない
→コールバックの中でコールバックすれば順番が作れる
なるほどなるほど！


### 地獄化

処理後にコールバックを呼ぶ関数
処理後に（処理後にコールバックを呼ぶ関数）を呼ぶ関数
処理後に（処理後に（処理後にコールバックを呼ぶ関数）を呼ぶ関数）を呼ぶ関数
...

sample_callback_hell()
(とほほのPromise入門 - http://www.tohoho-web.com/ex/promise.html)
```js
// 1秒未満ののちに data*2 で callback を呼ぶ
function aFunc1(data, callback) {
  setTimeout(
    () => {callback(data * 2);},
    Math.random() * 1000
  );
}
// 1秒未満ののちに 100*2 で ログ出力する関数 を呼ぶ
function sample_callback() {
  aFunc1(100, data => console.log(data));
}
// コールバックが続くほど階層が深まり複雑になる
function sample_callback_hell() {
  // aFunc1(100, 関数)
  aFunc1(100, data => {
    console.log(data + 'A');
    // aFunc1(aFunc1(100, 関数), 関数)
    aFunc1(data, data => {
      console.log(data + 'B');
      // aFunc1(aFunc1(aFunc1(100, 関数), 関数), 関数)
      aFunc1(data, data => {
        console.log(data + 'C');
        // aFunc1(aFunc1(aFunc1(aFunc1(100, 関数), 関数), 関数), 関数)
        aFunc1(data, data => console.log(data + 'D'));
      });
    });
  });
}
// 結果
sample_callback_hell(); // 200A 400B 800C 1600D
```

## Promiseによる解決
待機(pending), 成功(fulfilled), 失敗(rejected)の3値を持つ
コールバックを持つプロミスオブジェクトは、.then(コールバック)で実行される
```js
// 処理を行う関数(callback)=>{処理;}を引数としたPromiseオブジェクトを生成
// オブジェクト.then(callback)の形で実行できるようになる
let prms = new Promise(function(callback) {
  callback();
});
prms.then(function() {
  console.log('コールバックで呼ばれました');
});
// ただ呼ぶだけじゃないよというところを見せてあげる
// コールバック階層化やん！ってびびったけどただのsetTimeoutだよ怖くないよ
let prms2 = new Promise(function(callback) {
  setTimeout(function() {
    callback();
  }, 500);
});
prms2.then(function() {
  console.log('500ms待たせた');
})
// 引数も扱えるようにするならファクトリー的な関数を作ると楽
function prms(data) {
  return new Promise(function(callback) {
    setTimeout(function() {
      callback(data * 2);
    }, 500);
  });
}
prms(100).then(function(data) {
  console.log('callback(data * 2)で実行されるようです');
  console.log(data + 'です'); // 200です
});
prms(1000).then(function(data) {
  console.log('callback(data * 2)で実行されるようです');
  console.log(data + 'です'); // 2000です
});

prms(100).then(function(data) {
  console.log(data + 'です'); // 200です
  return prms(100); // 戻り値をPromiseオブジェクトにしたら、更に.then(callback)ができる
}).then(function(data) {
  console.log(data + 'です'); // 200です
  return prms(data); // 引数を引き継がせるとすごい
}).then(function(data) {
  console.log(data + 'です'); // 400です
  return prms(data); // 置きっぱなしでも何か実行されるわけじゃないから大丈夫
});

// 真ん中用関数つくったらどうだろう？
function prms2(data) {
  console.log(data + 'です');
  return prms(data);
}
// できた！ 200 400 800 1600
prms(100).then(prms2).then(prms2).then(prms2).then(prms2);


```