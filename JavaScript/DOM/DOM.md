# DOM(Document Object Model)

- [オブジェクトのツリー構造(一般的なブラウザ)](#オブジェクトのツリー構造一般的なブラウザ)
- [ドキュメントツリー](#ドキュメントツリー)
- [scriptを先頭に置く場合のテンプレ](#scriptを先頭に置く場合のテンプレ)

## オブジェクトのツリー構造(一般的なブラウザ)
* Window
  * Console
  * Document
    * Form
      * Text
      * Textarea
      * Checkbox
      * Radio
      * Select
      * Reset
      * Button
      * FileUpload
      * Hidden
      * Password
    * Image
    * Anchor
    * Area
    * Layer
    * Link
    * Applet
  * Frame
  * History
  * Location
  * Navigator
    * Mimetype
    * Plugin
  * Storage
  * XMLHttpRequest, FileReader, Worker
* Event
* Style

## ドキュメントツリー

```html
<body>
  <h1>
    Javascript本格入門
  </h1>
  <p id="greet">
    これが
    <strong>
      文書ツリー
    </strong>
    です
  </p>
</body>
```
| -                          | -                                         |
| -------------------------- | ----------------------------------------- |
| 要素(element)ノード        | body h1 p strong                          |
| 属性(attribute)ノード      | id="greet"                                |
| テキスト(text)ノード       | Javascript本格入門 これが 文書ツリー です |
| 祖先 親 兄弟 子 子孫ノード | 分かれ                                    |

## scriptを先頭に置く場合のテンプレ
```js
document.addEventListener("DOMContentLoaded", function(){
  // DOM利用可能になった場合の処理
});
```
```js
window.addEventListener("load", function(){
  // コンテンツが読み込み完了後の処理
});
```