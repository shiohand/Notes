# プロパティ


## Element

(e)HTMLElement (dataset)HTMLOrForeignElement
(w)obj.prop, obj['prop']などで取得した要素に対しての書き込み可
| e   | prop               |   w   | -                                         |
| --- | ------------------ | :---: | ----------------------------------------- |
|     | id                 |   w   |
|     | className          |   w   | リスト(空白区切り)                        |
|     | classList          |       | DOMTokenList                              |
|     | tagName            |
|     | attributes         |  (w)  | NamedNodeMap                              |
| e   | dataset            |  (w)  | in演算子、delete演算子使える              |
|     | outerHTML          |   w   | 要素自身を含む                            |
|     | innerHTML          |   w   |
| e   | innerText          |   w   | Node.textContent と HTMLElement.innerText |
| e   | style              |  (w)  | CSSStyleDeclaration                       |
| e   | tabIndex           |   w   | tabキーによる移動の順序                   |
| e   | title              |   w   |
|     | clientHeight/Width |       | padding含む                               |
|     | clientTop/Left     |       | padding含まず                             |
|     | scrollHeight/Width |       | padding含む                               |
|     | scrollTop/Left     |   w   | スクロール量                              |
|     | offsetHeight       |       | border含む                                |
| e   | offsetWeight       |
| e   | offsetTop          |
| e   | offsetLeft         |
| e   | offsetParent       |       | 位置に影響を与える親要素※                 |

※position:staticでないもの
※table内ではtdなど

### datasetとstyle

| prop    | -                                                      |
| ------- | ------------------------------------------------------ |
|         | HTMLではダッシュスタイル、プロパティではキャメルケース |
| dataset | data-*で指定するやつ                                   |
| style   | floatはcssFloat                                        |

### HTMLImageElement

| prop     | ret  | -                        |
| -------- | ---- | ------------------------ |
| complete | bool | 読み込みが完了しているか |

### HTMLScriptElement

| prop | w   | -   |
| ---- | --- | --- |
| type | w   | str |
| src  | w   | str |

### HTMLTitleElement

| prop | w   | -   |
| ---- | --- | --- |
| text | w   | str |

### HTMLStyleElement
floatはcssFloatらしいよ

### HTMLTableElement

| prop    | -                  |
| ------- | ------------------ |
| caption |
| tHead   |
| tBodies |
| tFoot   |
| rows    | 行のHTMLCollection |

## メソッド
### Element
* insertAdjacentElement(pos, elm)
\- beforebegin, beforeend, afterbegin, afterend
* insertAdjacentHTML(pos, str)
* insertAdjacentText(pos, str)
* 
### attr
| メソッド                      | -                       |
| ----------------------------- | ----------------------- |
| hasAttribute(attr)            | attr指定                |
| hasAttributes()               | 指定なし                |
| setAttribute(attr, val)       | nullは入れんで          |
| toggleAttribute(attr[, bool]) | 設定、切り替え          |
| getAttribute(attr)            | datasetは'data-*'のまま |
| getAttributeNames()           | array                   |
| removeAttribute(attr)         |                         |

* attributeの値について
\- elm.attr.valueは現在の値
\- elm.getAttribute('attr')は初期値
\- elm.attr = 'val'; も可能 存在しない属性は追加できない
\- elm.getAttribute('attr')は文字列以外はうまく返せない

### scroll Windowに同名メソッドあり
| メソッド              |
| --------------------- |
| scroll(x, y)          |
| scroll({option: val}) |
| scrollTo(...)         |
| scrollBy(x, y)        |

### HTMLElement
| メソッド | -                      |
| -------- | ---------------------- |
| click()  | クリックイベントを送信 |
### HTMLOrForeignElement
| メソッド | -                  |
| -------- | ------------------ |
| blur()   | フォーカスを外す   |
| focus()  | フォーカスを付ける |

### HTMLTableElement
| メソッド                          | -                |
| --------------------------------- | ---------------- |
| createCaption/THead/TBody/TFoot() | 追加して戻り値に |
| deleteCaption/THead/TFoot()       | 戻り値なし       |
| insertRow(i)                      | 指定trの次に追加 |
| deleteRow(i)                      | 指定trを削除     |