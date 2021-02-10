# Form

- [HTMLFormElement](#htmlformelement)
- [HTMLLabelElement](#htmllabelelement)
- [コントロール共通](#コントロール共通)
  - [親フォームに対して](#親フォームに対して)
  - [以下はOption以外の要素](#以下はoption以外の要素)
- [HTMLButtonElement](#htmlbuttonelement)
- [HTMLSelectElement](#htmlselectelement)
- [HTMLOptionElement](#htmloptionelement)
- [HTMLInputElement](#htmlinputelement)
- [HTMLTextAreaElement](#htmltextareaelement)
- [Input, TextAreaメソッド](#input-textareaメソッド)

## HTMLFormElement
| prop     | ret | -                        |
| -------- | --- | ------------------------ |
| length   |     | コントロール数           |
| name     |     |
| action   |     |
| enctype  |     |
| encoding |     |
| method   |     |
| target   |     |
| elements | hc  | フォーム内のコントロール |

| メソッド |
| -------- |
| submit() |
| reset()  |

## HTMLLabelElement
| prop    | -               |
| ------- | --------------- |
| control | labelの適用要素 |

## コントロール共通
### 親フォームに対して
| prop         | w   | ret                 | -   |
| ------------ | --- | ------------------- | --- |
| form         |     | HTMLFormElement     |
| formAction他 | w   | Enctype, Methodなど |

### 以下はOption以外の要素
| prop      | w   | ret           | -                   |
| --------- | --- | ------------- | ------------------- |
| name      | w   |
| type      | w   |
| disabled  | w   | bool          |
| autofocus | w   | bool          |
| value     | w   |
| validity  |     | ValidityState | valid, badInputなど |
| required  | w   | bool          | Button除く          |


| メソッド        | ret  | -                               |
| --------------- | ---- | ------------------------------- |
| checkValidity() | bool | Option, Label, Button:reset除く |

## HTMLButtonElement
| prop   | ret |
| ------ | --- |
| labels | nl  |

## HTMLSelectElement
| prop            | w   | ret                   |
| --------------- | --- | --------------------- |
| labels          |     | nl                    |
| length          |     | optionの数            |
| multiple        | w   | bool                  |
| options         |     | HTMLOptionsCollection |
| selectedIndex   |     |
| selectedOptions |     |

| メソッド            | -                                             |
| ------------------- | --------------------------------------------- |
| add(n[, index])     | optionを末尾に追加  indexを指定すればその直前 |
| remove(index)       | 削除                                          |
| item(), namedItem() | HTMLCollectionの感じ                          |

## HTMLOptionElement
| prop     | w   | ret  |
| -------- | --- | ---- |
| disabled | w   | bool |
| value    | w   |
| label    | w   | elm  |
| selected | w   | bool |
| text     | w   |

## HTMLInputElement
## HTMLTextAreaElement
| prop            | w   | ret           |
| --------------- | --- | ------------- |
| checkbox, radio | -   | -             |
| checked         | w   | bool          |
| defaultChecked  | w   | bool          |
| indeterminate   | w   | bool 不定状態 |

| text, number, textarea | -   | -            |
| ---------------------- | --- | ------------ |
| placeholder            | w   |
| max/minLength          | w   |
| readOnly               | w   | bool         |
| autocomplete           | w   | textarea除く |
| max/min                | w   | textarea除く |
| size                   | w   | textarea除く |
| rows/cols              | w   | textareaのみ |

| image        | -   | -   |
| ------------ | --- | --- |
| alt          | w   | str |
| height/width | w   | str |
| src          | w   | str |

| file   | -   | -                    |
| ------ | --- | -------------------- |
| accept | w   | str                  |
| files  | w   | FileListオブジェクト |

| text, password, textarea |     | 他search, tel, url, week, month  |
| ------------------------ | --- | -------------------------------- |
| selectionStart           | w   | 選択始点、カーソル位置           |
| selectionEnd             | w   | 選択終点、カーソル位置           |
| selectionDirection       | w   | 選択方向 forward, backward, none |
   

## Input, TextAreaメソッド
| メソッド                                    | -          |
| ------------------------------------------- | ---------- |
| select()                                    | 選択状態に |
| setSelectionRange(start, end[, direction])  | 任意範囲   |
| setRangeText(文字列)                        | 置換       |
| setRangeText(文字列,start, end[, 選択状態]) | 範囲置換   |