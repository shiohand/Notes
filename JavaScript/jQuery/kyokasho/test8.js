'use strict';

jQuery(function($) {
  activateScene2();

  // Scene 2 表示
  function activateScene2() {
    const $content = $('#scene-2-content');
    const $charts = $content.find('.chart');

    // コンテンツ全体を右から引き出す
    $content.stop().animate({
      right: 0
    }, 1200, 'easeInOutQuint');

    // 個々の処理
    $charts.each(function() {
      const $chart = $(this);
      const $circleLeft = $chart.find('.left .circle-mask-inner');
      const $circleRight = $chart.find('.right .circle-mask-inner');
      
      $circleLeft.css({transform: 'rotate(0)'});
      $circleRight.css({transform: 'rotate(0)'});

      // 値取得
      const $percentNumber = $chart.find('.percent-number');
      const $percentData = $percentNumber.text();

      // 初期値0
      $percentNumber.text(0);

      // アニメーション
      $({ percent: 0 }).delay(1000).animate({
        percent: $percentData
      }, {
        duration: 1500,
        progress: function() {
          const now = this.percent;
          const deg = now * 360 / 100;
          const degRight = Math.min(Math.max(deg, 0), 180);
          const degLeft = Math.min(Math.max(deg - 180, 0), 180);

          $circleRight.css({ transform: 'rotate(' + degRight + 'deg)'});
          $circleLeft.css({ transform: 'rotate(' + degLeft + 'deg)'});
          $percentNumber.text(Math.floor(now));
        }
      });
    });
  }
});