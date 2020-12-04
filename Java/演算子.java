package matome;

import java.math.BigDecimal;
import java.util.Arrays;

/**
 * 演算子の利用
 */
public class 演算子 {
  public static void out(Object o) {
    System.out.println(o);
  }

  public static void 演算子の利用() {
        
    /* 整数値と除算 */
    out( 3 / 4);  // intで0なので注意
    out(3d / 4); // 0.75
    // ゼロ除算
    out( 5 / 0);  // error
    out( 5 % 0);  // error
    out(5d / 0); // Infinity
    out( 5 % 0);  // NaN

    /* 演算誤差 */
    Math.floor((0.7 + 0.1) * 10); // 7.0 2進数のための誤差
    // java.math.BigDecimalの利用
    // java.lang.Mathとは別の数学特化パッケージ
    // add, subtract, multiply, divideなど
    var bd1 = new BigDecimal(0.7);
    var bd2 = new BigDecimal("0.1");
    var bd3 = new BigDecimal(10);
    bd1.add(bd2).multiply(bd3); // 8.0

    /* 同値性(Identity)と同一性(Equivalence) */
    var sb1 = new StringBuilder("str");
    var sb2 = new StringBuilder("str");
    out(sb1 == sb2);      // false
    out(sb1.equals(sb2)); // true

    // 配列の比較
    var ar1 = new String[]{"abc", "123"};
    var ar2 = new String[]{"abc", "123"};
    ar1.equals(ar2); // false 配列は比較できない
    // java.util.Arraysの利用
    out(Arrays.equals(ar1, ar2));       // true
    out(Arrays.compare(ar1, ar2) == 0); // true
    out(Arrays.deepEquals(ar1, ar2));   // true 多次元配列対応

    // 数値の比較
    // ==比較では有効桁数も比較対象のため、BigDecimalの比較を利用
    var bd4 = new BigDecimal("0.1");
    var bd5 = new BigDecimal("0.10");
    out(bd4.compareTo(bd5) == 0); // true
    // 丸め単位(許容する誤差)を利用した比較
    final double EPSILON = 0.01; // 小数第2位まで
    var x = 0.2 * 3; // 誤差発生
    var y = 0.6;
    // 差が0.01未満、即ち(0.59 < x && x < 0.61)がtrueならばtrue
    out(Math.abs(x - y) < EPSILON); // true
    // オートボクシングに注意
    // booleanとbyte以外はオートボクシング前後で==の結果が変動する可能性
    // ラッパーオブジェクトもequalsで比較しよう
    Integer i1 = 108;
    Integer i2 = 108;
    out(i1 == i2);      // true
    Integer j1 = 256;
    Integer j2 = 256;
    out(j1 == j2);      // false
    out(j1.equals(j2)); // true
  }
}