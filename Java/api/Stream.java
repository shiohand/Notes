package api;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.nio.file.StandardOpenOption;
import java.time.LocalDateTime;

public class Stream {
  public static void Bufferedでテキスト読み込み() {
    try (
      var reader = Files.newBufferedReader(Paths.get("C:\\practice\\sample.txt"))
    ) {
      var line = "";
      while ((line = reader.readLine()) != null) { // null確認
        System.out.println(line);
      }
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
  public static void Bufferedでテキスト書き込み() {
    try (
      var writer = Files.newBufferedWriter(
        Paths.get("C:\\practice\\data.log"), StandardOpenOption.APPEND)
        // C:\practice\data.log, 追記モード
    ) {
      writer.write(LocalDateTime.now().toString());
      writer.newLine();
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
  public static void Bufferedのバイトストリーム読み書き() {
    try (
      var in = new BufferedInputStream(new FileInputStream("C:/practice/input.png"));
      var out = new BufferedOutputStream(new FileOutputStream("C:/practice/output.png"))
    ) {
      // 最大読込＆転記
      var data = -1; // 保険
      while ((data = in.read()) != -1) { // バイトストリームは-1でチェックできる
        out.write((byte) data);
      }
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
  public static void シリアライズとデシリアライズ() {
    final var file = "C:/practice/obj.ser";

    // シリアライズ、保存
    try (var out = new ObjectOutputStream(new FileOutputStream(file))) {
      out.writeObject(new Serialize("テスト", "urlなし", false));
    } catch (IOException e) {
      e.printStackTrace();
    }
  }
  public static void main(String[] args) {
    Bufferedでテキスト書き込み();
  }
}