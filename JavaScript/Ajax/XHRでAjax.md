# XHRでAjax

HTML
resultにレスポンスを表示させたい

```html
<form>
  <label for="name">名前<input id="name" type="text" name="name"></label>
  <button id="btn" type="button" name="submit">送信</button>
</form>
<p id="result"></p>
```

PHP
GETで受け取った文字列を代入した文字列を表示する
```php
echo "こんにちは{$_GET['name']}さん";
```

JS
inputの文字列をクエリで渡す
返ってきたデータをresult.textContentに代入する
```js
document.getElementById('btn').addEventListener('click', function() {

  const result = document.getElementById('result');
  const name = document.getElementById('name').value;

  // XMLHttpRequestオブジェクト
  const xhr = new XMLHttpRequest();

  // 通信中・完了・失敗など状態が変化するたびに実行するイベント
  xhr.onreadystatechange = function() {
    // statechange
    if (xhr.readyState === 4) {
      // 通信完了
      if (xhr.status === 200) {
        // ステータス200 通信成功
        // レスポンスをresponseTextでテキストとして取得
        result.textContent = xhr.responseText;
      } else {
        // 通信失敗
        result.textContent = 'サーバーエラーが発生しました。';
      }
    } else {
      // 通信中
      result.textContent = '通信中...';
    }
  };

  // サーバーとの非同期通信を開始
  // open() リクエスト初期化
  xhr.open(
    'GET',
    `hello_ajax_do.php?name=${encodeURIComponent(name)}`,
    true
  );
  // send() リクエスト送信
  xhr.send(null);

});
```

読みにくいonreadystatechangeの代わりに
それぞれの状態のイベントを設定できる
```js
  xhr.addEventListener('loadstart', () => {
    result.textContent = '通信中...';
  });
  xhr.addEventListener('load', () => {
    result.textContent = xhr.responseText;
  });
  xhr.addEventListener('error', () => {
    result.textContent = 'サーバーエラーが発生しました。';
  });
```

ページごとPOSTで送っちゃえというとき
```js
  xhr.open('POST', 'hello_ajax.php');
  xhr.setRequestHeader(
    'content-type',
    'application/x-www-form-urlencoded;charset=UTF-8'
  );
  xhr.send(`name=${encodeURIComponent(name)}`);
```