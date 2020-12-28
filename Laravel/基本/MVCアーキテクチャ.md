# MVCアーキテクチャ

## Model-View-Controller

### それぞれの役割
* Model
  * データ処理全般
  * データベースアクセスに関する処理全般
* View
  * 画面表示
  * 表示用テンプレートなど
* Controller
  * 全体の制御
  * Modelを使ってデータを取得
  * Viewを利用して画面表示を作成

### それぞれのつながり

* Webアプリケーションにアクセス
  * Controller
    * View
      * テンプレート
    * Model
      * データベース


## サービスインジェクション

### Q.
なぜ引数を追加したら自動で取得してくれる？
```php
/* コントローラのアクションでRequestとResponseが湧いてくる例 */
public function index(Request $request, Response $response) {}
```

### A.
Laravelの機能が入ったプログラムであるサービスが
いっぱいつまったサービスコンテナが
自動で対応するクラスのインスタンスを
引数に渡してくれるから

* サービスインジェクション
\- インジェクション……？　Dependency Injection！　そゆことー。