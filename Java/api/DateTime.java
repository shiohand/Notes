package api;

import java.text.DateFormat;
import java.text.ParseException;
import java.time.Duration;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.LocalTime;
import java.time.Month;
import java.time.OffsetDateTime;
import java.time.OffsetTime;
import java.time.Period;
import java.time.ZoneId;
import java.time.ZoneOffset;
import java.time.ZonedDateTime;
import java.time.chrono.JapaneseDate;
import java.time.chrono.JapaneseEra;
import java.time.format.DateTimeFormatter;
import java.time.format.FormatStyle;
import java.time.temporal.ChronoField;
import java.time.temporal.ChronoUnit;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;

/**
 * オブジェクト生成
 * DateTimeFormatterの利用
 * JapaneseDateクラス
 * 日付時刻の比較
 * 日付時刻の差分期間の取得
 * 日付時刻の加減算
 * オブジェクトからの情報の取得
 * Jaca7以前のCalendarクラス
 * CalendarとDateTimeの変換
 */

public class DateTime {
  public static void out(Object o) {
    System.out.println(o);
  }

  public static void オブジェクト生成() {

    /* .now() 現在日時 */
    LocalDateTime.now(); // 2018-11-11T10:33:54.167850100
    LocalDate.now(); // 2018-11-11
    LocalTime.now(); // 10:33:54.167850100
    OffsetDateTime.now(); // 2018-11-11T10:33:54.167850100+09:00
    ZonedDateTime.now(); // 2018-11-11T10:33:54.167850100+09:00[Asia/Tokyo]

    /* .of() 指定日時 */

    // LocalDateTime
    LocalDateTime.of(2019, 1, 10, 10, 20, 30, 513); // 2019-01-10T10:20:30.000000513
    LocalDateTime.of(2019, 1, 40, 10, 20, 30); // エラー！ 40日を設定 自動繰り上げは行われない
    // LocalDate, LocalTime, ←から作るLocalDateTime
    var ld = LocalDate.of(2019, Month.JANUARY, 10); // Month型も使える
    var lt = LocalTime.of(10, 20, 30); // ナノ秒がなくても良い
    var ldt = LocalDateTime.of(ld, lt); // 2019-01-10T10:20:30

    // OffsetDateTime, OffsetTime (OffsetDateは無いよ。Offset関係ないし)
    OffsetDateTime.of(ldt, ZoneOffset.ofHours(9)); // 2019-01-10T10:20:30+09:00
    OffsetTime.of(lt, ZoneOffset.of("+09:00")); // 10:20:30+09:00
    // ZoneOffset 例
    ZoneOffset.ofHours(9); // hours
    ZoneOffset.ofHoursMinutes(7, 30); // hours, minutes
    ZoneOffset.of("+09:00"); // "+09:00", "-18"など結構なんでも

    // ZonedDateTime
    // ZoneId.of("エリア")
    ZonedDateTime.of(ldt, ZoneId.of("Asia/Tokyo")); // 2019-01-10T10:20:30+09:00[Asia/Tokyo]

    /* .parse(文字列[, DateTimeFormatter]) */
    // デフォルトのフォーマッターを利用(オブジェクトによって異なる)
    LocalDate.parse("2019-01-10"); // ISO_LOCAL_DATE
    LocalDateTime.parse("2019-01-10T10:20:30"); // ISO_LOCAL_DATE_TIME
    ZonedDateTime.parse("2019-01-10T10:20:30+09:00[Asia/Tokyo]"); // ISO_ZONED_DATE_TIME
    // DateTimeFormatterを指定 -> DateTimeFormatterの利用()へ
    LocalDate.parse("2019-01-10", DateTimeFormatter.ISO_DATE);
    LocalDateTime.parse("2019.01.01 10:20:30", DateTimeFormatter.ofPattern("u.MM.dd H:m:s"));
  }

  public static void DateTimeFormatterの利用() {
    /* public String format(DateTimeFormatter formatter) */
    // formatter は FormatStyleで借りる, ofPatternで自作のどちらかか

    var dt1 = LocalDateTime.of(2019, 1, 10, 10, 20, 30);
    var dt2 = ZonedDateTime.of(2019, 1, 10, 10, 20, 30, 0, ZoneId.of("Asia/Tokyo"));

    /* FormatStyleで作る */
    // FULL > LONG > MEDIUM > SHORT
    // ofLocalizedDate/Time/DateTime(FormatStyle fmt)
    var fmtD_F = DateTimeFormatter.ofLocalizedDate(FormatStyle.FULL);
    var fmtT_L = DateTimeFormatter.ofLocalizedTime(FormatStyle.LONG);
    var fmtDT_M = DateTimeFormatter.ofLocalizedDateTime(FormatStyle.MEDIUM);
    // dateとtimeを別々に指定可能
    var fmtDT_MS = DateTimeFormatter.ofLocalizedDateTime(FormatStyle.MEDIUM, FormatStyle.SHORT);
    dt1.format(fmtD_F); // 2019年1月10日木曜日
    dt2.format(fmtT_L); // 10:20:30 JST
    dt1.format(fmtDT_M); // 2019/01/10
    dt2.format(fmtDT_MS); // 2019年1月10日 10:20

    /* ofPetternで自作 */
    // 書式指定子はDateTime.txtへ
    var ptn1 = DateTimeFormatter.ofPattern("u.MM.dd H:m:s");
    var ptn2 = DateTimeFormatter.ofPattern("u年L月d日 (E) a K時m分s秒 (z)");
    dt1.format(ptn1); // 2019.01.01 10:20:30
    dt2.format(ptn2); // 2019年1月1日 (火) 午前 10時20分30秒(JST)

    /* DateTimeFormatter.withLocale(Locale locale) */
    var fmtDT_F = DateTimeFormatter.ofLocalizedDateTime(FormatStyle.FULL);
    // ロケール(タイムゾーンではない)に対応したフォーマットに
    dt2.format(fmtDT_F.withLocale(Locale.JAPAN));
    // 2018年12月22日土曜日 15時37分10秒 日本標準時
    // ↓タイムゾーンとロケールをアメリカにした場合
    // Saturday, December 22, 2018 at 3:37:10 PM Central Standard Time
  }

  public static void JapaneseDateクラス() {
    // JapaneseEra.定数 REIWA, HEISEI, SHOUWA, TAISHYO, MEIJI
    var jd = JapaneseDate.of(JapaneseEra.HEISEI, 30, 12, 31); // Japanese Heisei 30-12-31
    jd.format(DateTimeFormatter.ofPattern("Gy年MM月dd日")); // 平成30年12月31日
  }

  public static void 日付時刻の比較() {
    /* equals() isBefore() isAfter() */
    var dt1 = LocalDateTime.of(2018, 12, 31, 10, 20, 30);
    var dt2 = LocalDateTime.of(2019, 1, 10, 10, 20, 30);
    dt1.equals(dt2); // false
    dt1.isBefore(dt2); // true
    dt1.isAfter(dt2); // false
  }

  public static void 日付時刻の差分期間の取得() {
    /* Period(日付間隔), Duration(時間間隔) */

    // between(start, end)で生成
    var dt1 = LocalDateTime.of(2018, 12, 31, 0, 0, 0); // 2018-12-31T00:00
    var dt2 = LocalDateTime.of(2020, 3, 3, 10, 20, 30); // 2020-03-03T10:20:30
    // PeriodはLocalDate DurationはTemporal
    var period = Period.between(dt1.toLocalDate(), dt2.toLocalDate()); // toLocalDateでLocalDateに
    var duration = Duration.between(dt1, dt2);
    out(period.getYears() + "年" + period.getMonths() + "ヶ月" + period.getDays() + "日間"); // 1年2ヶ月3日間
    out(duration.toHours() + "時間"); // 10282時間

    // 直接間隔を指定して作成 詳細->DateTime.txt
    Period.ofYears(3);
    Duration.ofDays(21);
    // parse() 文字列で指定 <符号>P<日付間隔>T<時間間隔>
    // 未来過去 -(マイナス) / 日付間隔 Y 年, M 月, W 週, D 日 / 時間間隔 D 日, H 時, M 分, S 秒
    Period.parse("-P1DT5M"); // - P< 1D > T< 5M >
    Duration.parse("P21DTT1H1M1S"); // P< 21D > T< 1H 1M 1S >

    // Period Durationから取得できる値
    out("Period は getXxxx" + period.getYears() + period.getMonths() + period.getDays());
    out("Duration は toXxxx" + duration.toDays() + duration.toHours() + duration.toMinutes() + duration.toSeconds()
        + duration.toMillis() + duration.toNanos());
  }

  public static void 日付時刻の加減算() {
    /* plus(), minus() */
    // 引数 (値, 単位) (PeriodかDuration)

    var d = LocalDate.of(2019, 1, 10); // 2019-01-10
    // 値と単位(ChronoUnit列挙型)
    d.plus(3, ChronoUnit.YEARS); // 2022-01-10
    d.minus(21, ChronoUnit.DAYS); // 2018-12-20
    // 単位ごとのメソッド
    d.plusYears(3);
    d.minusDays(21);
    // Period, Duration
    d.plus(Period.ofYears(3));
    d.minus(Duration.ofDays(21));
  }

  public static void オブジェクトからの情報の取得() {
    /* LocalDateTime */
    var dt = LocalDateTime.of(2018, 12, 31, 10, 20, 30, 123);
    out("" + dt.getYear() + dt.getMonthValue() + dt.getDayOfMonth() + dt.getDayOfWeek() + // 曜日
        dt.getHour() + dt.getMinute() + dt.getSecond() + dt.getNano() + // 0~999999999
        dt.getMonth() + // Month型 文字列にもなる
        dt.getDayOfYear() // その年の何日目
    );
    /* java.time.temporal.ChronoFieldを利用 */
    // dt.get(ChronoField)
    var week = new String[] { "日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日" };
    out("詳細な取得" + dt.get(ChronoField.ERA) + // 紀元
        dt.get(ChronoField.YEAR) + dt.get(ChronoField.MONTH_OF_YEAR) + dt.get(ChronoField.DAY_OF_MONTH)
        + week[dt.get(ChronoField.DAY_OF_WEEK) - 1] + // 数値で返るので変換
        dt.get(ChronoField.HOUR_OF_DAY) + dt.get(ChronoField.AMPM_OF_DAY) + // 午前午後
        dt.get(ChronoField.HOUR_OF_AMPM) + dt.get(ChronoField.MINUTE_OF_HOUR) + dt.get(ChronoField.SECOND_OF_MINUTE)
        + dt.get(ChronoField.NANO_OF_SECOND) + dt.get(ChronoField.MILLI_OF_SECOND) + "他 列挙型ChronoFieldで検索");
  }

  public static void Jaca7以前のCalendarクラス() {
    // Calendar.getInstance()やらgetTime()やら
    // Calendar, Dateはミリ秒までしか入らない

    // getInstance() 日付時刻オブジェクトの生成
    var cal1 = Calendar.getInstance();
    var cal2 = Calendar.getInstance();

    // set() 時刻要素を設定 (2019/1/10 10:20:30)
    cal1.set(2019, 0, 10, 10, 20, 30);
    cal2.set(2019, 0, 10, 10, 20, 30);
    // 文字列から日付時刻値を生成 parse()
    // ParseExceptionの処理必要
    try {
      DateFormat.getInstance().parse("2019/1/10 10:20:30");
    } catch (ParseException e) {
      e.printStackTrace();
    }

    // 時刻要素を取得
    out(
      cal1.get(Calendar.YEAR) + "年" +
      (cal1.get(Calendar.MONTH) + 1) + "月" +
      cal1.get(Calendar.DATE) + "日"
    ); // 2019年1月10日

    // 日付を加算 add(単位, 値)
    cal1.add(Calendar.YEAR, 1); // 単位と値
    // 日付を取得
    cal1.getTime(); // Fri Jan 10 10:20:30 JST 2020
    // 日付の差分を演算(ミリ秒換算の値から差を計算)
    var diff = (int)((cal1.getTimeInMillis() - cal2.getTimeInMillis()) / (1000 * 60 * 24)); // 364(日)
    out(diff);

    // 日時を比較
    cal1.equals(cal2); // false
    cal1.before(cal2); // false
    cal1.after(cal2);  // true

    // 日時を整形 DateFormatクラス
    var fmt = DateFormat.getDateTimeInstance(DateFormat.FULL, DateFormat.FULL);
    fmt.format(cal2.getTime()); // 2019年1月10日木曜日10時20分30秒 日本標準時
  }
  public static void CalendarとDateTimeの変換() {
    /* Instantを経由して差異を吸収 */

    // Calendar->DateTime
    // ofInstant(Instant, ZoneId)
    var cal1 = Calendar.getInstance();
    LocalDateTime.ofInstant(cal1.toInstant(), ZoneId.systemDefault()); // ZoneIdはシステム既定
    OffsetDateTime.ofInstant(cal1.toInstant(), ZoneId.systemDefault());
    ZonedDateTime.ofInstant(cal1.toInstant(), ZoneId.systemDefault());

    // DateTime->Calendar
    // toInstant(ZoneOffset), Date.from(Instant), setTime(Date)
    var dt = LocalDateTime.now();
    var d = Date.from(dt.toInstant(ZoneOffset.of("+09:00")));
    var cal2 = Calendar.getInstance();
    cal2.setTime(d);
  }
}