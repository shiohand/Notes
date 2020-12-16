'use strict';
jQuery(function($) {
  // プログレス表示の関数
  imagesProgress();

  // 画像の読み込み状況をプログレス表示
  function imagesProgress() {
    const $container = $('#progress');
    const $progressBar = $container.find('#progress-bar');
    const $progressText = $container.find('#progress-text');
    
    // imagesLoadedオブジェクト作成
    const imgLoad = imagesLoaded('body');
    // 画像の総数
    const imgTotal = imgLoad.images.length;
    // 読み込み完了済み画像数
    let imgLoaded = 0;
    let current = 0;

    // 監視継続して1000/60秒で更新
    // animateのために
    const progressTimer = setInterval(updateProgress, 1000 / 60);
    // loadedカウンター progressで監視できるそうだ
    imgLoad.on('progress', function() {
      imgLoaded++;
    });

    // プログレス表示を更新
    function updateProgress() {

      // いま何パーセント
      const target = (imgLoaded / imgTotal) * 100;
      // 増分の1/10を足す(スピードダウンのため)
      current += (target - current) * 0.1;

      // バーの幅とテキストにcurrentを反映
      $progressBar.css({ width: current + '%'});
      $progressText.text(Math.floor(current) + '%');

      // 終了処理
      if (current >= 100) { // 100%
        clearInterval(progressTimer);
        $container.addClass('progress-complete');
        // $progressBarと$progressTextにあにめーと
        $progressBar.add($progressText) // add()は対象追加、書き換えはしない
          .delay(500) // ちょっと待ってから次
          .animate({ opacity: 0 }, 250, function() {
            $container.animate({
              top: '-100%'
            }, 1000, 'easeInOutQuint');
          }); // 完
      }

      // 99.9%以上なら100とみなして終了
      if (current > 99.9) {
        current = 100;
      }
    }
  }

  // 画像シーケンスのアニメーション
  initScene1();

  function initScene1() {
    const $container = $('#scene-1 .image-sequence');
    const $images = $container.find('img');
    const frameLength = $images.length; // 画像の総数
    let currentFrame = 0; // 現在のインデックス
    let countor = 0; // アニメーションの速度
    let valocity = 0; // アニメーションのタイマー
    let timer = null;
    const imageAspectRatio = 864 / 486; // アス比 設定？

    $container.on('mousewheel', function(event, delta) {
      if (delata < 0) {
        velocity += 1.5;
      } else if (delta > 0) {
        velocity -= 1.5;
      }
      // アニメーション開始
      startAnimation();
    });

    function startAnimation() {
      // 他にアニメーションがなければ(!timer)実行
      if (!timer) {
        timer = setInterval(animateSequence, 1000 / 30);
      } // 上書き
    }
    function stopAnimation() {
      clearInterval(timer);
      timer = null; // 削除
    }

    function animateSequence() {
      // 次の画像
      const nextFrame;
      // 後ほど早くなる 0.00001くらいになったら停止
      velocity *= 0.9;
    }
  }
});