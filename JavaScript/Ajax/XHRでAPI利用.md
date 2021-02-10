# XHRでAPI利用

HTML
resultにリストを作りたい
```html
<form>
  <label for="url">URL:<input id="url" type="text" name="url" size="50" value="http://www.wings.msn.to/"></label>
  <button id="btn" type="button">検索</button>
</form>
<div id="result"></div>
```

PHP
文字コード、json設定、stream_context_create()でget
```php
// 出力文字コード
mb_http_output('UTF-8');
// 内部文字コード
mb_internal_encoding('UTF-8');

// コンテンツタイプ
header('Content-Type: application/json;charset=UTF-8');

// はてブAPIへのリクエストURL (クエリ部分は無効の都合)
$url = 'http://b.hatena.ne.jp/entry/jsonlite/?url='.$_GET['url'];

// リクエスト(contextは向こうの都合)と取得
$result = file_get_contents($url, false, stream_context_create(
  ['http' => ['header' => 'User-Agent: MySample']]
));

// 出力
print $result;
```

JS
```js
document.getElementById('btn').addEventListener('click', () => {
  const result = document.getElementById('result');

  const xhr = new XMLHttpRequest();
  
  xhr.addEventListener('loadstart', () => {
    result.textContent = '通信中...';
  });
  xhr.addEventListener('load', () => {
    const data = JSON.parse(xhr.responseText);
    if (data === null) {
      result.textContent('ブックマークは存在しませんでした。');
    } else {
      const bms = data.bookmarks;
      const ul = document.createElement('ul');
      bms.forEach( record => {
        const li = document.createElement('li');
        const anchor = document.createElement('a');
        anchor.href = 'https://b.hatena.ne.jp/' + record.user;
        const text = document.createTextNode(record.user + ' : ' + record.comment);
        anchor.appendChild(text);
        li.appendChild(anchor);
        ul.appendChild(li);
      });
      result.replaceChild(ul, result.firstChild);
    }
  });
  xhr.addEventListener('error', () => {
    result.textContent = 'サーバーエラーが発生しました。';
  });

  xhr.open('GET', 'bm_do.php?url=' + encodeURIComponent(document.getElementById('url').value));
  xhr.send(null);
});
```
