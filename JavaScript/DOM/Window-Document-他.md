# Window-Document-他

- [Window](#window)
- [screen](#screen)
- [Window](#window-1)
- [Location](#location)
- [History](#history)
- [Document](#document)
- [多分子供は知らなくていいやつ](#多分子供は知らなくていいやつ)

## Window
| prop          | w   | ret            |
| ------------- | --- | -------------- |
| console       |     |
| document      |     |
| event         |     | 現在のイベント |
| history       |     | HistoryObj     |
| location      | w   | LocationObj    |
| localStrage   | w   | StrageObj      |
| sessionStrage | w   | StrageObj      |

* サイズ、座標
| prop                | w   | ret                        |
| ------------------- | --- | -------------------------- |
| fullScreen          | w   | bool                       |
| innerHeight/Weight  |     | viewport                   |
| outerHeight/Width   |     | ウィンドウのサイズ         |
| pageXOffset/YOffset |     | 現在のスクロール位置       |
| screenX/Y           |     | 画面とブラウザの始点の距離 |

* ウィンドウ取得
| prop   | w   | ret                            |
| ------ | --- | ------------------------------ |
| window |     | 自分 framesと同様に使える      |
| self   |     | === window 別名として使える    |
| frames |     | サブフレームの配列風           |
| length |     | === frames.length              |
| opener |     | 自分を開いたウィンドウ         |
| parent |     | 自分(ウィンドウかフレーム)の親 |

## screen
| prop              | ret                              |
| ----------------- | -------------------------------- |
| availHeight/Width | 最大化したときのウィンドウサイズ |
| height/width      | スクリーンサイズ                 |

## Window
| メソッド              | -                                  |
| --------------------- | ---------------------------------- |
| alert(str)            |
| confirm(str)          | booleanを返す                      |
| prompt(str[, str])    | 第二引数は初期値                   |
| focus()               | フォーカス                         |
| blur()                | ウィンドウのフォーカスを外す       |
| open(url, windowName) | windowNameはname属性的な 詳細下部  |
| stop()                | 読み込みを停止                     |
| close()               | open()で開かれたウィンドウを閉じる |
| print()               | 印刷ダイアログ                     |

* openとclose
(opened = open(url); opened.close();)

* ウィンドウ操作
\- open()で作成されたウィンドウのみ
\- 複数のタブが開かれていないウィンドウのみ
\- scrollはElmentに同名メソッドあり

| メソッド                           | -                                          |
| ---------------------------------- | ------------------------------------------ |
| moveBy(x, y)                       | 相対移動                                   |
| moveTo(x, y)                       | 絶対移動                                   |
| resizeBy(x, y)                     | 相対リサイズ                               |
| resizeTo(x, y)                     | 絶対リサイズ                               |
| scroll(x, y)                       | 絶対移動                                   |
| scroll({option: val})              | top, left, behavior(smooth, instant, auto) |
| scrollTo(...)                      | scrollと同じ                               |
| scrollBy(x, y)                     | 相対移動                                   |
| getComputedStyle(elm[, pseudoElt]) | 計算後のcssをオブジェクトで取得[疑似要素]  |

* window.open()
\- open('URL', 'ウィンドウ名(空文字可)', 'オプション')
\- オプション(1 true, 2 false)

| key        | val  |
| ---------- | ---- |
| location   | 1/0  |
| menubar    | 1/0  |
| scrollbars | 1/0  |
| status     | 1/0  |
| toolbar    | 1/0  |
| resizable  | 1/0  |
| width      | 数値 |
| height     | 数値 |

## Location
| prop     | w   | ret                  |
| -------- | --- | -------------------- |
| href     | w   | URL 書き換えると移動 |
| hash     | w   | #以降 クエリ含む     |
| search   | w   | ?以降 クエリ         |
| hostName | w   | ドメインまで         |
| protocol | w   | http:とかhttps:とか  |
| pathname | w   | ルートからのパス     |

メソッド
  assign(url)   URL 読み込み 履歴追加
  reload()      再読み込み
  replace(url)  URL 置き換え 履歴上書き
  toString()    url全体を返す

## History
プロパティ
  length
メソッド
  back()          go(-1)と同等
  forward()       go(1)と同等
  go(num)         0もしくは引数なしの場合再読み込み
  pushState()     ブラウザに履歴を追加する
  replaceState()  ブラウザの最新の履歴に置き換える
    stateについては知りたければ学んで


## Document
| prop              | w   | ret          |                              |
| ----------------- | --- | ------------ | ---------------------------- |
| forms             |     | hc           |
| images            |     | hc           |
| links             |     | hc           |
| scrollingElement  |     | hc           | スクロール可能なelmのみ      |
| body, head        |
| location          |     |              | 理由がなければwindowの方使え |
| title             | w   | HTMLDocument |
| URL               |     | HTMLDocument |
| fullscreenElement |     |              | 全画面モードになっている要素 |

## 多分子供は知らなくていいやつ
* CharacterData テキスト系ノードのインターフェイス

| prop   | w   | ret            |
| ------ | --- | -------------- |
| data   | w   | str            |
| length |     | 文字列のサイズ |

| メソッド        | -                     |
| --------------- | --------------------- |
| appendData()    |
| deleteData()    | オフセット, 長さ      |
| insertData()    | オフセット, str       |
| replaceData()   | オフセット, 長さ, str |
| substringData() | オフセット, 長さ      |

引数わからんやった。戻り値は変更後str

* Comment
* Text
メソッド spritText(offset) 指定位置で分割
ProcessingInstruction