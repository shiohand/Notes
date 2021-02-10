# JavaScript と JSON の記述の違い

javascript
{
  title: 'title',
  price: 2000
};

JSON
二重引用符
{
  "title": "title",
  "price": 2000
}

jsonObj = JSON.parse(text[, reviver])
jsObj = JSON.stringify(value[, replicer[, space]])
  undefinedはnullとかなるので注意