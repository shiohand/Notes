# Serialize

Serializableインターフェイスを実装
シリアルバージョンUID (バージョンの違うクラスだとエラーが出る？)
インスタンスフィールドは基本型のみ
インスタンスフィールドはtransient で除外できる
serializableでないスーパークラスはコンストラクタの引数をつけられない

```java
public class Serialize implements Serializable { // implements Serializable
  private static final long serialVersionUID = 1L; // シリアルバージョンUID
  public String title; // インスタンスフィールドは基本型のみ
  public String url;
  public transient boolean expired; // transient で除外できる

  public Serialize(String title, String url, boolean expired) {
    this.title = title;
    this.url = url;
    this.expired = expired;
  }
}
```