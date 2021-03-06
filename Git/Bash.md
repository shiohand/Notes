# Bash

- [コマンド](#コマンド)
- [文字列操作](#文字列操作)
  - [&&で処理をつなげる(失敗時中断)](#で処理をつなげる失敗時中断)

普通にコマンドライン

## コマンド

| 単語  | 意味                    |
| ----- | ----------------------- |
| `pwd` | print working directory |
| `ls`  | list                    |
| `mv`  | move                    |
| `cp`  | copy                    |
| `rm`  | remove                  |
| `/`   | ルートディレクトリ      |
| `..`  | 一つ親へ                |

| コマンド               | -                                      |
| ---------------------- | -------------------------------------- |
| `touch [file]`         | File作成                               |
| `touch {file,file}`    | 複数(コンマ後にスペースを開けないこと) |
| `cat [file]`           | File内容閲覧                           |
| `mkdir [dir]`          | Dir作成                                |
| `mkdir -p [dir]`       | 階層をもった新規Dirも可能              |
| `pwd`                  | カレントDirの位置表示                  |
| `ls`                   | カレントDir内容閲覧                    |
| `ls -a`                | 隠しファイル含む                       |
| `ls [dir]`             | 指定Dir内容閲覧                        |
| `cd [dir]`             | Dir移動                                |
| `cd`                   | ホームDirへ移動                        |
| `mv [file] [dir]`      | FileをDirへ移動                        |
| `mv [dir] [dir]`       | DirをDirへ移動                         |
| `mv [dir] [newdir]`    | DirをnewDirへ名前変更                  |
| `mv [file] [newfile]`  | FileをnewFileへ名前変更                |
| `cp [file] [newfile]`  | FileをnewFileでコピー                  |
| `cp -r [dir] [newdir]` | DirをnewDirでコピー                    |
| `rm [file]`            | Fileを削除                             |
| `rm -r [dir]`          | Dirを削除                              |
| `rm -f [file]`         | 対象がなくてもエラーを出さない         |
| `rm -rf [dir]`         | 中にファイルが入っていても             |

## 文字列操作

* 文字列出力
`echo '111'`

オプション|~
-|-
-n| ラインの最後に改行を追加しない
-e| バックスラッシュでのエスケープをオン
-E| オフ(デフォルトがオンのときは使う)

* 文字列でファイルを上書き
`echo '111' > test.txt`
* 文字列をファイルに追記
`echo '111' >> test.txt`

### &&で処理をつなげる(失敗時中断)
`rm test.txt && rm file.txt`
