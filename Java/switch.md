# switch

- [switch文(従来の構文)](#switch文従来の構文)
- [switch新構文](#switch新構文)
  - [アロー演算子 break省略](#アロー演算子-break省略)
  - [switch式](#switch式)

## switch文(従来の構文)

アロー演算子の利用やswitch式については別ファイル

```java
switch(定数) {
  case 値1:
    break;
  case 値2: case 値3:
    break;
  default:
    break;
}
```

* Enum型を定数とした場合その型の持つ列挙子を網羅する必要がある
* 逆に、defaultは必要ない

```java
enum Seasons {
  SPRING,
  SUMMER,
  AUTUMN,
  WINTER
}
var a = Seasons.SUMMER;
switch(a) {
  case SPRING: // Seaons.SPRINGじゃなくていいよ
    break;
  case SUMMER:
    break;
  case AUTUMN:
    break;
  case WINTER:
    break;
}
```

## switch新構文
* Java12から Java14から正式な機能に
* カンマで列挙可能に
* 処理を共通させる目的でのフォールスルー解消

```java
switch(定数) {
  case 値1, 値2, 値3:
    // 処理;
    break;
  case 値4, 値5:
    // 処理;
    break;
  default:
    // 処理;
    break;
}
```

### アロー演算子 break省略
* ブロック{}後ろはセミコロンいらんみたいですよ
* ラベルっぽい方とアロー演算子の方は混在できない

```java
switch(定数) {
  case 値1, 値2, 値3 -> 処理;
  case 値4, 値5 -> 処理;
  case 値6, 値7 -> {
    // 処理;
  }
  default -> 処理;
}
```

### switch式
* breakでの脱出は変わらず不可能
* Enum型以外ではdefaultが必須になった
* 式として値を返せるようになりました
* 例外もthrowできたり
* ブロックを使う場合は yield 値; で返す
* えっ12まではbreak 値;で大体していた

```java
var message = switch(定数) {
  case 値1, 値2 -> 値;
  case 値3, 値4 -> {
    yield 値;
  }
  default -> throw new IllegalStateException(msg);
}
var message = switch(定数) {
  case 値1, 値2:
    break 値;
  default:
    break 値;
}
```