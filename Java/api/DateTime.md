# Date-Time

- [Date-Time API](#date-time-api)
  - [ZoneOffset 例](#zoneoffset-例)
  - [plus(), minus()](#plus-minus)
- [DateTimeFormatter](#datetimeformatter)
  - [定数](#定数)
  - [.ofLocalizedDate(FormatStyle)](#oflocalizeddateformatstyle)
  - [.ofPattern(文字列) フォーマット](#ofpattern文字列-フォーマット)
- [Period, Duration](#period-duration)
  - [日付時刻オブジェクトの差から得る](#日付時刻オブジェクトの差から得る)
  - [期間を指定して得る](#期間を指定して得る)

## Date-Time API

| DateTime       | Date      | Time       |
| -------------- | --------- | ---------- | ---------------------------- |
| LocalDateTime  | LocalDate | LocalTime  |
| OffsetDateTime |           | OffsetTime | 時差情報付き(あまり使わない) |
| ZonedDateTime  |           |            | 時差・地域特有情報付き       |

.now() 現在日時
.of(各値) 指定した日時
.parse(文字列[, フォーマット])
.equals(オブジェクト);
.isBefore(オブジェクト);
.isAfter(オブジェクト);

### ZoneOffset 例
```java
ZoneOffset.ofHours(9);            // hours
ZoneOffset.ofHoursMinutes(7, 30); // hours, minutes
ZoneOffset.of("+09:00");          // "+09:00", "-18"など結構なんでも
// ZoneId
ZoneId.of("エリア")
```
JapaneseDate.of() 和暦

### plus(), minus()

引数(long val, TemporalUnit unit)

unitの値の例(ChronoUnit列挙型)
| val       | -          |
| --------- | ---------- |
| ERAS      | 紀元       |
| CENTURIES | 世紀       |
| MILLENNIA | 1000年     |
| DECADES   | 10年       |
| YEARS     | 年         |
| MONTHS    | 月         |
| WEEKS     | 週         |
| DAYS      | 日         |
| HALF_DAYS | 午前/午後  |
| HOURS     | 時         |
| MINUTES   | 分         |
| SECONDS   | 秒         |
| MILLIS    | ミリ秒     |
| MICROS    | マイクロ秒 |
| NANOS     | ナノ秒     |

* plus〇〇/minus〇〇メソッドのいろいろ
Years, Months, Weeks, Days, Hours, Minutes, Seconds, Nanos

## DateTimeFormatter

### 定数

* DateTimeFormatter.ISO_DATE など

| 定数                 | フォーマット                          | memo               |
| -------------------- | ------------------------------------- | ------------------ |
| BASIC_ISO_DATE       | 20190110                              |
| ISO_LOCAL_DATE       | 2019-01-10                            | LocalDate規定      |
| ISO_OFFSET_DATE      | 2019-01-10+09:00                      |
| ISO_DATE             | 2019-01-10+09:00, 2019-01-10          |
| ISO_LOCAL_TIME       | 10:20:30                              | LocalTime規定      |
| ISO_OFFSET_TIME      | 10:20:30+09:00                        |
| ISO_TIME             | 10:20:30+09:00, 110:20:30             |
| ISO_LOCAL_DATE_TIME  | 2019-01-10T10:20:30                   | LocalDateTime規定  |
| ISO_OFFSET_DATE_TIME | 2019-01-10T10:20:30+09:00             | OffsetDateTime規定 |
| ISO_ZONED_DATE_TIME  | 2019-01-10T10:20:30+09:00[Asia/Tokyo] | ZonedDateTime規定  |
| ISO_DATE_TIME        | 2019-01-10T10:20:30+09:00[Asia/Tokyo] |
| ISO_ORDINAL_DATE     | 2019-123                              | 年-日数            |
| ISO_WEEK_DATE        | 2019-W40-5                            | 年-週数-日         |
| RFC_1123_DATE_TIME   | Thu, 10 Jan 2019 10:20:30 GMT         |

### .ofLocalizedDate(FormatStyle)

* DateTimeFormatter.ofLocalizedDate(FormatStyle.FULL) など
FULL > LONG > MEDIUM > SHORT

### .ofPattern(文字列) フォーマット

例： `G u年 M月 d日 E曜日 H:m:s`
'文字列'でエスケープ シングルクォーテーション単体は''で表示
例： `'year:'u 'month:'MM 'day:'dd`

Java 8 の DateTimeFormatter の曜日等のフォーマットについて - tokuhirom's blog
http://blog.64p.org/entry/2015/07/13/102145

| 記号 | 意味       | 例                   |
| ---- | ---------- | -------------------- |
| G    | 紀元 元号  | AD, 西暦, A          |
| u    | 年(通常)   | 2004, 04             |
| y    | 年(暦対応) | 2004, 04             |
| Q/q  | 四半期     | 3, 03, Q3, 第3四半期 |
| M/L  | 月         | 7, 07, 7月, 7月, J   |
| W    | 週(月)     | 4                    |
| d    | 日(月)     | 10                   |
| E    | 曜日(文字) | 火, 火曜日, Tue, T   |
| c    | 曜日(数値) | 2                    |
| a    | 午前午後   | PM, 午後             |
| H    | 24時(0-23) | 0                    |
| K    | 12時(0-11) | 0                    |
| m    | 分         | 30                   |
| s    | 秒         | 55                   |

あまり使わないと思われるパターン

| 記号 | 意味                       | 例                |
| ---- | -------------------------- | ----------------- |
| D    | 日(年)                     | 189               |
| w    | 週(年)                     | 27                |
| e    | 曜日(数値含)               | 2, 02, 火, 火曜日 |
| F    | 第何○曜日                  | 3                 |
| S    | ミリ秒                     | 978               |
| A    | ミリ秒(日)                 | 1234              |
| n    | ナノ秒                     | 987654321         |
| N    | ナノ秒(日)                 | 1234000000        |
| h    | 12時(1-12)                 | 12                |
| k    | 24時(1-24)                 | 24                |
| Y    | 年(グレゴリオ暦) {1996, 96 |
| g    | 修正ユリウス日  { 2451334  |

タイムゾーン(LocalDateTimeでは使えない)

| 記号 | 意味                                 | 例                                            |
| ---- | ------------------------------------ | --------------------------------------------- |
| V    | タイムゾーンID                       | America/Los_Angeles, Z, -08:30                |
| v    | 一般的なタイムゾーン名               | 太平洋時間, PT                                |
| z    | タイムゾーン名                       | 太平洋標準時,PST                              |
| O    | ローカライズされたゾーン・オフセット | GMT+8, GMT+08:00, UTC-08:00                   |
| X    | ゼロのゾーン・オフセット'Z'          | Z, -08, -0830, -08:30, -083015, -08:30:15     |
| x    | タイムゾーン                         | +0000, -08, -0830, -08:30, -083015, -08:30:15 |
| Z    | タイムゾーン                         | +0000, -0800, -08:00                          |

| 記号 | 意味            | 例                                                   |
| ---- | --------------- | ---------------------------------------------------- |
| uuuu | year            | G不可 通常 紀元が基準の年 マイナス値をとりうる       |
| yyyy | year-of-era     | G必須 暦に対応した値 マイナス値はBC 各地域の暦に対応 |
| YYYY | week-based-year | グレゴリオ暦                                         |

## Period, Duration

### 日付時刻オブジェクトの差から得る

```java
var period = Period.between(LocalDate start, LocalDate end);
var duration = Duration.between(Temporal start, Temporal end);
```

### 期間を指定して得る

| Period              |
| ------------------- |
| ofYears(int)        |
| ofMonths(int)       |
| ofWeeks(int)        |
| ofDays(int)         |
| parse(CharSequense) |

| Duration                                  |
| ----------------------------------------- |
| ofHours(long)                             |
| ofHours(long)                             |
| ofMinutes(long)                           |
| ofSeconds(long[, long]) // 第二引数でナノ |
| ofMillis(long)                            |
| ofNanos(long)                             |
| parse(CharSequense)                       |

* parse()の引数

<符号>P<日付間隔>T<時間間隔>
* 未来過去
\- -(マイナス)
* 日付間隔
\- Y 年, M 月, W 週, D 日
* 時間間隔
\- D 日, H 時, M 分, S 秒

* 例

```
Period.parse("-P1DT5M");         - P< 1D >  T< 5M >
Duration.parse("P21DTT1H1M1S");    P< 21D > T< 1H 1M 1S >
```