# Blade サブビューとレイアウト

- [サブビュー](#サブビュー)
  - [`@include()`など](#includeなど)
  - [`@each()`](#each)
- [レイアウト](#レイアウト)
  - [`@extends('ビュー')`](#extendsビュー)
  - [`@section('セクション')`](#sectionセクション)
    - [`@parent`](#parent)
  - [`@yield(セクション名[, default])`](#yieldセクション名-default)
- [例](#例)
  - [土台](#土台)
  - [継承](#継承)
- [コンポーネント](#コンポーネント)
  - [`@component('ビュー')`](#componentビュー)
  - [`@slot('変数名')`](#slot変数名)
- [例](#例-1)

## サブビュー
テンプレートをファイルごと呼び出すことができる

呼び出す側(親)で既に定義してある変数は読み込まれるビューでも使用できる
呼び出す際に渡せる値は単純な文字列のみで、HTMLもエスケープされる

### `@include()`など

`@include(ビュー, 連想配列)`

テンプレートを呼び出す
連想配列で値を渡し、テンプレート側で変数として利用できる
テンプレートが存在しなかった場合はエラー

include系|-
-|-
`@includeIf(ビュー, 連想配列)`|存在していなければ何もしない
`@includeWhen(bool, ビュー, 連想配列)`|boolがtrueなら実行
`@includeUnless(bool, ビュー, 連想配列)`|boolがfalseなら実行
`@includeFirst(ビューの配列, 連想配列)`|配列の中の、存在する最初のビュー

例
```php
/* message.blade.php */
<p>{{$msg}}</p>
/* index.blade.php */
@includeIf('message', ['msg' => 'CAUTION!'])
```

### `@each()`

`@each('ビュー', 配列, '仮変数'[, 'ビュー'])`

配列の各要素を渡しながらレンダリングを繰り返す
第四引数には配列が空だった場合に表示するビューを設定できる
includeと異なり、呼び出す側(親)で既に定義してある変数は使用できない

```php
/* HelloController.php */
public function index()
{
  $param = ['array' => [
      ['name' => 'tanaka', 'mail' => 'one@mail'],
      ['name' => 'suzuki', 'mail' => 'two@each'],
  ]];
  return view('hello.index', $param);
}
/* item.blade.php */
<li>{{$item['name']}} {{$item['mail']}}</li>
/* index.blade.php */
<ul>
  @each('components.item', $array, 'item')
</ul>
```

## レイアウト

レイアウトを継承し、いくつものテンプレートをセクションとして組み合わせてレイアウトを作成していく機能
レイアウト用のフォルダとして`resources/views/layouts`とでも

* `@extends('ビュー')`
* `@section('セクション')`
  * `@section('セクション') @show`
  * `@section('セクション') @endsection`
  * `@section('セクション', '値')`
  * `@parent`
* `@yield(セクション名[, default])`
* `@component('ビュー')`
* `@slot('変数名')`


### `@extends('ビュー')`
テンプレートを利用する
クラスの継承と考え方は同じ
ビューはレンダリングのview()と同じ形式

### `@section('セクション')`
区画を定義する
継承先で内容を作成するための区画

```php
@section('セクション')
@endsection
```
* 一つの文字列で住むなら第二引数に入れてもよい
```php
@section('セクション', '値')
```
* 土台になるレイアウトでは@showで閉じる
```php
@section('セクション')
@show
```
* 継承元にあるセクションを再定義すると上書きされる

#### `@parent`
継承元にあるセクションの内容を維持できる

```php
@section('セクション')
  // 追加する記述
  @parent
  // 追加する記述
@endsection
```

### `@yield(セクション名[, default])`
定義した区画を出力する

```php
@yield('セクション')
```
`<title>@yield('title')</title>` のように、文中でもよいみたい

## 例

### 土台

```php
<title>@yield('title')</title>
<!-- 略 -->
<h1>@yield('title')</h1>
@section('menubar')
<h2 class="menutitle">※メニュー</h2>
<ul>
  <li>@show</li>
</ul>
<hr size="1">
<div class="content">
  @yield('content')
</div>
<div class="footer">
  @yield('footer')
</div>
```

* `<title>@yield('title')</title>`<br>`<h1>@yield('title')</h1>`
\- titleで定義されたセクションを呼び出す
* `@section('menubar')`～`@show`
\- メニュー表示用区画
\- 終わりが中途半端だが、@parentで途中まで呼び出してliの内容だけ書けばすむというつもり。っぽい。
* `@yield('content')`<br>`@yield('footer')`
\- それぞれ呼び出す

### 継承

```php
@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
  @parent
  インデックスページ
@endsection

@section('content')
  <p>コンテンツ</p>
  <p>必要なだけ記述可能</p>
@endsection

@section('footer')
  copyright 2020 tuyano.
@endsection
```
* `@extends('layouts.helloapp')`
\- 継承する
* `@section('title', 'Index')`
\- メニュー表示用区画
* `@section('menubar')`<br>`@section('content')`<br>`@section('footer')`
\- 埋め込む内容を記述
* `@parent`
\- 親のセクションの続きに埋め込む

## コンポーネント
テンプレートをファイルごと呼び出すことができる
レイアウトを使い回して内容だけ呼び出し側で設定するイメージ
コンポーネント用のフォルダとして`resources/views/components`とでも

テンプレートに組み込む際に変数を渡すことができ、HTMLやスクリプトも反映される

### `@component('ビュー')`
テンプレートを呼び出す

```php
@component('ビュー')
@endcomponent
```

### `@slot('変数名')`
変数を定義

```php
@slot('変数名')
// 代入する値
@endslot
```

## 例

```php
/* components/message.blade.php */
<div class="message">
  <p class="meg_title">{{$msg_title}}</p>
  <p class="meg_content">{{$msg_content}}</p>
</div>
```
```php
/* index.blade.php */
@component('components.message')
  @slot('msg_title')
    CAUTION!
  @endslot
  @slot('msg_content')
    これはメッセージの表示です。
  @endslot
@endcomponent
```

