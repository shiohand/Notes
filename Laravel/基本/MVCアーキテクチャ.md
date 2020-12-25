# MVCアーキテクチャ

## Model-View-Controller

### それぞれの役割
- Model
  - データ処理全般
  - データベースアクセスに関する処理全般
- View
  - 画面表示
  - 表示用テンプレートなど
- Controller
  - 全体の制御
  - Modelを使ってデータを取得
  - Viewを利用して画面表示を作成

### それぞれのつながり

- Webアプリケーションにアクセス
  - Controller
    - View
      - テンプレート
    - Model
      - データベース