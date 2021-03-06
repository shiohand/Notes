# Storageオブジェクト

- [Storageオブジェクト](#storageオブジェクト)
- [StrageEvent](#strageevent)
- [基本操作](#基本操作)
- [オブジェクトをJSON形式で代入、取得](#オブジェクトをjson形式で代入取得)
- [Storage操作のためのクラスを使う方法](#storage操作のためのクラスを使う方法)
- [イベント](#イベント)

## Storageオブジェクト

* ブラウザ内蔵のキーバリュー型データストア(５M)
* 期限なし 通信なし
* データは文字列 オブジェクトはJSONにするとよい
* デベロッパーツールで見られるやつだな

* localStorage
\- オリジン単位 消すまで消えない(なので普通はsessionStrge)
\- (オリジン: スキーマ://ホスト名:ポート番号 でひとつ)
* sessionStorage
\- セッション単位 ブラウザが終了したら削除

| prop   | -                |
| ------ | ---------------- |
| length | データアイテム数 |

| メソッド          | -              |
| ----------------- | -------------- |
| key(num)          | キーの名称     |
| getItem(キー)     | キーに対する値 |
| setItem(キー, 値) |
| removeItem(キー)  |
| clear()           | 全消去         |

## StrageEvent
strageに変更があったとき
| prop        | ret          |
| ----------- | ------------ |
| key         | str          |
| newValue    | str          |
| oldValue    | str          |
| storageArea | オブジェクト |
| url         |


## 基本操作
```js
  const lStrg = localStorage;
  const strg = sessionStorage;
  // set
  strg.setItem('key1', 'val1');
  strg.key2 = 'val2';
  strg['key3'] = 'val3';
  // get
  strg.getItem('key1');
  strg.key2;
  strg['key3'];
  // delete
  strg.removeItem('key1');
  delete strg.key2;
  delete strg['key3'];
  // 全消去
  strg.clear();
```

## オブジェクトをJSON形式で代入、取得
```js
  const obj = { id: '1', name: 'namae'};
  // JSONにしてset
  strg.obj = JSON.stringify(obj);
  // getして復元
  let data = JSON.parse(strg.obj);
```

## Storage操作のためのクラスを使う方法
キー名の衝突リスク回避(ローカルストレージ利用で特に)
```js
  // クラスベース
  let MystorageC = class {
    constructor(app) {
      this.app = app;
      this.storage = localStorage;
      this.data = JSON.parse(this.storage[this.app] || {});
    }
    getItem(key) {
      return this.data[key];
    }
    setItem(key, value) {
      this.data[key] = value;
    }
    save() {
      this.storage[this.app] = JSON.stringify(this.data);
    }
  }
  // 利用
  const storage = new MystorageC('アプリ名');
  storage.setItem('key1', 'val1');
  console.log(storage.getItem('key1'));
  storage.save();
```

## イベント
別のウィンドウでストレージが変更されたときにログを出力する例
```js
  window.addEventListener('storage', (e) => {
    console.log('変更されたキー：' + e.key);
    console.log('変更前の値：' + e.oldvalue);
    console.log('変更後の値：' + e.newValue);
    console.log('発生元ページ：' + e.url);
    console.log('ストレージオブジェクト：' + e.storageArea);
  });
```