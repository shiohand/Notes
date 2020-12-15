'use strict';
jQuery(function($) {
  /* ----------------------------------------
    sec1
  ---------------------------------------- */
  const duration = 300;

  /* btns1 1
  ---------------------------------------- */
  $('#btns1 button:nth-child(-n+4)') // 4以下
    // 色の変更
    .hover(function() {
      $(this).stop().animate({
        backgroundColor: '#ae5e9b',
        color: '#fff'
      }, duration);
    }, function() {
      $(this).stop().animate({
        backgroundColor: '#fff',
        color: '#ebc000'
      }, duration);
    });
  /* btns1 2
  ---------------------------------------- */
  $('#btns1 button:nth-child(n+5):nth-child(-n+8)') // 5以上 ８以下
    // 内枠が出てくる
    .hover(function() {
      $(this).stop().animate({
        borderWidth: '12px',
        color: '#ae5e9b'
      }, duration, 'easeOutSine');
    }, function() {
      $(this).stop().animate({
        borderWidth: '0px',
        color: '#ebc000'
      }, duration, 'easeOutSine');
    });
  $('#btns1 button:nth-child(n+9)') // (n+5)かつ(-n+8))
    // スライド
    .hover(function() {
      $(this).find('> span').stop().animate({
        width: '100%'
      }, duration, 'easeOutSine');
    }, function() {
      $(this).find('> span').stop().animate({
        width: '0'
      }, duration, 'easeOutSine');
    });
  /* ----------------------------------------
    sec2
  ---------------------------------------- */
  // const duration = 300;
  const $images = $('#images p');

  /* images1 1
  ---------------------------------------- */
  $images.filter(':nth-child(1)') // フェードイン
    .hover(function() {
      $(this).find('strong, span').stop().animate({
        opacity: 1
      }, duration);
    }, function() {
      $(this).find('strong, span').stop().animate({
        opacity: 0
      }, duration);
    });
  /* images1 2
  ---------------------------------------- */
  $images.filter(':nth-child(2)') // 左からスライド
    .hover(function() {
      $(this).find('strong').stop().animate({
        opacity: 1,
        left: 0
      }, duration);
      $(this).find('span').stop().animate({
        opacity: 1
      }, duration);
    }, function() {
      $(this).find('strong').stop().animate({
        opacity: 0,
        left: '-200%'
      }, duration);
      $(this).find('span').stop().animate({
        opacity: 0
      }, duration);
    });
    /* images1 3
    ---------------------------------------- */
    $images.filter(':nth-child(3)') // フェードイン
      .hover(function() {
        $(this).find('strong').stop().animate({
          bottom: '0px'
        }, duration);
        $(this).find('span').stop().animate({
          opacity: 1
        }, duration);
        $(this).find('img').stop().animate({
          top: '-20px'
        }, duration * 1.3);
      }, function() {
        $(this).find('strong').stop().animate({
          bottom: '-80px'
        }, duration);
        $(this).find('span').stop().animate({
          opacity: 0
        }, duration);
        $(this).find('img').stop().animate({
          top: '0px'
        }, duration);
      });
    /* ----------------------------------------
      sec3
    ---------------------------------------- */
    // const duration = 300;

    /* btns2
    ---------------------------------------- */
    $('#btns2 button').each(function(i) {
      const pos = i * 40 - 40; // 個数分-2個 -40, 0, 40, 80
      $(this).css('top', pos);
    })
      .hover(function() {
        const $btn = $(this).stop().animate({
          backgroundColor: '#faee00',
          color: '#000'
        }, duration);
        $btn.find('img:first-child').stop().animate({ // 交代
          opacity: 0
        }, duration);
        $btn.find('img:nth-child(2)').stop().animate({
          opacity: 1
        }, duration);
      }, function() {
        const $btn = $(this).stop().animate({
          backgroundColor: 'fff',
          color: '#01b169'
        }, duration);
        $btn.find('img:first-child').stop().animate({ // 交代
          opacity: 1
        }, duration);
        $btn.find('img:nth-child(2)').stop().animate({
          opacity: 0
        }, duration);
      });
});