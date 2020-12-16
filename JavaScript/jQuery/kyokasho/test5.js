'use strict';
jQuery(function($) {
  $('.work-section').each(function() {
    const $container = $(this); // 全体
    const $navItems = $container.find('.tabs-nav li'); // タブリスト
    const $highlight = $container.find('.tabs-highlight'); // highlight 選択中のタブ

    // jQuery UI Tabs
    $container.tabs({
      hide: { duration: 250 },
      show: { duration: 125 },
      // 読み込み時とタブ洗濯時のハイライトの位置
      create: moveHighlight,
      activate: moveHighlight
    });

    function moveHighlight(event, ui) { // event, オブジェクト
      const $newTab = ui.newTab || ui.tab; // 新しく選択されたタブ
      const left = $newTab.position().left; // left
      // ハイライトをleftへアニメーション
      $highlight.animate({ left: left }, 500, 'easeOutExpo');
    }
  });

  // スクロールトップ
  $('.back-to-top').each(function() {
    // scrollableElement()でスクロール操作をどっちでできるか検出
    const el = scrollableElement('html', 'body');
    // クリックイベント設定
    $(this).on('click', function(event) {
      event.preventDefault();
      $(el).animate({scrollTop: 0}, 250);
    });
  });

  // scrollableElement()
  // 別に覚えなくてもぐぐればでてくるよ
  function scrollableElement(...elms) {
    for(elm of elms) {
      $elm = $(elm);
      if ($elm.scrollTop() > 0) {
        // 既に稼働中(ある) 返す
        return elm;
      } else {
        // 0なのかないのか
        $elm.scrollTop(1); // 1にしてみる
        const scrollable = $el.scrollTop() > 0; // どうだ？
        $elm.scrollTop(0); // ちゃんと戻しとく
        if (scrollable) {
          // trueだ 1になっていた 返す
          return elm;
        }
      }
    }
    return []; // 該当なし
  }

  $('.back-to-top2').on('click', function() {
    $.smoothScroll({
      easing: 'easeOutExpo',
      speed: 500
    });
  });
  // 任意の要素のメソッドとして設定できる
  $('.toc a').smoothScroll({
    afterScroll: function() {
      location.hash = $(this).attr('href');
    }
  })
});

/**
 * jQuery UI Tabs
 * 
 * タブ と パネル を含む
 * href と id で関連付けると切り替えを実装してくれる
 * 
 * 今回は
 * <section class="work-section">
 *   <ul>
 *     <li><a href="#work01">Work 01</a></li>
 *   </ul>
 *   <section id="work01"></section>
 * </section>
 * という感じ
 * 
 * オプション 今回使用したもの
 * hide: { duration: 250 }
 * show: { duration: 125 }
 * create: 読込時 関数
 * activate: 選択時 関数
 *   createやactiveなどのUI Tabsから呼ばれる関数は、引数に(event, ui)を受け取る
 *   event  UI Tabs独自のイベントオブジェクト
 *   ui     発生元要素の情報を持つオブジェクト
 *          ui.tabs     該当タブ(createのとき)
 *          ui.newTabs  該当タブ(activateのとき)
 */