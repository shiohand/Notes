# practiceまとめ

- [基本操作](#基本操作)
- [ローカルリポジトリ](#ローカルリポジトリ)
- [ブランチ](#ブランチ)
- [ステージング コミット プッシュ](#ステージング-コミット-プッシュ)
- [プル](#プル)
- [フェッチ マージ](#フェッチ-マージ)

こまめに現在地を確認しましょう(常に表示されてるやつで)
・階層
・ブランチ

## 基本操作

`$ git init`
リポジトリ作成

`$ git init --bare --shared`
リモートリポジトリ作成
(--bare > ベアリポジトリ)
(--shared > パーミッション 複数ユーザからプル可能)
ブランチはpushされたら勝手に増えていくよ

`$ git clone [URL]`
URLのリモートの内容をまるまる複製


`$ git status`
ステージング状態とかコミット状態とか

`$ git log --oneline`
コミットの新しい順(oneline > １コミット１行)
HEADの表示あり

`$ git show [id]`
コミット詳細(ファイル、コメント、日時、差分など)

`$ git diff --word-diff [id] [id]`
差分(--word-diff > テキスト)

`$ git branch`
ブランチ一覧
`$ git branch -vv`
リモート追跡ブランチ


## ローカルリポジトリ

`$ git remote add [remote] [URL]`
ローカルリポジトリにリモートリポジトリを登録

## ブランチ

`$ git branch [branch]`
作成
`$ git checkout [branch]`
移動
`$ git checkout　-b [branch]`
ブランチを作成して移動(pullする前に作っとくときとか)


## ステージング コミット プッシュ

`$ git add [file]`
`$ git add .`
`$ git commit -m "[コメント]"`
`$ git push [remote] [branch]`
[remote(あっち)]に、[branch(こっち)]の内容をpush

`$ git push -u [remote] [branch]`
(-u > pushするブランチをリモート追跡ブランチに)

## プル

`$ git pull [remote] [branch]`

## フェッチ マージ

`$ git fetch [remote] [branch]`
リモート追跡ブランチに持ってくる
`$ git merge [branch]`
普通にマージ
競合したら修正してコミット＆プッシュ
`$ git merge --no-edit`
リモート追跡ブランチ(FETCH_HEAD)を自分にマージ？

`$ git diff --word-diff FETCH_HEAD..HEAD`
フェッチとローカルのHEADの差分確認