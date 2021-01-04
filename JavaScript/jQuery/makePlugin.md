# プラグインの作り方

## オブジェクトに作用するメソッド
* jQueryオブジェクトのメソッド
\- jQuery.fnオブジェクトに格納
* $.fn = prototypeオブジェクト
\- $.fnにメソッドを追加すればどのオブジェクトからも使えるようになる

### ストレートに加工
```js
$fn.makeBig = function() {
  this.width('+=50px'); // thisは既にjQueryオブジェクトなのでまんまでいいよ
  this.height('+=50px');
  return this; // ちゃんとreturnしたあとのこと(メソッドチェーン)も考えて
};
```
メソッドチェーンで短く書く
```js
$fn.makeBig = function() {
  return this.width('+=50px').height('+=50px'); でもよし
};
```

### 引数を受け取る
```js
$.fn.makeNice = function(options) { // オブジェクトで受け取ろう
  // デフォルト設定
  let defaultOptions = {
    backGroundColor: 'red',
    fontSize: '20px'
  };
  // ユーザーの設定を上書き
  const settings = $.extend(defaultOptions, options);
  // 適用
  this.css({
    backGroundColor: settings.backGroundColor,
    fontSize: settings.fontSize,
  });

  return this;
};
```

### eachで回す

```js
$.fn.makeTitle = function() {
  this.each(function() {
    // each内でthisがDOM要素になっているので囲む
    // 要素のaltとwidthを繋げた文字列をtitleに設定する
    const title = $(this).attr('alt') + ' / 幅 : ' + $(this).attr('width');
    $(this).attr('title', title);
  });
  return this;
};
```
attr(attr, function(idx, attr) { /* 代入する値 */ }) を使って作る

```js
$.fn.makeTitle2 = function() {
  return this.attr('title', function() {
    return $(this).attr('alt') + ' / 幅 : ' + $(this).attr('width');
  });
};
```

## ユーティリティ関数

jQueryにメソッドを追加する

* 単純な追加
```js
$.sum = function(a, b) {
  return a + b;
};
```

* $.extend(obj)を使っても同じ
\- target省略するなら引数一つじゃないとjQueryには追加されない
```js
$.extend({
  sum: function(a, b) {
    return a + b;
  }
});
```

* 安全な追加
\- 即時関数で $ 衝突回避
```js
(function($) {
  $.sum = function(a, b) {
    return a + b;
  };
})(jQuery); // $はスコープ外
```

## 一般公開用のメソッドプラグイン

* ファイル名は jquery.xxx.js の形式
\- 例: jquery.plugin1.js
\- 例: jquery.plugin1-1.0.js
\- 例: jquery.namedPlugin1-1.0.js
\- 必要ならバージョンを含める
\- 重複しない命名、検索するなどして重複のチェック
* $の衝突回避に気を使う (function($) {})(jQuery) を使う
\- 他のプログラムとファイルをまとめられてミニマイズされる対策
\- `(function($) {})(jQuery)`
\- 汚染回避、ミニマイズ用にグローバル変数をローカル変数に
\- `(function($, window, document) {})(jQuery)`
* グローバルの名前空間を汚染しない
* 特に返り値がないときはjQueryオブジェクト(メソッドチェーン)
* each()などで複数要素に対応させる
* オプションはオブジェクト形式でもらう
* イベントハンドラーはイベントの名前空間を使う
* data()はプラグイン名と同等の名前にし、複数の値が必要なときはオブジェクト形式
* 複数のメソッドを使いたいときは、別々に作るのではなく、メインのメソッドの第一引数で分岐させる

```js
(function($, window, document) {
  $.example = function(action) {
    if (action === 'first') {
      // 機能1
    }
    if (action === 'second') {
      // 機能2
    }
  };
})(jQuery);
```
