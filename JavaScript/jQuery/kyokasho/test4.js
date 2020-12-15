'use strict';
jQuery(function($) {
  /* ----------------------------------------
    スライドショー
  ---------------------------------------- */
  $('.slideshow').each(function() { // なんでeach()するん？->スライドショーが複数あっても良いように
    const $slides = $(this).find('img');
    const slideCount = $slides.length;
    let currentIndex = 0;

    // 1番目のスライドをフェードインで表示
    $slides.eq(currentIndex).fadeIn();

    // 7500ミリ秒ごとに showNextSlide()
    setInterval(showNextSlide, 7500);

    // 次のスライドを表示する
    function showNextSlide() {
      // 次のインデックス(currentIndex+1、それが画像の数を超えていたら1)
      const nextIndex = (currentIndex + 1) % slideCount;
      // 現在のスライドをフェードアウト
      $slides.eq(currentIndex).fadeOut();
      // 次のスライドをフェードイン
      $slides.eq(nextIndex).fadeIn();
      // currentIndex更新
      currentIndex = nextIndex;
    }
  });

  // スライドショー
  // Indicator インジケーター 下のドット
  // Navigation ナビゲーション prevとnext
  // Autoplay 自動再生
  // Pause 一時停止 マウスオーバー
  $('.slideshow2').each(function() {
    const $container = $(this);
    const $slideGroup = $container.find('.slideshow2-slides');
    const $slides = $container.find('.slide');
    const $nav = $container.find('.slideshow2-nav');
    const $indicator = $container.find('.slideshow2-indicator');

    const slideCount = $slides.length;
    let indicatorHTML = '';
    let currentIndex = 0;
    const duration = 500;
    const easing = 'easeInOutExpo';
    const interval = 7500;
    let timer;

    /* HTML要素の配置 生成 挿入
    ---------------------------------------- */
    // 各スライドの位置を決定
    // インジケーターのアンカー生成
    $slides.each(function(i) {
      $(this).css({ left: 100 * i + '%'}); // 個数分右へ
      indicatorHTML += '<a href="#">' + (i + 1) + '</a>'; // 個数分のa要素のHTML
    });
    $indicator.html(indicatorHTML); // 出来上がったHTML文を挿入

    /* 関数の定義
    ---------------------------------------- */
    // 指定のスライドを表示する関数
    function goToSlide(index) {
      // スライドグループを移動
      $slideGroup.animate({ left: -100 * index + '%'}, duration, easing);
      // currentIndex更新
      currentIndex = index;
      // ナビゲーションとインジケーターを更新
      updateNav();
    }
    // ナビゲーションとインジケーターを更新する関数
    function updateNav() {
      /* ナビゲーション */
      const $navPrev = $nav.find('.prev');
      const $navNext = $nav.find('.next');
      // 最初のスライドならprevを無効
      if(currentIndex === 0) {
        $navPrev.addClass('disabled');
      } else {
        $navPrev.removeClass('disabled');
      }
      // 最後のスライドならnextを無効
      if(currentIndex === slideCount - 1) {
        $navNext.addClass('disabled');
      } else {
        $navNext.removeClass('disabled');
      }
      /* インジケーター */
      // 現在のスライドを無効に
      $indicator.find('a').removeClass('active').eq(currentIndex).addClass('active');
    }
    // タイマーを開始する関数
    function startTimer() {
      // intervalで設定した時間ごとに処理
      timer = setInterval(function() {
        // 次のスライドへ
        const nextIndex = (currentIndex + 1) % slideCount;
        goToSlide(nextIndex);
      }, interval);
    }
    // タイマーを停止する関数
    function stopTimer() {
      clearInterval(timer);
    }

    /* イベント登録
    ---------------------------------------- */
    // ナビゲーションのクリック
    $nav.on('click', 'a', function(event) { // 'a'はイベントの移譲でしたね
      event.preventDefault();
      if($(this).hasClass('prev')) {
        goToSlide(currentIndex - 1);
      } else {
        goToSlide(currentIndex + 1);
      }
    });
    // インジケーターのクリック
    $indicator.on('click', 'a', function(event) {
      event.preventDefault();
      if($(this).hasClass('active')) {
        goToSlide($(this).index()); // クリックされた要素のインデックスをそのまま引数に
      }
    });
    // マウスオーバーでの停止はタイマーの停止で
    $container.on({
      mouseenter: stopTimer,
      mouseleave: startTimer
    });

    /* スライドショー開始
    ---------------------------------------- */
    goToSlide(currentIndex);
    startTimer();
  });

  /* ----------------------------------------
    スティッキーヘッダー
  ---------------------------------------- */
  $('.page-header').each(function() {
    const $window = $(window);
    const $header = $(this);
    const $headerClone = $header.contents().clone();
    const $headerCloneContainer = $('<div class="page-header-clone"></div>');
    const threshold = $header.offset().top + $header.outerHeight(); // ヘッダの位置 + ヘッダ自体のheight

    $headerCloneContainer.append($headerClone); // 要素作成
    $headerCloneContainer.appendTo('body'); // bodyの最後でいいや

    // スクロールイベント(1秒に15/1回に加減 つまり1000/15秒に一回)
    $window.on('scroll', $.throttle(1000 / 15, function() {
      if ($window.scrollTop() > threshold) { /* thresholdを超えたら */
        $headerCloneContainer.addClass('visible');
      } else {
        $headerCloneContainer.removeClass('visible');
      }
    }));
    // 手動発火(初期位置が一番上とは限らん)
    $window.trigger('scroll');
  });
});