# Blade

- [](#)
- [Bladeのエスケープ](#bladeのエスケープ)
- [埋め込み](#埋め込み)
- [ディレクティブ](#ディレクティブ)
  - [条件分岐](#条件分岐)
  - [繰り返し](#繰り返し)
    - [ループ変数 `$loop`](#ループ変数-loop)
  - [フォーム利用](#フォーム利用)
- [issetによるGETとPOSTの分岐](#issetによるgetとpostの分岐)

## ビュー
レイアウトに関しては Blade サブビューとレイアウト.md へ

```
Bladeビューで__DIR__と__FILE__定数は使用しないでください。これらは、キャッシュされコンパイルされたビューの場所を参照するためです。
```
https://readouble.com/laravel/8.x/ja/blade.html

## Bladeのエスケープ

`{{ }}`や`@ディレクティブ`などの特殊な埋め込みをエスケープしたいときは`@{{ }}`や`@@ディレクティブ`とする
`@verbatim`ディレクティブを利用すれば、その中の`{{}}`は全てエスケープされる
jsのフレームワークで必要なときとか

## 埋め込み

* `{{ 変数など }}`
\- HTMLはエスケープされる
* `{!! 変数など !!}`
\- エスケープされず、HTML文字列もレンダリングされる
* `{{-- コメント --}}`

## ディレクティブ
特記なければ、`@xxx`で開始`@endxxx`で終了

| ディレクティブ                | -                            |
| ----------------------------- | ---------------------------- |
| @php                          | `<?php  ?>`                  |
| @auth                         | ユーザー認証済み             |
| @guest                        | ユーザー認証済みでない       |
| @hasSection(セクション名)     | セクションにコンテンツがある |
| @sectionMissing(セクション名) | セクションにコンテンツがない |

例
```php
@sectionMissing('navigation')
  <div class="pull-right">
    @include('default-navigation')
  </div>
@endif
```

### 条件分岐


| if系           | -                            |
| -------------- | ---------------------------- |
| @if (条件)     | 条件が真の場合(続き↓)        |
| @unless (条件) | 条件が偽の場合               |
| @isset(変数) | 変数が存在する(nullは未定義) |
| @empty(変数) | 変数が存在しないまたは空     |
| @switch(値)    | switch(続き↓)                |

それぞれ `@else`, `@break` も可能

* if
```php
@if (条件)
@elseif (条件)
@else
@endif
```
* switch
```php
@switch(値)
  @case(値)
    @break
  @case(値)
    @break
  @default
    @break
@endswitch
```

### 繰り返し

| 繰り返し                        | -              |
| ------------------------------- | -------------- |
| @for (初期値;条件;更新)         | for            |
| @foreach ($iterable as $仮変数) | foreach        |
| @forelse ($iterable as $仮変数) | forelse(続き↓) |
| @while (条件)                   | while          |

※ foreach系の仮変数は`$key => $value`可能

* forelse
```php
@forelse ($iterable as $仮変数)
@empty // $iterableが何も取得しなかった場合
@endforelse
```

それぞれ `@continue`, `@break` も

#### ループ変数 `$loop`

繰り返しディレクティブの中で使える特殊な変数

| プロパティ | -                               |
| ---------- | ------------------------------- |
| index      | 現在のインデックス(0はじまり)   |
| iteration  | 繰り返し回数(1はじまり)         |
| remaining  | 残り回数                        |
| count      | 繰り返している配列の要素数  |
| first      | bool 最初の繰り返しか           |
| last       | bool 最後の繰り返しか           |
| even      | bool 偶数回目の繰り返しか           |
| odd       | bool 奇数回目の繰り返しか           |
| depth      | 繰り返しのネスト数              |
| parent     | ネストしている場合の親の`$loop` |

```php
@foreach ($users as $user)
  @foreach ($user->posts as $post)
    @if ($loop->parent->first)
      ここは親ループの最初の繰り返し処理
    @endif
  @endforeach
@endforeach
```

### フォーム利用

* `@csrf`
\- フォーム内に必須(忘れていると例外が発生する)
\- CSRF対策 非表示フィールドとしてトークンを追加し、この値の正しいときのみ受け付けるようにする
* `@error ('項目名')`
\- 指定した項目のエラーメッセージがある場合のみ表示
\- 詳細->バリデーション.md


## issetによるGETとPOSTの分岐
* `Route::post()`のときだけデータを渡し、それが`isset()`などで分岐
* POSTでも入力値が空のときは空文字ではなくnullになってしまうので、データから取得時にnull合体演算子で取る
* てか単にpostならpostのデータ渡しちゃだめなん。
* てかそれ用の処理とかないん

```php
/* HelloController.php */
public function post(Request $request) {
  $data = ['msg' => $request->msg ?? ''];
  return view('hello.index', $data);
}
/* index.blade.php */
@isset ( $msg )
  post
@else
  index
@endisset
```
