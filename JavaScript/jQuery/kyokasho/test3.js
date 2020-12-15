'use strict';
jQuery(function($) {
  const duration = 300;

  // aside
  const $aside = $('.main > aside');
  const $asideBtn = $aside.find('button')
    .on('click', function() {
      $aside.toggleClass('open'); // 処理判定用
      if($aside.hasClass('open')) { // メニューを開いてボタンを返る
        $aside.stop().animate({
          left: '-70px' // ちょっと残してるのはeaseOutBack用っぽい
        }, duration, 'easeOutBack');
        $asideBtn.find('img').attr('src', 'img/btn_close.png');
      } else { // メニューを閉じてボタンを返る
        $aside.stop().animate({
          left: '-350px'
        }, duration, 'easeOutBack');
        $asideBtn.find('img').attr('src', 'img/btn_open.png');
      }
    });
  
  // typoshadow
  $('#typo').typoShadow();
});