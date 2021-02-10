# MathCls

- [langのMath](#langのmath)
- [langじゃないmath](#langじゃないmath)
- [Randomクラス](#randomクラス)
- [NumberFormatクラス](#numberformatクラス)

## langのMath

```java
// メソッドの例
Math.abs(-100);
Math.min(5, 2);
Math.max(5, 2);
Math.ceil(1234.56);  // 1235.0 切り上げ
Math.floor(1234.56); // 1234.0 切り捨て
Math.round(1234.56); // 1235   四捨五入
Math.sqrt(10000);
Math.cbrt(10000);
Math.pow(5, 2);
```

## langじゃないmath

BigDecimal BigInteger

```java
// longを超える大きさの値も扱える
var val1 = BigInteger.valueOf(1);
for (var i = 1; i < 26; i++) {
  val1 = val1.multiply(BigInteger.valueOf(i));
} // longだと溢れる大きさ

// 共通する定数の例
BigInteger.ONE;
BigInteger.TEN;
BigInteger.ZERO;
BigInteger.ONE;

// 共通するメソッドの例
var val2 = BigInteger.valueOf(2);
val1.add(val2);
val1.subtract(val2);
val1.multiply(val2);
val1.divide(val2);
val1.remainder(val2);
val1.max(val2);
val1.min(val2);
val1.abs();
val1.sqrt();
// BigDecimalのdivide()やremainder()などは第二引数で丸め設定可能
```

## Randomクラス

```java
var rnd = new Random();
rnd.nextInt();
rnd.nextInt(100); // 上限(0～引数未満になる)
rnd.nextDouble();
rnd.nextFloat();
rnd.nextLong();
rnd.nextBoolean();

var data = new byte[5];
rnd.nextBytes(data); // 要素の数だけ入れる
```

## NumberFormatクラス

newではなくgetXxxxInstance()で生成

```java
var num1 = 1234.5678;
var num2 = 0.567;
NumberFormat.getCurrencyInstance(Locale.JAPAN).format(num1); // ￥1,235
NumberFormat.getIntegerInstance().format(num1);              // 1,235
NumberFormat.getNumberInstance().format(num1);               // 1,234.568
NumberFormat.getPercentInstance().format(num2);              // 57%

// setXxxxでフォーマットをカスタマイズ
var fmt = NumberFormat.getCurrencyInstance(Locale.JAPAN);
var currency = Currency.getInstance(Locale.JAPAN);
fmt.setCurrency(currency);           // 通貨
fmt.setGroupingUsed(false);          // 桁区切り
fmt.setMaximumIntegerDigits(100000); // 整数部最大桁
fmt.setMinimumIntegerDigits(0);      // 整数部最小桁
fmt.setMaximumFractionDigits(0);     // 小数部最大桁
fmt.setMinimumFractionDigits(0);     // 小数部最小桁
```