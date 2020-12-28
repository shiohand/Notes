# prop(), data()

## プロパティ

### prop()

* prop(prop)
\- 取得 複数ある場合は一つ目 存在しない場合はundefined
* prop(prop, value)
\- 設定 .attr()での変更は使わない
* prop(properties)
\- キーバリューのオブジェクトで複数のプロパティを設定

ちなみに、inputなどのvalueはelm.valでとればよい

### 属性とプロパティ

* html上での属性
\- 書いてある通りの状態 文字列
\- attr()で取得
* ブラウザによって解釈されたあとのプロパティ
\- 計算後の値 数値や真偽値である場合もある
\- class -> className
\- srcの値 -> 解釈後の絶対パス
\- checkedの値 -> boolean

### checked,disabledなど

```js
$('#chk').prop('checked', true);
$('#btn').prop('disabled', false);

$('#chk').prop('checked');  // true
$('#chk').is('checked');    // true
$('#btn').prop('disabled'); // false
$('#btn').is('disabled');   // false
```

#### checked他の属性とプロパティ

* checked属性
\- 初期のチェック状態
* checked
\- 現在のchecked
* defaultChecked
\- デフォルトのchecked つまりchecked属性

checkedなどの評価は値の有無で行われる
checked も checked="true" も checked="false" もtrue

## data()
DOM要素に独自のデータを関連付けて管理
初回取得ではカスタム属性から取得する

* 実行中のオブジェクトの属性とは別管理
\- attr()などで値が書き換えられてもdata()で取得済み値は変化しない
\- prop()などで取得 -> 書き換えか。
* 取得時、値が記述通りに型変換される
  * "[1, 2, 3]" -> array
  * "true" -> boolean
  * {"name":"Taro","age":"45"} -> オブジェクト

### data()

* data(key)
\- 取得 prop()と同じく attr()を使う
* data()            
\- キーバリューのオブジェクトで全て取得
* data(key, value)
\- 設定
* data(obj)
\- キーバリューのオブジェクトで複数指定

### removeData()

removeData([name])  name指定して削除 指定なしで全削除
removeData([list])  配列かスペース区切りの複数指定で削除

### sample

```js
let name;
$('.show').attr('data-name', 'tanaka');
$(".show").data('name'); // 初取得なのでカスタム属性から'tanaka'
$('.show').attr('data-name', 'suzuki');
$(".show").data('name'); // 取得済みなので'tanaka'
$('.show').removeAttr('data-name');
$(".show").data('name'); // 取得済みなので'tanaka'
$('.show').attr('data-name'); // undefined
```