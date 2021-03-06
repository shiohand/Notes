# Consoleオブジェクト

- [出力いろいろ](#出力いろいろ)
- [ログのグループ化](#ログのグループ化)
  - [テスト用に](#テスト用に)

## 出力いろいろ

| -          | -       |
| ---------- | ------- |
| log(str)   | ログ    |
| info(str)  | info    |
| warn(str)  | warning |
| error(str) | error   |

* (str)は(format, ...args)も可能
| 書式指定子 | -            |
| ---------- | ------------ |
| %s         |
| %d, $i     | 桁数　→%.2d  |
| %f         | 小数桁→%.2f  |
| %o, %o     | オブジェクト |

* dir(obj)
\- プロパティを対話型リストで表示
\- 要素ノードで便利 (logだとただのHTML文字列)

trace()      現在地のスタックトレース
assert(exp, message)  falseならメッセージとスタックトレースを出力

## ログのグループ化

| -                     | -                            |
| --------------------- | ---------------------------- |
| group(label)          | グループ開始                 |
| groupCollapsed(label) | グループ開始(初期フォールド) |
| groupEnd()            | グループ終了 出力            |
```js
  console.group('グループ');
  // log

    console.group('入れ子１');
    // log
    console.groupEnd(); // 入れ子１終了

    console.groupCollapsed('入れ子２');
    // log
    console.groupEnd(); // 入れ子２終了

  console.groupEnd(); // グループ終了
```

### テスト用に

| -               | -                           |
| --------------- | --------------------------- |
| timer(label)    | タイマー開始                |
| timerEnd(label) | 非標準 タイマー終了 出力    |
| count([label])  | 非標準 実行された回数を出力 |

ラベルなくてもいいが、場所が違うと別物扱いになる
```js
  console.count('LAB');
  console.count('LAB');
  console.count();
  for (let i = 0; i < 2; i++) {
    console.count('LAB');
    console.count();
  }
  console.count('LAB');
  console.count();
  // 結果
  // LAB: 1
  // LAB: 2
  //  : 1
  // LAB: 3
  //  : 1
  // LAB: 4
  //  : 2
  // LAB: 5
  //  : 1
```