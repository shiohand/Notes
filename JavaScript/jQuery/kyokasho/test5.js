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
      const $newTab = ui.navTab || ui.tab; // 新しく選択されたタブ
      const left = $newTab.position().left; // left
      // ハイライトをleftへアニメーション
      $highlight.animate({ left: left }, 500, 'easeOutExpo');
    }
  });
});