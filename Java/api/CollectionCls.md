# コレクションクラス

- [コレクションクラス](#コレクションクラス)
- [基本の使い方](#基本の使い方)
  - [インスタンス生成](#インスタンス生成)
  - [匿名クラスと初期化ブロックを利用した初期化](#匿名クラスと初期化ブロックを利用した初期化)
  - [配列 -> リスト](#配列---リスト)
  - [リスト -> 配列](#リスト---配列)
  - [拡張forで使う](#拡張forで使う)
  - [ListIteratorオブジェクト](#listiteratorオブジェクト)
- [特殊なコレクションの生成](#特殊なコレクションの生成)
  - [変更不能コレクション](#変更不能コレクション)
  - [変更不能コレクションの生成](#変更不能コレクションの生成)
- [空コレクション](#空コレクション)
- [singleton](#singleton)
- [スレッドセーフ](#スレッドセーフ)

## コレクションクラス

イテラブル 拡張for文が可能
Mapはコレクションインターフェースを継承していない

List|-
-|-
  ArrayList      |可変長配列
  LinkedList     |リンク構造

Set|-
-|-
  HashSet        |任意順
  LinkedHashSet  |追加順
  TreeSet        |キー順

Map|-
-|-
  HashMap        | 普通マップ
  TreeMap        | キーによる並べ替え可能マップ

Queue(Deque)|-
-|-
  ArrayDeque     | 両端キュー
  LinkedList     | リンク構造

## 基本の使い方

### インスタンス生成

* 利便性のためインターフェース型で受けることが多い
* そのため、意図がなければvarは使わない
* 右辺の要素の型は左辺から推測できるので省略可能

```java
List<String> list = new ArrayList<>();
Map<String, Integer> map = new HashMap<>();
```

### 匿名クラスと初期化ブロックを利用した初期化 

```java
var data = new ArrayList<String>() { // 匿名クラス
  {                                  // 初期化ブロック
    add("val1");
    add("val2");
    add("val3");
  }
}
```

### 配列 -> リスト

* Arrays.asList(arr)
\- 配列をリストとして扱えるように(固定長なのは変わらず、要素の追加削除はできない)
\- `new ArrayList<>()`の引数に入れると、今度こそリストになる
* Collections.addAll(list, arr)
\- listにarrの要素を複製する(配列の縛りはなくなる)

```java
var data = new String[] {"val1", "val2", "val3"};
var byAsList = Arrays.asList(data);
var byNew = new ArrayList<String>(Arrays.asList(data));

var list = new ArrayList<String>();
Colections.addAll(list, data);
```

### リスト -> 配列

* toArray([arr])
\- arrにlistの要素を設定(はみ出す場合は自動で配列が生成される)
\- arrは省略可能 その場合戻り値はObject[]

```java
var list = new ArrayList<String>(Arrays.asList("val1", "val2", "val3"));
var data = new String[data.size()]; // 同じサイズで作っておく
list.toarray(data);
```

### 拡張forで使う

```java
for (var s : list) {
  System.out.println(s);
}
```
要素を変更したい場合はfilterやmapメソッド

### ListIteratorオブジェクト
* コレクション.listIterator(イテレータの初期位置)
\- リストを逆順に読み込む

```java
var ite = list.listIterator(list.size()); // list.size() 末尾
while (ite.hasPrevious()) {               // hasPrevious() hasNext()の逆
  System.out.println(ite.previous());     // previous()    next()の逆
}
```

## 特殊なコレクションの生成

### 変更不能コレクション

* メソッドに引き渡したコレクションが勝手に書き換えられるなどのミスを防ぐ
* set()などで変更しようとされるとUnsupportedOperationException

### 変更不能コレクションの生成

* コレクションクラス.of(要素...)
\- List.ofやらMap.ofやら

```java
var list = List.of("val1", "val2", "val3");
var list = Map.of("val1", "one",  "val2", "two", "val3", "three");
```

* 通常のコレクションを変更不能に変換
```
Collections.
  unmodifiableCollection(list)  変更不能状態のリストを返す
  unmodifiableList(list)
  unmodifiableSet(list)
  unmodifiableSortedSet(list)
  unmodifiableMap(list)
  unmodifiableSortedMap(list)
```

* 参照型(Stringのような不変は除く)の場合、要素の参照の直接編集はできる

```java
var list = new ArrayList<StringBuilder>(Arrays.asList(
  new StringBuilder("val1"),
  new StringBuilder("val2"),
  new StringBuilder("val3")
));
var ulist = Collections.unmodifiableList(list);
ulist.get(0).append(" val4"); // 一つ目のStringBuilderが"val1 val4"に
```

## 空コレクション

* 戻り値をコレクションにしているメソッドで、返すべき要素が一つもなかった場合にnullが返ると困るので使う

```
Collections.
  emptyList()
  emptySet()
  emptyMap()
```

## singleton

* 単一の値を持つコレクション (変更不能)

```
Collection.
  singleton(値)      Setとして
  singletonList(値)  Setとして
  singletonMap(値)   Setとして
```

## スレッドセーフ

* 同期化コレクション
```
Collections.
  synchronizedCollection(list)
  synchronizedList(list)
  synchronizedSet(list)
  synchronizedMap(list)
```

* 並列コレクションクラス
```
java.util.concurrentパッケージ
  CopyOnWriteArrayList
  CopyOnWriteArraySet
  ConcurrentHashMap     など
```
