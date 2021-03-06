# ListCls

- [List](#list)
  - [ArrayList](#arraylist)
  - [LinkedList](#linkedlist)
- [Set](#set)
  - [HashSet](#hashset)
  - [LinkedHashSet](#linkedhashset)
  - [TreeSet](#treeset)
- [Map](#map)
  - [HashMap](#hashmap)
  - [IdentityHashMap WeakHashMap](#identityhashmap-weakhashmap)
  - [LinkedHashMap](#linkedhashmap)
  - [TreeMap](#treemap)
- [スタック キュー](#スタック-キュー)
  - [ArrayDeque](#arraydeque)
  - [LinkedList](#linkedlist-1)

## List

### ArrayList

  配列を利用

* メリット
  * インデックス値による値の読み書き(ランダムアクセス)性能 高

* デメリット
  * 値の頻繁な挿入・削除(特に先頭のほう)
  \- 変更のあった要素の後ろを移動させなければならないため
  * 挿入時、メモリの再割り当てが発生する可能性
  \- 要素数が想定できる場合はインスタンス化の際に宣言しておくとよい

/* ArrayListの基本メソッド */

get(idx)                  obj
size()                    int

add([idx, ]obj)           void
addAll([idx, ]Collection) boolean
set(idx, obj)             obj
remove(idx)               boolean
remove(obj)               boolean
remove(Collection)        boolean
removeRange(from, to)
retainAll(Collection)     boolean 同じ要素だけ残す
clear()

contains(obj)
containsAll(Collection)
indexOf(obj)
lastIndexOf(obj)
isEmpty()

clone()
sort(Comparator)
toArray()
trimToSize()      現在のサイズに縮小


### LinkedList

  双方向リンク

* メリット
  * 要素の挿入・削除が高速 ただし要素の検索のオーバヘッドは必要であることを考慮
  \- 位置から順番にアクセスして要素を利用するような用途に優れる
* デメリット
  * 中央に近い要素ほどアクセスが遅くなる

/* LinkedListのメソッド */
  ArrayListで挙げたものに加えて――
getFirst() obj
getLast()  obj
addFirst(obj)
addLast(obj)
removeFirst()
removeLast()

## Set

### HashSet

size()
add(obj)           void
remove(obj)               boolean
clear()

contains(obj)
containsAll(Collection)
indexOf(obj)
lastIndexOf(obj)
isEmpty()

clone()

isEmpty()
addAll(Collection)    和集合
removeAll(Collection) 差集合
retainAll(Collection) 積集合

sort(Comparator)
toArray()
trimToSize()      現在のサイズに縮小

### LinkedHashSet

### TreeSet

// HashSetのに加えて――
ceiling(obj)  指定要素以上の中の最小
heigher(obj)  指定要素より大きい中の最小
floor(obj)    指定要素以下の中の最大
lower(obj)    指定要素未満中の最大
first()
last()
// サブセット
NavigableSet<E> headSet(obj[, boolean])  指定要素未満(trueで以下)
SortedSet<E> subSet(fromObj, toObj)      指定要素の内側(二つが等しいときは空)
SortedSet<E> tailSet(fromObj[, boolean]) 指定要素以上(falseでより大きい)
NavigableSet<E> descendingSet()          逆順に並べ替え

## Map
  内部的にハッシュ表と呼ばれる配列を持ち、キーのハッシュ値を算出して該当する場所に保存
  重複の判断は同値性(equals)

  ハッシュ値が重複した場合は、リンクリストや二分木で管理する らしい
  オブジェクト同士が等しいものはハッシュ値も等しい
  ハッシュ値が等しくてもオブジェクト同士が等しいとは限らない

/* hashCodeメソッドの実装 */
自作クラスをキーとして利用する場合はhashCodeメソッドのオーバーライドが必要
  同じ値のオブジェクトは同じハッシュ値を返すこと
  重複が発生しにくいよう、適切に分布していること
重複が発生すればするほどキー検索の効率が低下する

/* ハッシュ表のサイズを適切に設定 */
サイズを超えると再割当てが必要になる
想定される要素数より十分に大きくなければ重複の可能性が高まる

### HashMap

/* コンストラクタ */
HashMap([int 初期容量[,float 負荷係数]])
  デフォルト値 初期容量16 負荷係数0.75f
    要素数が16*0.75=12を超えるとハッシュ表の再割当てが発生 既定でよい
  例: var data = new HashMap<String, String>(30, 0.8F);

/* メソッド */
get(key)
getOrDefault(key, val)  指定のキーの値を取得(キーがなければval？)
size()
entrySet()  Set<Map.Entry<K,V>>で全要素を取得
keySet()    Set<K>
values()    Collection<V>

put(key, value)
putIfAbsent(key, value)  指定のキーがなければ追加
remove(key[, value])     削除 keyだけで十分
clear()

containsKey(key)
containsValue(value)
isEmpty()

clone()
replace(key, value)
replace(key, oldValue, newValue)


### IdentityHashMap WeakHashMap

  HashMapの亜形 キーの管理方法が異なる

IdentityHashMap
  キーを同一性(==)で比較
  二つの変数に同じ値を入れても、別と判断される
WeakHashMap
  キーを弱参照で管理
    キーを参照しているのがマップ本体だけになると消える

### LinkedHashMap

  順序付けルールを選べる

/* コンストラクタ */
HashMap([int 初期容量[,float 負荷係数[, boolean 順序付けルール]]])
  第三引数の初期値はfalseで挿入順 trueでアクセス順(アクセスしたものが最後にくる)

### TreeMap

  キーの順序を管理できる Red-Blackツリーで管理
  格納順がどうであれ、取り出すときは自然順序

  自然順序はMap生成時にラムダ式で設定可能
  var data = new TreeMap<String, String>(
    (x, y) -> x.length() - y.length()     // lengthの短い順 x-yが負数ならxが小さい 正数なら大きい
  );

  ちな匿名クラス
  var data = new TreeMap<String, String>(
    new Comparator<String>() {
      @Override
      public int compare(String x, String y) {
        return x.length() - y.length();
      }
    }
  );

/* NabigableMapを実装している */

ceilingEntry(key)  指定要素以上の中の最小
ceilingKey(key)  指定要素以上の中の最小
heigherEntry(key)  指定要素より大きい中の最小
heigherKey(key)  指定要素より大きい中の最小
floorEntry(key)    指定要素以下の中の最大
floorKey(key)    指定要素以下の中の最大
lowerEntry(key)    指定要素未満中の最大
lowerKey(key)    指定要素未満中の最大
headMap(key[, boolean])  指定要素未満(trueで以下)
tailMap(Key[, boolean]) 指定要素以上(falseでより大きい)

// 例
if(list.containsKey(searchKey)) {
  System.out.println(searchKey + "の値は" + list.get(searchKey) + "です。");
} else {
  System.out.ptinln(searchKey + "はありません");
  System.out.ptinln("もしかして" + list.lowerKey(searchKey) + ", " +  + list.heigherKey(searchKey));
}

## スタック キュー

### ArrayDeque

  循環配列
  配列の先頭と末尾の判定を適宜移動していくことで端をなくす両端キュー

/* メソッド */

// 失敗時 例外
addFirst(obj)
addLast(obj)
removeFirst()
removeLast()
getFirst()
getLast()

// 失敗時 falseかnull
offerFirst(obj) 追加
offerLast(obj)
pollFirst()     削除(取得もする)
pollLast()
peekFirst()     取得
peekLast()

### LinkedList

Listのと一緒