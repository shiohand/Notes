# Node-NL-HC-他

- [Node](#node)
  - [ParentNode](#parentnode)
- [Array-like](#array-like)
  - [共通](#共通)
  - [NodeList](#nodelist)
  - [HTMLCollection](#htmlcollection)
  - [DOMTokenList](#domtokenlist)
  - [NamedNodeMap](#namednodemap)
  - [HTMLOptionCollection](#htmloptioncollection)

## Node

| prop        | w   | ret                                       |
| ----------- | --- | ----------------------------------------- |
| nodeName    | w   | タグ名とか#textとか                       |
| nodeType    | w   | ノードの型                                |
| nodeValue   | w   | textやcommentの内容                       |
| textContent | w   | Node.textContent と HTMLElement.innerText |

| メソッド        | ret  | -                                        |
| --------------- | ---- | ---------------------------------------- |
| hasChildNodes() | bool | 子ノードがあるか                         |
| contains(n)     | bool | 子孫にnが含まれるか                      |
| isEqualNode(n)  | bool | nとの同値性                              |
| normalize()     |      | 空ノード削除、隣接テキストノード合体など |

### ParentNode
Element, Document, DocumentFragment
| prop              | ret |
| ----------------- | --- |
| childElementCount | 値  |

ChildNode　(実験段階)
NonDocumentTypeChildNode
  実装先　Element, CharacterData


## Array-like

### 共通

* list[i] で指定可能
* 直接要素を代入とかはできない
* 必要ならArray.from()
\- メソッドチェーンしやすい 静的にしたほうが処理早い
\- ByTagNameやByNameのブラウザ差をなくせる

* プロパティ
\- length
* メソッド
\- item(i)       list[i]でいい
* NodeList, DOMTokenList
\- forEach(call)	values()なども

### NodeList
Node取得メソッドではしばしば生きてるが基本静的。

### HTMLCollection
HTMLElementの動的なリスト

* hc.id, hc[id] で取得可能 (idが見つからなかったらnameを探す)
* メソッド
  namedItem(id) hc[id]でいい

### DOMTokenList
だいたいclassList(他はrelList, sandbox, htmlForなど)

* プロパティ
\- value
* メソッド
\- contains(cls)       bool
\- add/remove(...cls)
\- replace(old, new)
\- toggle(cls)

### NamedNodeMap
attrのやつ

### HTMLOptionCollection
HTMLCollectionを継承