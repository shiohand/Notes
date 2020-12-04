/* utility */
// html用エンティティ化
function htmlentities(str) {
  const entities = [
    [/&/, '&amp;'],
    [/</, '&lt;'],
    [/>/, '&gt;'],
    [/"/, '&quot;'],
    [/'/, '&#39;'],
    [/ /, '&nbsp']
  ]
  entities.forEach(set => {
    str = str.replace(set[0], set[1]);
  });
}
// 子ノードの全削除
function removeAllChildren(node) {
  while(node.hasChildNodes) {
    node.removeChild(node.firstChild);
  }
}
// 名前空間つくる君
function namespace(ns) {
  let names = ns.split('.');
  let parent = window;
  for (let name of names) {
    parent[name] = parent[name] || {};
    parent = parent[name];
  }
  return parent;
}

/* DOM */

// 複数のクラス名を結合して文字列化する君
const makeMultiCls = (...cls) => {
  // Setを通して重複を削除し、Arrayに戻す
  const list = Array.from(new Set(cls));
  return list.join(' ');
}
/* form */
// checkedを取得(radio)
function getCheckedOne(name) {
  const list = Array.from(document.getElementsByName(name));
  return list.find(elm => elm.checked);
}
// checkedにする(radio)
function setCheckedOne(name, val) {
  const list = Array.from(document.getElementsByName(name));
  const targetElm = list.find(elm => elm.value === val);
  targetElm.checked = true;
}
// checkedを取得(checkbox)
function getChecked(name) {
  const list = Array.from(document.getElementsByName(name));
  return list.filter(elm => elm.checked);
}
// checkedにする(checkbox)
function setChecked(name, ...vals) {
  const list = Array.from(document.getElementsByName(name));
  const targetElms = list.filter(elm => elm.value in vals);
  targetElms.forEach(elm => elm.checked = true );
}
// 全てのcheckedを変更する
function allChecked(name, bool = true) {
  const list = Array.from(document.getElementsByName(name));
  list.forEach(elm => elm.checked = bool);
}
// selectedを取得(select)
function getSelectedOne(name) {
  const opts = Array.from(document.getElementsByName(name).options);
  return opts.find(elm => elm.selected);
}
// selectedにする(select)
function setSelectedOne(name, val) {
  const opts = Array.from(document.getElementsByName(name).options);
  const targetOpts = opts.find(elm => elm.value === val);
  targetOpts.checked = true;
}
// selectedを取得(select multiple)
function getSelected(name) {
  const opts = Array.from(document.getElementsByName(name).options);
  return opts.filter(elm => elm.selected);
}
// selectedにする(select multiple)
function setSelected(name, ...vals) {
  const opts = Array.from(document.getElementsByName(name).options);
  const targetOpts = opts.filter(elm => elm.value in vals);
  targetOpts.forEach(elm => elm.selected = true );
}
// 全てのselectedを変更する
function allSelected(name, bool = true) {
  const list = Array.from(document.getElementsByName(name).options);
  list.forEach(elm => elm.selected = bool);
}

/* エイリアス */
const byId = (id) => {
  return document.getElementById(id);
};
const byName = (name) => {
  return document.getElementByName(name);
};
const byTag = (tagname, base = document) => {
  return base.getElementByTagName(tagname);
};
const byClass = (classnames, base = document) => {
  return base.getElementByClassName(classnames);
};
const qs = (selector, base = document) => {
  return base.querySelector(selector);
};
const qsa = (selector, base = document) => {
  return base.querySelectorAll(selector);
};
const addEL = (elm, type, listener, option = null) => {
  if ('addEventListener' in elm)
  return elm.addEventListener(type, listener, option);
};
const addCls = function(...cls) {
  this.classList.add(...cls);
};
const removeCls = function(...cls) {
  this.classList.remove(...cls);
};
const toggleCls = function(cls) {
  this.classList.toggle(cls);
};
const replaceCls = function(oldCls, newCls) {
  this.classList.replace(oldCls, newCls);
};
// 利用例
addEL(byId('target'), 'click', toggleCls('hide'));
// 利用例を素で書くと
document.getElementById('target').addEventListener('click', function() {
  this.classList.toggle('hide');
});