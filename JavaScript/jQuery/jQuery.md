# jQuery基礎

## ready

### 1. jQuery関数を利用。万一にも衝突無し
```js
jQuery(function($) {});
```

### 2. documentのreadyメソッドを利用
```js
$(document).ready(function($) {});
```

### 3. 1の省略形 最もメジャーな気がする
```js
$(function($) {});
```


## jQueryオブジェクトの取得

* $('selector')

```js
let $変数 = $('.btn .primary');
```

* $(element)
* $('HTML文字列')

```js
// this
let $ths = $(this);
// windowとdocumentも可能
let $win = $(window);
let $doc = $(document);
// 要素を生成(後述)
let $li = $('<li>あいてむ</li>');
```

## DOM要素の生成

* $('HTML文字列')

```js
$('<a></a>'); // $('<a>')のみでも動くが非推奨
$('<img>');
$('<li class="item">アイテム</li>');
```

* $("HTMLタグのみ", { attribute })
\- オブジェクトとしてattributesを追加

```js
$('<a></a>', {        // ここで属性(href=""など)を含めてはいけない
  href: 'abc.html',
  target: '_blank',
  'class': 'myClass'  // 予約語のためStringで
});
```

\- jQueryメソッドも指定可能(Ver.1.8から)
\- キーにメソッド名、バリューに関数
\- ただし読みにくいのでやらない

```js
$('<div></div>', {
  css: {
    border: '5px solid gray',
    backGroundColor: 'ashgray'
  },
  addClass: 'my-div',
  on: {
    click: function(event) {
      // 処理;
    }
  }
});
```

## jQueryオブジェクトの利用

基本的に戻り値はjQueryオブジェクトなので、メソッドチェーン可能
(取得系メソッドやその他の戻り値が必要なメソッド以外)

```js
// 要素の取得とメソッド実行
let $color_div = $('#color_div');
$color_div.css('border', '1px solid red');
$color_div.css('display', 'block');
// メソッドチェーン
$('#color_div').css('border', '1px solid red').css('display', 'block');
```

複数要素を取得している場合
メソッドによる要素への変更は全ての要素に与えられる(foreach的な)
値を取得するメソッドは一つ目の要素のものを取得

```js
let $lis = $('.items li');
$lis.css('color', 'red'); // すべてに適用
$lis.css('color');        // 先頭の一つの値を取得
```

cssで取得する値も計算済みの値 rgb(r, g, b) なので、条件式に使うのは注意

## セレクタ―

は、飛ばしまして

## jQuery独自のセレクタ―

要素数のカウントは 0 始まりになるので注意(CSSは 1 始まり)

独自？か調べる
:contains(text)  テキストコンテントを判定
:has(slct)
:empty           子ノードを持たない
:parent          子ノードを持つ

### 子要素フィルター インデックス

|-          |-
|-          |-
| :first    | 
| :last     | 
| :even     | 偶数インデックス -> 直感的には奇数番目
| :odd      | 奇数インデックス -> 直感的には偶数番目
| :eq()     | インデックス
| :gt()     | より大きい
| :lt()     | 未満
| :header   | headingタグ要素
| :animated | アニメーション動作中要素

ややこしいところ
```
<ul> <li>1</li><li>2</li><li>3</li> </ul>
<ul> <li>4</li><li>5</li><li>6</li> </ul>
<ul> <h1>7</h1><li>8</li><li>9</li> </ul>
```

|-                     |-                       |-
|-                     |-                       |-
| li                   | 1, 2, 3, 4, 5, 6, 8, 9 |
| li:first             | 1                      | 一つ目のli
| li:first-child       | 1, 4                   | 子要素の一つ目であるli
| li:even              | 1, 3, 5, 8, 9          |
| li:nth-child(even)   | 2, 5, 8                | 子要素の(even)番目であるli
| li:nth-of-type(even) | 2, 5, 9                | 子要素のliの(even)番目であるli
| li:eq(2)             | 3                      |
| li:gt(2)             | 4, 5, 6, 8, 9          |
| li:lt(2)             | 1, 2                   |

### 子要素フィルター フォームタイプ

#### jQuery独自？非推奨？右の書き換えが良い？
|-          |-
|-          |-
| :button   | button, input[type="button"]
| :checkbox | [type="checkbox"]
| :file     | [type="file"]
| :image    | [type="image"]
| :input    | input, textarea, select, button
| :password | [type="password"]
| :radio    | [type="radio"]
| :reset    | [type="reset"]
| :submit   | [type="submit"] buttonのsubmitを含むかはブラウザ差あり
| :text     | [type="text"]

#### jQuery独自？"input"とかを省略できるってことか 非推奨じゃない？
|-          |-
|-          |-
| :checked  | input:checked
| :selected | select option:selected
| :disabled | input:disabled
| :enabled  | input:enabled
| :visible  | visibirity:hidden, opacity:0などの透明はvisible
| :hidden   | display:none, type="hidden" widthとheightが0 親から非表示

### フィルター メソッド

* is(slct)  一致すればtrue、でなければfalse

```js
// 指定した要素がcheck
let ret1 = $('div').is('.man');
let ret2 = $('#chk').is(':checked');
```

### attribute操作

* 取得
  attr(attr)        val なければundefined
* 代入
  attr(attr, val)
  attr({attr: val, attr: val...})
  attr(attr, function(idx, attr) { /* 代入する値 */ })

```js
$('img').attr('title', function(idx, val) {
  // [(インデックス)] (現在のval) (altのval) にしたい
  return '[' + index + ']' + val + this.alt;
});
```

* 削除
  removeAttr(attr)  val

### class操作

* addClass(cls)
* removeClass()          クリア
* removeClass(cls)       指定のクラスのみ
* toggleClass(cls)
* toggleClass(cls, bool) trueなら追加、falseなら削除
* hasClass(name)

### css操作単位とかwidth()たちとの違いとかぐぐりなおす

* 取得
  単位はpx, 戻り値は単位含む文字列
  propは文字列としてクォーテーションをつけるかキャメルケースで書くか
* 代入
  相対値('+=15'など)あり
* css(prop)              取得
* css(prop, val)         '+=15'などで値の変更可能(px？)
* css({prop: val, prop: val...})

### width, height操作

取得
  戻り値は整数値と一部小数値, box-sizingの影響なし
代入
  単位付きの文字列('50%'など)可能, box-sizingの影響あり

* width()
* height()
* innerWidth()
* innerHeight()
* outerWidth(bool = false)   trueでmarginを含む
* outerHeight(bool = false)  trueでmarginを含む

* width(val)
* height(val)
* innerWidth(val)
* innerHeight(val)
* outerWidth(val)
* outerHeight(val)

### scroll, 座標操作

* scrollTop()   スクロールバーが表示されない場合は0
* scrollLeft()  横
* offset()      htmlに対する位置 戻り値はオブジェクト
* position()    位置的な親要素(position: static以外である親)に対する位置

```js
let off = $('#main').offset(); // { top=50, left=20 }
$('#main').offset().top; // 50
off.left; // 20
```

## html, text, form

### html(), text()

* html()  HTML文字列 HTML文字列の代入はHTMLとして反映
* text()  テキストノードのみ HTML文字列の代入はエスケープされてただの文字列に
  ※複数あるときはすべての要素のテキスト部分をつなげて取得する 子孫要素があっても同様か？
だいたいinnerHTML()とinnerText()的な違い

html()とtext()の取得

```html
<ul>
  <li><span>太郎</span></li>
  <li><span>次郎</span></li>
  <li><span>花子</span></li>
</ul>
```

```js
  let ret1 = $('li').html(); // <span>太郎</span>
  let ret2 = $('li').text(); // 太郎次郎花子
```

### form, val()

val()  フォーム要素の値 multipleでは配列で返す

selectの例

```js
// name=rdoのラジオボタンでチェックされているもの
let checked = $('input[type=radio][name=rdo]:checked').val();
// セレクトボックスは親のselectのval()でよい
let selected = $('select').val();
// チェックボックスはcheckedが複数とれると、そのままval()しても一つ目しか取得できない
let checkeds = $('input[type=checkbox][name=chk]:checked').map(function() {
  return $(this).val();
}).toArray;
```

* val(value)
  入力要素の場合は入力値の変更
  選択要素の場合は選択状態に
  複数選択するにはval(arr)で複数指定

## 要素の追加等

  要素の追加
  要素がドキュメント内にある場合は移動
  追加される対象が複数の場合は全てに追加(複製)
* 追加される親のメソッド(target.append(elm))
  * append(elm)   親の末尾
  * prepend(elm)  親の先頭
  * before(elm)   親の前
  * after(elm)    親の後ろ
* 追加する子のメソッド(elm.appendTo(target))
  * appendTo(elm)
  * prependTo(elm)
  * insertBefore(elm)
  * insertAfter(elm)

例
操作前

```html
<ul>
  <li id="taro">太郎</li>
  <li>次郎</li>
  <li>三郎</li>
</ul>
<ul>
  <li>花子</li>
</ul>
```

```js
  $('ul').append($('#taro'));
```

操作後

```html
<ul>
  <li>次郎</li>
  <li>三郎</li>
  <li id="taro">太郎</li>
</ul>
<ul>
  <li>花子</li>
  <li id="taro">太郎</li>
</ul>
```

## wrap, replace

| method        |-
|-              |-
| wrap()        | 対象をタグでラップ
| wrapAll()     | 対象をまとめてラップ 対象以外は押し出される
| wrapInner()   | 指定要素の中身をラップ
| unwrap()      | 指定要素の中身のみ残す wrapAllの逆的な
| replaceWith() | 要素を指定の要素で置き換え 戻り値が置き換えられた要素
| replaceAll()  | append()とappendTo()的な<br>A.replaceWith(B) と B.replaceAll(A) が同じ

* 例
```html
<span>太郎</span>
<span>次郎</span>
```

* wrap()

```js
$('span').wrap('<div></div>');
```

```html
<div><span>太郎</span></div>
<div><span>次郎</span></div>
```

* wrapAll()

```js
$('span').wrapAll('<div></div>');
```

```html
<div>
  <span>太郎</span>
  <span>次郎</span>
</div>
```

* wrapAll()-2
操作前

```html
<span>太郎</span>
<strong>花子</strong>
<span>次郎</span>
```

```js
$('span').wrapAll('<div></div>');
```

```html
<div>
  <span>太郎</span>
  <span>次郎</span>
</div>
<strong>花子</strong> <!-- 追い出される -->
```

* wrapInner()

```js
  $('span').wrapInner('<div></div>');
```

```html
<span><div>太郎</div></span>
<span><div>次郎</div></span>
```

* unwrap()
操作前

```html
<div><span>太郎</span></div>
<div><span>次郎</span></div>
<div>
  <span>三郎</span>
  <span>四郎</span>
</div>
```

```js
$('span').unwrap();
```

```html
<span>太郎</span>
<span>次郎</span>
<span>三郎</span>
<span>四郎</span>
```

* replaceWith()

```html
<div class="container">
  <div class="inner first">太郎</div>
  <div class="inner second">次郎</div>
  <div class="inner third">三郎</div>
</div>
```

### 置換

```js
$('div.second').replaceWith('<h2>花子</h2>');
```

```html
<div class="container">
  <div class="inner first">太郎</div>
  <h2>花子</h2>
  <div class="inner third">三郎</div>
</div>
```

### 移動と置換

```js
$('div.third').replaceWith($('.first')); // 戻り値 $("div.third")
```

```html
<div class="container">
  <div class="inner second">次郎</div>
  <div class="inner first">太郎</div>
</div>
```

### マッチした全ての要素に反映される

```js
$('div.inner').replaceWith('<h2>花子</h2>');
```

```html
<div class="container">
  <h2>花子</h2>
  <h2>花子</h2>
  <h2>花子</h2>
</div>
```

## 削除, クローン

* remove()
\- 要素そのものを削除 戻り値はレシーバオブジェクト(つまり普通)
* empty()
\- 要素の内側を削除
* clone()
\- コピーを作成して返す
\- \- 参照じゃないのでこれをappendしても元のオブジェクトに影響しないということ
\- \- idの重複に注意

## Traversing(横断) ノードウォーキング的な

* first()
* last()
* eq(n)
\- 0始まり 負の値を指定した場合は後ろから数える
* filter(slct)
\- 絞り込み
* not(slct)
* slice()
* find(slct)
\- 要素の子孫要素から探せる
* prev(slct)
* prevAll(slct)
* next(slct)
* nextAll(slct)
* parent(slct)
* parents(slct)
* children(slct)
\- 子すべて
* siblings(slct)
\- 兄弟全て
* closet(slct)
\- 選択した各要素のslctにマッチする最も近い先祖要素を選択(？)
* end(slct)
\- 要素の横断を一つ戻る ひとつ前の選択状態に戻る スタックのイメージ
* addBack(slct)
\- 要素の横断を一つ進む(？)

## jQueryオブジェクト操作

* length
\- 選択中の要素数
* each(function(idx, elm))
\- foreach elmはthis return false;がきく
* get(n)
\- jQueryオブジェクトではなくElementを取り出す
* toArray()
\- jQueryオブジェクトからでもElementを取り出す
* map(function(idx, elm))
\- 普通にmap
* index()
* not()
\- index(), index(elm), index(slct) 複数の場合は最初の要素の位置

## エフェクト

### シンプル

* hide()
* show()
* toggle()
* fadeIn()
* fadeOut()
* fadeTo()
* fadeToggle()
* slideDown()
* slideUp()
* slideToggle()

### カスタム

* animate()
* delay()
* finish()
* stop()
* queue()
* dequeue()
* clearQueue()
* jQuery.fx.interval
\- アニメーションの発火するレート？
* jQuery.fx.off
\- すべてのアニメーションを無効化

## イベント

* on(events[, slct][, data], handler)
* on(events-map[, slct][, data])

| 引数        |-
|-           |-
| events     | スペース区切りで複数指定可能 'mouseenter mouseleave'
| slct       | イベントの委譲を行える $('ul').on(event, 'li', handler)
| data       | ハンドラを使いまわしても要素ごとに渡すデータを選択でき、処理を分岐できる<br>文字列単体で渡すときは、slctとみなされないようにslct部分にnullを渡す必要あり
| events-map | オブジェクトとして複数のイベント+ハンドラをまとめて指定する

```js
$('#click_me').on('click', function() {
  alert('クリックされました');
});
$('ul').on('click', 'li', function() {
  alert($(this).text());
});
// HTMLにdata-nameとかつけておく方法もあり
$('#taro').on('click', {name: '太郎', area: '東京'}, greet);
$('#jiro').on('click', {name: '次郎', area: '埼玉'}, greet);
function greet(event) {
  alert(event.data.area + 'の' + event.data.name + 'です。');
};
$('#view').on({
  mouseenter: function() {
    // 処理;
  },
  mouseleave: function() {
    // 処理;
  }
});
```

### イベント委譲

子要素全部にイベントをつけていたら要素の増減などに対応しきれないので、親要素にイベントをつけて処理のときにどの子要素が発生源となったかを確認して実行する

### イベント付与のショートカット

通常はon('',func)使えだが、ショートカットが用意されているものもある
ready()  いつも書くやつ。これについては逆にon()での指定がv3.0で廃止

blur change click dblclick error(v3.0で廃止)
focus focusin focusout keydown keypress keyup
load mousedown mouseenter mouseleave mousemove mouseout mouseover mouseup
resize scroll select submit unload(v3.0で廃止)

### イベントのthisについて

thisはvanillaと同じなので、jQueryで使用するときは$(this)の形になることが多い

### hover()

オブジェクト.hover(func1, func2)
ホバーイベント用のjQueryオブジェクトメソッド

```js
$('#menu').hover(function() {
  $(this).css('color', 'blue');
}, function() {
  $(this).css('color', 'red');
})
```

### その他メソッド

* one()
\- イベントを付与するが各要素につき一回だけでイベントリスナーが解除される
* off()
\- イベントリスナーの解除(引数指定で絞り込み)
  * off(events[, slct][, handler(eventObject)])
  * off(events-map[, slct])
* trigger()
\- 発火 設定してある要素の全てが動作 戻り値はjQueryオブジェクト
* triggerHandler()
\- 発火 設定してある要素の一つ目のみ動作 戻り値はハンドラのreturn
\- バブリングなし デフォルト動作

### オリジナルの名前でイベントを設定する

trigger()で発火することを前提に、標準にはないイベント('myevent'など)を指定してもよい
それをclickイベントのハンドラ内で発火するのもよい(うざくない？いい？)
offやtriggerでの管理が楽になるかも

### 読み込みが画像まで終了してから実行

```js
$(window).on('load', function() {
  // 読み込み後の処理;
});
```
