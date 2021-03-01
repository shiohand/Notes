

## データベースの用意まとめ

* テーブル作成
`$php artisan make:migration create_xxx_table`
`create(テーブル名, function (Blueprint $table { 作成処理 } ))`
`$table->メソッド(フィールド名)`
`$php artisan migrate`
* シーダー作成
`$php artisan make:seeder XxxTableSeeder`
`DatabaseSeeder.php`に`$this->call(XxxTableSeeder::class)`を追加
`$php artisan db:seed`
* モデル、コントローラ作成
`$php artisan make:model Xxx`

```php
protected $guarded = ['id'];

public static $rules = [
    'person_id' => 'required',
    'title' => 'required',
    'message' => 'required',
];
```

`$php artisan make:controller XxxController`