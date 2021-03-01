タスク実現を容易にするための関数、クラス、規約の集合

ルーティング
  リクエストとレスポンスのための処理などをつなぐ
オブジェクト関係マッピング
  データベースを変更するためのメソッドを提供
ユーザ管理
  利用者のユーザ情報管理、権限管理

メジャーなフレームワーク
  Laravel, Symfony, Zend Framework

---Laravel---

インストール  php composer.phar global require laravel/installer=~1.1"
プロジェクト作成  laravel new プロジェクト名
ディレクトリ作成  laravel new ディレクトリ名
(composer) $ composer create-project laravel/laravel menu "5.1.*"

プロジェクトディレクトリのserver.phpでサーバを起動
  php -S localhost:8000 -t menu2/public menu/server.php
  (-tは提供するルートディレクトリを変更している)

ルーティングの制御
  app/Http/routes.phpで制御
  Route::get(ルート, 処理); // Route::postだたり
view
  view() resources/viewsディレクトリから
<?php
Route::get('/show', function() { // /showのリクエストをgetで
  // 処理、レスポンス
  $now = new DateTime();
  $items = ['Fried Potatoes', 'Boiled Potatoes', 'Baked Potatoes'];
  // view() 今回はshow-menu.php
  return view('show-menu', ['when' => $now, 'what' => $items]);
});
?>
---show-menu.php
<p> At <?php echo $when->format('g:i a') ?>, here is what's available: </p>
<ul>
<?php foreach($what as $item) { ?>
<li><?php echo $item ?></li>
<?php } ?>
</ul>
---
エスケープとかはBladeテンプレートエンジンが便利だそうだよ知らんけど

---Symfony---
  コンポーネントの集合でもある テンプレート作成とかデバッグとかで部分的に使うこともできる

ダウンロードしたインストーラーのファイル名をsymfonyに変更
chmod a+x symfonyまでのフルパス で実行
プロジェクト作成  symfony new プロジェクト名
ディレクトリ作成  symfony new ディレクトリ名
(composer) $ composer creqate-project symfony/framework-standard-edition プロジェクト名
(composer) $ (cd project_name; php app/console server:run)

プロジェクトディレクトリでサーバを起動
php app/console server:run

ルーティングの制御
  ルーティングをまとめたファイルは無い
  src/AppBundle/Controllerディレクトリの個々のクラスでルーティングを設定
  対応するルートをコメントで注記
view
  $this->render() app/Resources/viewディレクトリから
<?php
namespace AppBundle\Controller;
// 名前空間使用

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
// 使う名前空間をいただき

class MenuController extends Controller
{
  /**
   * @Route("/show")
   * @Method("GET")
   */
  public function showAction()
  {
    $now = new DateTime();
    $items = ['Fried Potatoes', 'Boiled Potatoes', 'Baked Potatoes'];

    // $this->render() show-menu.html.twig
    return $this->render("show-menu.html.twig", ['when' => $now, 'what' => $items]);
  }
}
?>
---show-menu.html.twig
{% extends 'base.html.twig' %}

{% block body %}
<p> At {{ when|date("g:i a") }}, here is what's available: </p>
<ul>
{% for item in what %}
<li>{{ item }}</li>
{% endfor %}
</ul>
{% endblock %}
---
viewはデフォルトではTwigテンプレートエンジン
慣れると便利だけど普通のPHPでもいい

---Zend Framework---
  他二つよりさらにコンポーネント寄り
  なので一部取り出して使うのは簡単だが全部使おうとするとちょっと難しい

インストール(スケルトン)
composerでインストール
  $ composer create-project --no-interaction --stability="dev" zendframework/skeleton-application menu
プロジェクトディレクトリでサーバー起動
  php -S localhost:8000 -t public/ public/index.php

モジュール
  関連するアプリケーションコードをmodulesにまとめる
  大規模アプリケーションでは大まかな部分ごとに分けることもある
Applicationベースモジュール
  /Application以下のパスをコントローラクラスのコードにマッピングするデフォルトルーティングロジック
view
  new ViewModel オブジェクトを作成

ベースモジュールにコードを追加
module/Application/src/Application/Controller
MenuController.php
<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MenuController extends AbstractActionController
{
  public function showAction()
  {
    $now = new DateTime();
    $items = ['Fried Potatoes', 'Boiled Potatoes', 'Baked Potatoes'];
    // new ViewModel newだぞ
    return new ViewModel(array('when' => $now, 'what' => $items));
  }
}
?>
フレームワークに新しいクラスについて知らせる
module/Application/config/module.config.phpの'controllers'の定義部分に追加
<?php
array( // 中略
  'controllers' => array(
    'invokables' => array(
      'Application\Controller\Index' => 'Application\Controller\IndexController',
      // Menuのルーティング追加
      'Application\Controller\Menu' => 'Application\Controller\MenuController'
    )
  )
);
?>
---module/Application/view/application/menu/show.phtml
<p> At <?php echo $when->format('g:i a') ?>, here is what's available: </p>
<ul>
<?php foreach($what as $item) { ?>
<li><?php echo $this->escapeHtml($item) ?></li>
<?php } ?>
</ul>
---
デフォルトではエスケープしていないので今回はescapeHtml()してみた
