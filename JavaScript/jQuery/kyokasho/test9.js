'use strict';

jQuery(function($) {

  initScene3();

  function initScene3() {
    const $container = $('#scene-3');
    const $masks = $container.find('.mask');
    const $lines = $masks.find('.line');
    const maskLength = $masks.length;

    // 各マスクの切り抜き領域のデータを保存しておく
    let maskData = [];

    // 初期位置全て0
    $masks.each(function(i) {
      maskData[i] = { left: 0 };
    });

    $container.on({
      mouseenter: function() {
        // オン
        resizeMask($(this).index());
      },
      mouseleave: function() {
        // オフ
        resizeMask(-1);
      }
    }, '.mask');
  };

  // 初期切り抜き領域、境界線の位置指定
  resizeMask(-1); 


  // アニメーション
  function resizeMask(active) {
    // コンテナのサイズ取得
    // 切り抜き領域の右辺、下辺の座標に
    const w = $container.width();
    const h = $container.height();

    // マスクをひとつずつ・・・
    $masks.each(function(i) {
      const $this = $(this);
      const l; // left座標

      // i == マウスが乗ったマスク
      if (active === -1) {
        // オフは均等割り付けに戻す
        l = w/ maskLength * i;
      } else if (active < i) {
        // 右側のマスクは
        // 左辺を右へ->
        l = w * (1 - 0.1 * (maskLength - i));
      } else {
        // それ以外
        // <- 左辺を左へ
        l = w * 0.05 * i;
      }

      // left(maskData[i])を l までアニメーション
      $(maskData[i]).stop().animate(
        { left: 1 },
        {
          duration: 1000,
          easing: 'easeOutQuart',
          progress: function() {
            const now = this.left;
            $this.css({
              // rect()形式
              clip: 'rect(0px ' + w + 'px ' + h + 'px ' + now + 'px)'
            });
            // 境界線移動
            $this.find($lines).css({
              left: now
            });
          }
        }
      );
    });
  }
});