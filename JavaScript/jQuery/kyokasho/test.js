'use strict';
jQuery(function($) {
  /* ----------------------------------------
    sec1
  ---------------------------------------- */
  // buttonにeach()でイベントをつける
  $('#sec1 button').each(function() {
    // 共通して変更の対象となる要素
    const $target = $('#sec1 .text');
    // btn1 背景色変更のクラスをtoggle
    if($(this).hasClass('btn1')) {
      $(this).on('click', function() {
        $target.toggleClass('change');
      });
    }
    // btn2 テキスト変更
    if($(this).hasClass('btn2')) {
      $(this).on('click', function() {
        const text = $target.text() === 'jQuery' ? 'jQueried' : 'jQuery';
        $target.text(text);
      });
    }
  });
  /* ----------------------------------------
    sec2
  ---------------------------------------- */
  // buttonにeach()でイベントをつける
  $('#sec2 button').each(function() {
    // 共通して変更の対象となる要素
    const $target = $('#sec2 .text');
    // btn3 透明度変更のクラスをtoggle
    if($(this).hasClass('btn3')) {
      $(this).on('click', function() {
        const opacity = $target.css('opacity') === '1' ? '0.5' : '1';
        $target.css('opacity', opacity);
      });
    }
    // btn2 背景色変更をcss()で
    if($(this).hasClass('btn4')) {
      $(this).on('click', function() {
        const color = $target.css('background-color') === '#cc8' ? '#c8c' : '#cc8';
        console.log($target.css('background-color'));
        $target.css('background-color', color);
      });
    }
  });
  /* ----------------------------------------
    sec3
  ---------------------------------------- */
  // 関数を外部化する
  const tglChange = function() {
    $(this).toggleClass('change');
  };
  $('#sec3 button').each(function() {
    $(this).on('click', tglChange)
  });
  /* ----------------------------------------
    sec4
  ---------------------------------------- */
  $('#sec4 .btn7').on('click', function() {
    $(this).animate({
      padding: '2em',
      fontSize: 20
    }, 2000);
  });
  /* ----------------------------------------
    sec5
  ---------------------------------------- */
  $('#sec5 .text').eq(0)
  .on('mouseenter', function() {
    $(this).animate({opacity: '0.5'}, 1000);
  })
  .on('mouseleave', function() {
    $(this).animate({opacity: '1'}, 1000);
  });
  $('#sec5 .text').eq(1)
  .on('mouseenter', function() {
    $(this).stop(true).animate({opacity: '0.5'}, 1000);
  })
  .on('mouseleave', function() {
    $(this).stop(true).animate({opacity: '1'}, 1000);
  });
});