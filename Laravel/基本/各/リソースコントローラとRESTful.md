# リソースコントローラとRESTful


## REST

* REST(Representational State Transfer)
\- WebAPIの実装方式
* RESTful
\- 設計原則に則った、情報の取得や送信などの基本操作が統一されている状態

HTTPのメソッドを利用

| HTTP   | CRUD   |
| ------ | ------ |
| GET    | Read   |
| POST   | Create |
| PUT    | Update |
| DELETE | Delete |

## リソースコントローラの作成

コントローラのコマンドに`--resource`をつけると、リソースコントローラとして生成される
`php artisan make:controller --resource`

追加されているメソッド
```php
/* 一覧表示 */
public function index() {}
/* 作成 */
public function create() {}
public function store(Request $request) {}
/* 表示 */
public function show($id) {}
/* 更新 */
public function edit($id) {}
public function update(Request $request, $id) {}
/* 削除 */
public function destroy($id) {}
```

Resourcefulを満たし、RESTful(createとeditは不要)を満たす

## ルーティングの設定

`routes/web.php`でのルーティング記述は、
`Route::resource(アドレス, コントローラ名);`
と置くだけで全てのアクションが以下のように登録される

| アドレス                  | アクション            |
| ------------------------- | --------------------- |
| `/コントローラ`           | index                 |
| `/コントローラ/`          | create                |
| `/コントローラ`           | store(POST送信)       |
| `/コントローラ/番号`      | show                  |
| `/コントローラ/番号/edit` | edit                  |
| `/コントローラ/番号`      | update(PUT/PATCH送信) |
| `/コントローラ/番号`      | destroy(DELETE送信)   |
番号はプライマリーキー

## レコードを送信する(index, show)

LaravelではアクションメソッドからArrayがreturnされると自動でJSONに変換してくれる

```php
/* index */
$items = Restdata::all();
return $items->toArray;
/* show */
$item = Restdata::find($id);
return $item->toArray();
```

## レコードを追加する(create, store)

フォームから追加していただく

```php
/* create */
return view('rest.create');
/* store */
$restdata = new Restdata;
$form = $request->all();
unset($form['_token']);
$restdata->fill($form)->save();
return redirect('/rest');
```

