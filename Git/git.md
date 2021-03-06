# Git入門

- [Gitとは](#gitとは)
- [基本](#基本)
  - [エディター](#エディター)
  - [git config](#git-config)
  - [リポジトリ](#リポジトリ)
    - [新規作成](#新規作成)
    - [リモートリポジトリ](#リモートリポジトリ)
    - [ローカルリポジトリ](#ローカルリポジトリ)
    - [originとmaster](#originとmaster)
  - [ワークツリーとステージングエリア(インデックス)](#ワークツリーとステージングエリアインデックス)
  - [.gitignore](#gitignore)
- [コミット](#コミット)
  - [一部(Hunk)をコミット](#一部hunkをコミット)
  - [コミットの頻度](#コミットの頻度)
  - [コミットメッセージの標準](#コミットメッセージの標準)
- [タグ](#タグ)
- [コミットの書き換え](#コミットの書き換え)
  - [amend 直前のコミットを修正](#amend-直前のコミットを修正)
- [revert コミットを打ち消すコミット](#revert-コミットを打ち消すコミット)
  - [reset コミットを捨てる 巻き戻し？](#reset-コミットを捨てる-巻き戻し)
- [リモートリポジトリ](#リモートリポジトリ-1)
  - [push](#push)
  - [clone](#clone)
  - [pull](#pull)
  - [fetch](#fetch)
  - [merge](#merge)

(vsCodeについては 「VSCodeでのGitの基本操作まとめ - Qiita」)

## Gitとは

* 分散型バージョン管理システム
* ファイルの状態を好きなときに更新履歴として保存
* 空のディレクトリはgitから存在を認めてもらえない

## 基本

### エディター

コミット時にコミットコメントが指定されていない場合にはエディターが表示される
(pullやrevertで自動マージになったときも出るが、--no-editオプションでデフォルトメッセージが適用)
エディターは通常はCUIベースで、設定で変更可能

### git config

`$ git config --global user.name [username]`
`$ git config --global user.email [useremail]`

GitHubではメールアドレスでアカウント判別してるからアカウントのアドレス化noreplayがよいとか
後々どのリポジトリでどのアドレスでコミットしたか混乱するとかなるから統一がよいかもしれんけど

`$ git config --global core.quotepath false`

日本語ファイル名をエンコードしないために

### リポジトリ

* ファイルやディレクトリの状態を記録する
* ディレクトリをリポジトリの管理下に置いて記録
* 各時点のコミットの差分が格納され、バージョンを管理できる

新しく作成するか、リモートリポジトリをcloneして作成する

#### 新規作成
`$ git init`
.gitフォルダ(リポジトリ本体)が追加される

#### リモートリポジトリ
ノンベアリポジトリ(リポジトリのみ)
サーバに配置して共有
`[プロジェクト名].git` のようなアドレス

#### ローカルリポジトリ
ベアリポジトリ(ファイル本体もある)
ひとり用

->普段の作業をローカルで行い、適宜リモートにアップという形など

#### originとmaster

単語|-
-|-
origin| ローカルから見たリモートリポジトリの名前(慣習)
master| デフォルトのブランチ(githubでmain)

`"git pull"` は `"git pull origin master"` と同じ

### ワークツリーとステージングエリア(インデックス)

* ワークツリー
\- Gitの管理下にあるディレクトリ(利用者が実際に作業してるとこ)
* ステージングエリア
\- リポジトリとワークツリーの間にある、コミット準備用の場所

ワークツリー -> インデックスに登録(不要ファイル自動整理) -> リポジトリにコミット

`$ git add myfile.txt`
は、インデックスに登録しただけ

### .gitignore

内容の変更を無視したいファイルを除外
.gitignoreの作成 これに除外条件を書いておく
`# コメントもあるよ`

記述|-
-|-
file.txt      |ファイル指定
dir/          |フォルダ指定 スラッシュしてね
dir/file.txt  |ファイル指定
*.txt         |拡張子指定
/dir/*        |同階層のァイル全て
!/japan       |not指定

組み合わせ|-
-|-
/dir/*          |dir内のファイル全て
!/dir/file.txt  |dir内のfile.txtのみ除外しない


## コミット

ファイルやディレクトリの変更をリポジトリに記録する操作
コミットメッセージ(必須)を入力してコミット

`$ git commit -m "first commit"`
(最初は"First Commit", "Initial Commit"がやや慣例)

リポジトリに、前回のコミットとの差分の記録コミット(リビジョン)が作成される
各コミットには自動で一意の名前が付けられ、確認の際はその名前で特定する

### 一部(Hunk)をコミット
ファイル内の変更部分の内、選択した部分のみコミットということもできる

### コミットの頻度
バグ修正や機能追加などの変更を溜めず、
バグ修正->コミット 機能追加->コミット と分けたほうが使うときに楽

### コミットメッセージの標準

```
変更内容の概要
(空行)
変更理由
```

## タグ

コミットを参照しやすくするための名前

タグからコミット検索
`checkout reset` でもタグを指定できる

* 軽量タグ
\- 名前のみ ローカルで一時的に使用する使い捨て用途
* 注釈付きタグ
\- 名前 コメント 署名
\- (リリースにバージョンをつけたり)

## コミットの書き換え

(できるだけリモートのコミットはかきかえないでおくべきってどっかで言ってた)

### amend 直前のコミットを修正

`commit --amend`
直前のコミットを修正

直前のコミットを修正(実行したらエディターが出るから、修正したいとこを修正)
amendオプションを指定して行う 内容の追加、コメントの修正など

* 追加し忘れたファイルを追加する
* コミットコメントを修正する

同じブランチの直前のコミットに対して修正
リセット後も、消したコミットは`ORIG_HEAD`という名前で参照できる

## revert コミットを打ち消すコミット

`revert [id]`
指定したコミットを取り消し

指定したコミットの内容を打ち消すコミット
`rebase -1` や `reset`でも削除できるが、公開済みの場合は勝手に削除できない
打ち消したいコミットを選び、それを打ち消すコミットを追加する

revertのコミットをrevertすれば、打ち消しの打ち消し＝復帰

### reset コミットを捨てる 巻き戻し？

指定したコミットがHEADの位置になるまで巻き戻す
(resetしたあとORIG_HEADにresetしなおして戻るとかいうのもできるらしい)
モードを選択して影響範囲を決める(インデックス、ワークツリー)

モード|影響範囲
-|-
soft   | HEAD
mixed  | HEAD インデックス
hard   | HEAD インデックス ワークツリー

* コミットだけ無かったことにする(soft)
* 変更したインデックスの状態を戻す(mixed)
* 最近のコミットを無かったことにする(hard)

## リモートリポジトリ

### push

リモートへローカルの変更履歴をアップロードして共有する
pushするときは競合がおきないように

### clone

リモートからリポジトリのコピーをもらう
変更履歴も複製されているので複製元と同じように使ってよい

### pull

リモートから差分をもらう
fetch + mergeをまとめて行う

マージと同様、ローカルリポジトリの状態によっては競合する
競合した場合は自動マージコミット、もしくは手動で競合部分を修正して解決

### fetch

無名のブランチとしてコミットを取得(マージをせず、見終えたら消せる)
チェックアウト(ブランチを保持して他に移動)が可能 -> FETCH_HEADという名前で残る

// ローカル(C, D)とリモート(X, Y)
// リモートから取得してチェックアウト(FETCH_HEAD)

```
A -> B -> X -> Y(origin/master)(FETCH_HEAD)
       -> C -> D(master)
```

### merge

```
A -> B -> X -> Y(origin/master) -> E(master)
       -> C -> D(master)        -^
```

