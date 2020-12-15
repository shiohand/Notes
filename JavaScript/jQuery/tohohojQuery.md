# jQuery基礎

## Core

### jQueryオブジェクト

$ は jQuery と同義

```js
jQuery();
jQuery.ajax;
$();
$.ajax;
```

#### 要素の取得

* $(slct[, context])
\- contextは絞り込み $(".btn", "#main")
* $(elm)
* $(elmArray)
* $(obj)
* $(jQueryObj)
* $()

#### 要素の作成

* $(html[, ownerDocument])
* $(html, attributes)
\- $("p", {"class": "bold", "color": "#888"})

#### ready

* $(callback)
\- ready(callback) と同義
\- $(function() {}) // よくあるやつ
* $.holdReady
\- (true) でreadyイベントを抑止
\- (false) で解放
\- \- プラグイン読み込み後にfalseつけるとか
* $.ready()
\- 読み込み状態の監視
* $.readyException
\- ドキュメント読み込み失敗時のコールバック

```js
$.readyException = function(error) {
  console.log(error);
}
```

## セレクタ

は、飛ばしまして

## traversing

* obj.xxx()

### 先祖

* parent([slct])
\- 親要素 slctは絞り込み
* parents([slct])
\- 先祖要素すべて
* parentsUntil([slct][, filter])
* parentsUntil([elm][, filter])
\- 親以降、slctにマッチする要素までの先祖要素(マッチする要素を含まない)
* closet(slct)
* closet(slct[, context])
* closet(jQueryObj)
* closet(elm)
\- マッチするもっとも近い祖先要素

```js
$("li.item").closest("ul");
```

* offsetParent()
\- 位置関係上の親要素(relative, absolute, fixed)

### 子孫

* children([slct])
\- 子要素すべて
* find(slct)
* find(jQueryObj)
* find(elm)
\- 子孫要素から探す

### 兄弟

* siblings([slct])
\- 兄弟要素すべて
* prev([slct])
* next([slct])
* prevAll([slct])
* nextAll([slct])
* prevUntil([slct][, filter])
* prevUntil([elm][, filter])
* nextUntil([slct][, filter])
* nextUntil([elm][, filter])

## Filtering

### 条件
* filter(slct)
* filter(elm)
* filter(function(idx, elm))
* filter(selection)
* not(slct)
* not(elm)
* not(function(idx, elm))
* not(jQueryObj)
* has(slct)
* has(elm)
\- 引数に指定した要素を子要素に持つ要素

### 位置
* first()
* last()
* eq(n)
* slice(n[, m])
\- 要素の位置で取出し

## Filtering Operation

* is(slct)
* is(elm)
* is(function(idx, elm))
* is(jQueryObj)
* map(callback(idx, domElement))

## Miscellaneous Traversing

* contents()
\- テキストやコメントも返す
\- テキストノード、コメントノード的な

```js
$('#block').contents().each(function() {
  if ($(this).attr('id')) {
    // 値がある = 要素ノード
  } else {
    // 要素ノード以外
  }
});
```