'use strict';

jQuery(function($) {
  // imagesLoaded で画像が読み込まれたかどうかを確認
  // Masonry でレイアウト
  $('#gallery').each(function() {
    const $container = $(this);
    
    const $loadMoreButton = $('#load-more'); // もっと見る
    const $filter = $('#gallery-filter');
    const addItemCount = 16; // 一度に表示するアイテム数
    let added = 0; // 表示済
    let allData = []; // データ
    let filteredData = []; // データ(フィルタリング)

    // masonryオブジェクト
    $container.masonry({
      columnWidth: 230,
      gutter: 10,
      itemSelector: '.gallery-item'
    });

    initGallery(getData);
    // 本来はgetJSONだったが、クロスオリジンがどうこうなので変えました。
    // $.getJSON('data/content.json', function(data) {
    // });


    // 画像へのリンク、サムネの表示、altの付加を回す
    function initGallery(data) {
      // 初期化
      allData = data;
      // 初期はフィルタリングしないのでそのまま
      filteredData = allData;
      // 初期表示
      addItems();

      // loadMoreのイベント
      $loadMoreButton.on('click', addItems);
      // フィルターの変更 (各ボタンに以上)
      $filter.on('change', 'input[type="radio"]', filterItems);
      // ホバーエフェクト
      $container.on('mouseenter mouseleave', '.gallery-item a', hoverDirection);
    }

    // 要素の追加、表示
    function addItems(filter) {
      // 要素はまとめてツリーにぶちこみたいので一旦配列に
      const elms = [];
      // 追加対称 データ.slice(表示済の次からaddItemCount個)
      const slicedData = filteredData.slice(added, added + addItemCount);

      // 要素作成、masonry再配置
      $.each(slicedData, function(i, item) {
        const itemHTML = 
          '<li class="gallery-item is-loading">' +
            '<a href="' + item.images.large + '">' +
              '<img src="' + item.images.thumb + '" alt="">' +
              '<span class="caption">' +
                '<span class="inner">' +
                  '<b class="title">' + item.title + '</b>' +
                  '<time class="date" datatime="' + item.date + '">' + 
                    item.date.replace(/-0?/g, '/') + '</time>' +
                '</span>' +
              '</span>' +
            '</a>' +
          '</li>';

        // vanillaなオブジェクトでpush
        elms.push($(itemHTML).get(0));
      });
      // 一気に追加 まだis-loadingで非表示
      $container.append(elms);

      // 画像の読み込み完了後(imagesLoaded(func))にMasonryで追加レイアウト
      $container.imagesLoaded(function() {
        $(elms).removeClass('is-loading');
        $container.masonry('appended', elms);

        // フィルタリング時は再配置 filterがfalse -> 引数が渡されていないのでスルー
        if (filter) {
          $container.masonry();
        }
      });

      // colorboxの設定
      $container.find('a').colorbox({
        maxWidth: '970px',
        maxHeight: '95%',
        title: function() {
          return $(this).find('.inner').html();
        }
      });

      // 追加済みアイテム数に追加
      added += slicedData.length;
      // 追加ボタンの状態更新
      if (added < filteredData.length) {
        $loadMoreButton.show();
      } else {
        $loadMoreButton.hide();
      }
    }

    // フィルタリング機能
    function filterItems() {
      const key = $(this).val(); // チェックされたラジオボタン
      const masonryItems = $container.masonry('getItemElements'); // masonryの機能

      // アイテム削除
      $container.masonry('remove', masonryItems);
      // アイテムのデータ、追加済みカウントをリセット
      filteredData = [];
      added = 0;

      if (key === 'all') {
        // allならサクッと
        filteredData = allData;
      } else {
        // ふぃるたー
        filteredData = $.grep(allData, function(item) {
          return item.category === key;
        });
      }

      addItems(true);
    }

    function hoverDirection(event) {
      const $overlay = $(this).find('.caption');
      const side = getMouseDirection(event);
      // 実行用
      let animateTo;
      // スライドインの始点
      let positionIn = {
        top: '0%',
        left: '0%'
      };
      // スライドアウトの終点
      const positionOut = (function() {
        switch (side) {
          // case0から top, right, bottom, left
          case 0: return { top: '-100%', left: '0%' };
                  break;
          case 1: return { top: '0%', left: '100%' };
                  break;
          case 2: return { top: '100%', left: '0%' };
                  break;
          default: return { top: '0%', left: '-100%' };
                   break;
        }
      })();
      if (event.type === 'mouseenter') {
        // mouseenter
        animateTo = positionIn;
        $overlay.css(positionOut); // 進行方向へ
      } else {
        // それ以外(mouseout)
        animateTo = positionOut;
      }
      $loadMoreButton.stop().animate(animateTo, 250, 'easeOutExpo');
    }

    // マウスはどの上下左右のどの辺で移動したか
    function getMouseDirection(event) {
      // ターゲット
      const $elm = $(event.currentTarget);

      // 要素のoffset取得
      const offset = $elm.offset();
      // 各部
      const w = $elm.outerWidth;
      const h = $elm.outerHeight;
      // 要素に対するポインタの位置の関係？
      const x = (event.pageX - offset.left - w / 2) * ((w > h) ? h / w : 1);
      const y = (event.pageX - offset.top - h / 2) * ((h > w) ? w / h : 1);

      // 0: top, 1: right, 2: bottom, 3: left
      const direction = 
        Math.round((((Math.atan2(y, x) * (180 / Math.PI)) + 180
            ) / 90
          ) + 3
        ) % 4;

      return direction;
    }
  });
  
  // 関係ないけどjQuery UIでラジオボタンカスタマイズ ようわからんし続きはwebで
  $('.filtere-form input[type="radio"]').button({
    icons: {
      primary: 'icon-radio'
    }
  });

});