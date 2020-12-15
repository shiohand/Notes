# エフェクト・アニメーション

## エフェクト

### show(), hide(), toggle()

* hide([duration][, easing][, callback])
\- display: none
* show([duration][, easing][, callback])
\- display: noneを解除
* toggle([duration][, easing][, callback])
toggle(showOrHide)
\- 非表示ならshow()、表示ならhide()
\- showOrHideは trueならshow()、falseならhide()にできる

コールバックはアニメーション完了後
easingは liner か swing(デフォルト)

### fadeIn(), fadeOut(), fadeToggle(), fadeTo()

show()とかの透明度バージョン

* fadeIn([duration][, easing][, callback])
* fadeOut([duration][, easing][, callback])
* fadeToggle([duration][, easing][, callback])
* fadeTo(duration, opacity[, easing][, callback])
\- opacityで設定可能 display: noneにはならない

#### 要素を追加してフェードインで表示

hide()で非表示にして、追加後、表示する

```js
$('<div>ブロック</div>').hide().addClass('float-block').appendTo("body").fadeIn(1000);
```

## アニメーション

### animate()

* animate(properties[, duration][, easing][, complete])
animate(properties, options)

  * properties
\- 変化後のCSSをキーバリューのオブジェクトで // {width: '100px', opacity: '0.5'}
\- 長さの単位を省略するとpx
\- 数値は相対値が可能 // '+=15'
\- 値に 'hide', 'show', 'toggle' を利用可
\- colorなどの数値で設定しないプロパティは指定不可

  * duration
\- 数値(ms) または 'slow'(600ms), 'fast'(200ms)
\- デフォルトは400ms

  * complete
\- アニメーション完了後のコールバック

  * options
\- duration, easing, complete, step, queueをキーとして設定したオブジェクトを渡せる
\- \- step -- アニメーションの各ステップで呼ばれるコールバック
\- \- queue - boolean falseを渡すとキューを直ちに実行

### キュー

animation()とcss()は非同期なので、animation()が終わる前に動いてしまう
キューで処理の順番を管理 アニメーションに限ったことじゃないけど

```js
$target.queue(function() { $(this).メソッド().dequeue() }) // でワンセットと捉えてよいみたい
.queue(function() { $(this).メソッド().dequeue() })
.delay(300)
.queue(function() { $(this).メソッド().dequeue() }); // 連結で順番に
```

#### queue()

* queue([queueName])
\- 現在のキューの配列を返す
* queue([queueName, ]callback(next))
\- 関数を一つ渡してキューに追加する
\- callbackの引数(慣例でnext)は $(this).dequeue() と同等のようだ
\- $(elm).queue(略.dequeue())で良い気がする
* queue([queueName, ]newQueue)
\- キューの配列を渡して上書きする

queueNameは複数のキューを区別したいとき指定 デフォルトは"fx"

#### dequeue()

* dequeue([queueName])
\- キューを取り出して実行

#### clearQueue()

* clearQueue([queueName])
\- 残っているキューを全て削除

#### delay()

* delay(duration)
\- 次のキューの実行を遅らせる

```js
function animation1() { // 互いの処理を待たず動いてしまう
  $("#changed").css("color", "red")
  .animate({"opacity": "0.5"}, 500) // animateしてる要素に
  .css("background-color", "ashgray")
  .animate({padding: '+=15'})
}

function animation2() {
  $("#changed").css("color", "red");
  $("#changed").animate({"opacity": "0.5"}, 500); // animateしてる要素に
  $("#changed").queue(function () { // queue&dequeue
    $(this).css("background-color", "ashgray");
    $(this).dequeue(); // 次の人どうぞということ
    // または $(this).dequeue();
    // または 引数をnextで取って next();
  });
  $("#changed").animate({padding: '+=15'});
}

function animation3() {
  $("#changed").css("color", "red")
  .animate({"opacity": "0.5"}, 500)
  .queue(function () {
    $(this).css("background-color", "ashgray").dequeue();
  })
  .animate({padding: '+=15'});
}
```

### アニメーションの停止

#### stop()

* stop([queueName][, clearQueue[, jumpToEnd]])
  * queueName
\- 停止対象 指定しない場合はデフォルトの'fx'
  * clearQueue
\- boolean 残りのキューを削除するか
  * jumpToEnd
\- boolean 現在実行中のアニメーションを、そのまま停止するか、終了後の状態にするか

| clear | jump  |-
|-      |-      |-
| false | false | 次のキューへ、アニメは途中停止 デフォルト
| false | true  | 次のキューへ、アニメは最終形に変化
| true  | false | 以降のキューを削除、アニメは途中停止
| true  | true  | 以降のキューを削除、アニメは最終形に変化

animation()は実行される度キューに入っていくから順番に実行される
アニメーション中の要素に他のanimation()が動いた場合も中断されない
中断して新しいanimation()を開始するには、要素.stop()でアニメーションを終了させる

#### finish()

* finish([queueName])
実行中のanimationと以降の全てのanimationが完了した状態に飛ぶ
queue()で追加したコールバックは無視される

#### $.fx.off

boolean trueにするとアニメーションを無効(即finish()的な)にする
低スペック向け

#### 実行回数

アニメーションの発火イベントが連続で起きた場合、回数分繰り返しになってしまう

```js
$('.btn').on('click', function() {
  $('#changed').toggle(1000);
}); // 3連続でボタンを押すと、アニメーションが3回繰り返される
```

:animatedで制御

```js
$('.btn').on('click', function() {
  $('#changed:not(:animated)').toggle(1000); // :not(:animated)のときだけ
});
```

