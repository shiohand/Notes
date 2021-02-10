# practice

- [pull](#pull)
  - [ブランチの作成とチェックアウト](#ブランチの作成とチェックアウト)
  - [プル](#プル)
  - [競合させる](#競合させる)
  - [フェッチとマージ(プル同等)](#フェッチとマージプル同等)
  - [user1でもマージ](#user1でもマージ)
- [- - 1+ - -](#----1----)
  - [user2でpullしてみてリモートでもマージされているか確認](#user2でpullしてみてリモートでもマージされているか確認)
- [- - 2 - -](#----2----)
  - [マージコミットのshow](#マージコミットのshow)
- [- - 3 - -](#----3----)
  - [cherry-pick](#cherry-pick)
  - [stash](#stash)
  - [tag](#tag)
  - [.gitignore](#gitignore)
- [- - 4 - -](#----4----)
  - [接続(https)](#接続https)
  - [接続(ssh)](#接続ssh)
  - [プルリクエスト](#プルリクエスト)

study_git内で練習

| 登場人物            | -                                            |
| ------------------- | -------------------------------------------- |
| /user1              | 一人目のつもり                               |
| /user1/project      | 一人目の作業ディレクトリ                     |
| /user2              | 二人目のつもり                               |
| /server             | リモートリポジトリのつもり。(ベアリポジトリ) |
| /server/project.git | (ファイルではない。.gitは慣例)               |

ユーザー情報の登録(変更するときも同じコマンドで上書き)
`$ git config --global user.name [username]`
`$ git config --global user.email [email address]`

### ローカルリポジトリの作成
`$ git init`

### ファイルをステージング
`$ git add main.txt`
// カレントフォルダの内容まとめて
`$ git add .`

### コミット
`$ git commit -m "[A] main.txt A"`

### 情
---------------------------------------- */

### ステータス確認 コミット、ステージングの状態
`$ git status`

### コミットログを見る
`$ git log --oneline`

// a5eea8f (HEAD -> main) [B] main.txt AB
// ad5fcce [A] main.txt A

### コミットの詳細を表示
show            最新のコミット内容を表示
show [id]       指定のコミット内容を表示
show [tagname]  タグを指定

`$ git show a5eea8f`
// commit a5eea8f0ea5153636baa8b50482aa2744532504e (HEAD -> main)
// Author: example <example@example.com>
// Date:   Fri Nov 27 15:09:56 2020 +0900
// 
//     [B] main.txt AB
// 
\- 変更内容
// diff --git a/main.txt b/main.txt
// index 8c7e5a6..dfc9179 100644
// --- a/main.txt
// +++ b/main.txt
// @@ -1 +1 @@
// -A
// \ No newline at end of file
// +AB
// \ No newline at end of file

\- 差分を見る
`$ git diff ad5fcce a5eea8f`

// diff --git a/main.txt b/main.txt
// index 8c7e5a6..dfc9179 100644
// --- a/main.txt
// +++ b/main.txt
// @@ -1 +1 @@
// -A
// \ No newline at end of file
// +AB
// \ No newline at end of file

\- 差分を見る(文字単位での差分)
`$ git diff --word-diff HEAD ad5fcce`

// diff --git a/main.txt b/main.txt
// index dfc9179..8c7e5a6 100644
// --- a/main.txt
// +++ b/main.txt
// @@ -1 +1 @@
// [-AB-]{+A+}


### リモートリポジトリの作成
`$ git init --bare --shared`

### ローカルリポジトリに登録
`$ git remote add [remote] [URL]`

\- リモートを確認
`$ git remote -v`
// origin  C:/Users/Owner/study_git/server/project.git (fetch)
// origin  C:/Users/Owner/study_git/server/project.git (push)

\- ブランチを確認
`$ git branch -a`
// * main
\- 現時点でリモートブランチはなし

### プッシュ
`$ git push [remote] [branch]`
// git push origin main
// ごちゃごちゃ...
// server/project.gitに最初のブランチが出来る
// * [new branch] main -> main

\- ブランチを確認
`$ git branch -a`
// * main
// remotes/origin/main

\- ログを見る
`$ git log --oneline`
// a5eea8f (HEAD -> main, origin/main) [B] main.txt AB
// ad5fcce [A] main.txt A
\-  ↑「, origin/main」が増えている

### クローン
\- cd ~/study_git/user2
`$ git clone [URL]`

\- 追跡ブランチの確認
`$ git branch -vv`

### ブランチをわける
`$ git branch [branch]`
// git branch develop

### 指定のブランチへ移動
`$ git checkout [branch]`
// git checkout develop

\- 移動を確認
`$ git branch`
// * develop
// main

\- (ファイルを変更 main.txt "ABC")
\- (ファイルを作成 develop.txt "header\nfooter")

\- addとcommit
`$ git add .`
`$ git commit -m "[C] main.txt ABC / develop.txt new"`

### 追跡を指定してプッシュ(初回なのでorigin/developが出来る)
`$ git push -u [remote] [branch]`
// git push -u origin develop

\- 確認
`$ git branch -vv`
// * develop 2b423a9 [C] main.txt ABC / develop.txt new
//   main    a5eea8f [origin/main] [B] main.txt AB


## pull

移動
cd ~/study_git/user2

### ブランチの作成とチェックアウト
`$ git checkout -b [branch]`
// git checkout -b develop

### プル
`$ git pull [remote] [branch]`

### 競合させる
\- (ファイルを変更 develop.txt "header\ntitle\nfooter")
`$ git add . && git commit -m "[D] develop.txt 2i title"`
`$ git push origin develop`

\- 移動
\- cd ~/study_git/user2/project

\- (ファイルを変更 develop.txt "header\nbody\nfooter")
`$ git add . && git commit -m "[D] develop.txt 2i body"`

### フェッチとマージ(プル同等)
`$ git fetch [remote] [branch]`

\- フェッチ
`// $ git fetch origin develop`
// From C:/Users/Owner/study_git/server/project
\- 追跡ブランチのFETCH_HEADできてる
//  * branch            develop    -> FETCH_HEAD
//    2b423a9..f146166  develop    -> origin/develop

\- 違いチェック
`// $ git diff --word-diff FETCH_HEAD..HEAD`
// diff --git a/develop.txt b/develop.txt
// index 869134f..b7e598a 100644
// --- a/develop.txt
// +++ b/develop.txt
// @@ -1,3 +1,3 @@
// header
// [-title-]{+body+}
// footer

\- マージ試み
`// $ git merge --no-edit`
// Auto-merging develop.txt
// CONFLICT (content): Merge conflict in develop.txt
// Automatic merge failed; fix conflicts and then commit the result.

\- フェッチした状態のdevelopを自分にマージ(成功時はコミット)
\- コンフリクトによりコミットならず
\- 残っている競合部分を手書きで修正(手動マージ)
\- そしてaddが解消した宣言みたいな
\- マージコミットも手動でやって、マージ終了

\- コミット/プッシュ
`// $ git add . && git commit -m "[F] develop.txt merge"`
`// $ git push origin develop`

### user1でもマージ
\- 移動
`$ cd ~/study_git/user1/project`

\- チェックアウト忘れず
`$ git checkout main`

\- マージ
`$ git marge [branch]`
`// $ git merge develop`
// Updating a5eea8f..f146166
// Fast-forward
//  develop.txt | 3 +++
//  main.txt    | 2 +-
//  2 files changed, 4 insertions(+), 1 deletion(-)
//  create mode 100644 develop.txt

\- マージをプッシュ
`$ git push origin main`

## - - 1+ - -

`$ echo -n 'G' >> main.txt`
`$ git add . && git commit -m "[G] main.txt ABCG"`
`$ echo -n 'H' >> main.txt`
`$ git add . && git commit -m "[H] main.txt ABCGH"`
`$ git push origin main`
`$ git log --graph --oneline`

### user2でpullしてみてリモートでもマージされているか確認
`$ cd ~/study_git/user2/project`
`$ git checkout main`
`$ git pull origin main`

\- ログを確認(--graph)
`$ git log --graph --oneline`

// * e6c0251 (HEAD -> main, origin/main, origin/HEAD) [H] main.txt ABCGH
// * 161b3d4 [G] main.txt ABCG
// *   b40a708 (origin/develop, develop) [F] develop.txt merge
// |\
// | * 7d9e996 [D] develop.txt 2i title
// * | 85394d4 [E] develop.txt 2i body
// |/
// * a32e38a [C] main.txt ABC / develop.txt new
// * ff2dad5 [B] main.txt AB
// * a3e8c8a [A] main.txt A

## - - 2 - -

`$ mkdir ~/study_git/reset`

`$ cd ~/study_git/reset/`

`$ git clone ~/study_git/server/project.git/`
// Cloning into 'project'...
// done.

`$ cd project`

`$ echo -n 'I' >> main.txt`

`$ git add . && git commit -m "[I] main.txt ABCGHI"`
// [main 4afb0de] [I] main.txt ABCGHI
//  1 file changed, 1 insertion(+), 1 deletion(-)

`$ git log --oneline -3`
// 4afb0de (HEAD -> main) [I] main.txt ABCGHI
// e6c0251 (origin/main, origin/HEAD) [H] main.txt ABCGH
// 161b3d4 [G] main.txt ABCG

`$ git reset --soft HEAD^`

`$ git log --oneline -3`
// e6c0251 (HEAD -> main, origin/main, origin/HEAD) [H] main.txt ABCGH
// 161b3d4 [G] main.txt ABCG
// b40a708 (origin/develop) [F] develop.txt merge

`$ git diff --cached --word-diff`
// diff --git a/main.txt b/main.txt
// index 6adb32b..4ca0617 100644
// --- a/main.txt
// +++ b/main.txt
// @@ -1 +1 @@
// [-ABCGH-]{+ABCGHI+}

`$ cat main.txt`
// ABCGHI

`$ git reset --hard e6c0251`
// HEAD is now at e6c0251 [H] main.txt ABCGH

`$ git log --oneline -3`
// e6c0251 (HEAD -> main, origin/main, origin/HEAD) [H] main.txt ABCGH
// 161b3d4 [G] main.txt ABCG
// b40a708 (origin/develop) [F] develop.txt merge

`$ git reset --hard 161b3d4`
// HEAD is now at 161b3d4 [G] main.txt ABCG

`$ git log --oneline -3`
// 161b3d4 (HEAD -> main) [G] main.txt ABCG
// b40a708 (origin/develop) [F] develop.txt merge
// 85394d4 [E] develop.txt 2i body

`$ cat main.txt`
// ABCG

`$ git reflog -4`
// 161b3d4 (HEAD -> main) HEAD@{0}: reset: moving to 161b3d4
// e6c0251 (origin/main, origin/HEAD) HEAD@{1}: reset: moving to e6c0251
// e6c0251 (origin/main, origin/HEAD) HEAD@{2}: reset: moving to HEAD^
// 4afb0de HEAD@{3}: commit: [I] main.txt ABCGHI

`$ git reset --hard HEAD@{1}`
// HEAD is now at e6c0251 [H] main.txt ABCGH

`$ cat main.txt`
// ABCGH

`$ mkdir ~/study_git/revert && cd ~/study_git/revert`

`$ git clone  ~/study_git/server/project.git`
// Cloning into 'project'...
// done.

`$ cd project`

`$ echo -n 'I' >> main.txt`

`$ cat main.txt`
// ABCGHI

`$ git add . && git commit -m "[I] main.txt ABCGHI"`
// [main 25aaaef] [I] main.txt ABCGHI
//  1 file changed, 1 insertion(+), 1 deletion(-)
//  
`//  $ git revert --no-edit HEAD`
// [main 05b4324] Revert "[I] main.txt ABCGHI"
//  Date: Tue Dec 1 23:54:26 2020 +0900
//  1 file changed, 1 insertion(+), 1 deletion(-)
//  
`//  $ git log --oneline -5`
// 05b4324 (HEAD -> main) Revert "[I] main.txt ABCGHI"
// 25aaaef [I] main.txt ABCGHI
// e6c0251 (origin/main, origin/HEAD) [H] main.txt // ABCGH
// 161b3d4 [G] main.txt ABCG
// b40a708 (origin/develop) [F] develop.txt merge

`$ cat main.txt`
// ABCGH

`$ git reset --hard HEAD^`
// HEAD is now at 25aaaef [I] main.txt ABCGHI

`$ cat main.txt`
// ABCGHI


### マージコミットのshow

`$ git show b40a708`
// commit b40a708046f7759d4d92a6668878da5f329bc5ae // (origin/develop)
マージコミット(Merge: [1], [2])
// Merge: 85394d4 7d9e996
// Author: example <example@example.com>
// Date:   Tue Dec 1 10:34:05 2020 +0900
// 
//     [F] develop.txt merge
// 
// diff --cc develop.txt
// index b7e598a,869134f..e158371
// --- a/develop.txt
// +++ b/develop.txt
// @@@ -1,3 -1,3 +1,4 @@@
//   header
// + title
//  +body
//   footer

`$ git revert --no-edit -m 1 b40a708`
マージコミット(b40a708)
revert [id]
-m 1 の部分でどちらにrevertするか選択
// [main b0f0db2] Revert "[F] develop.txt merge"
//  Date: Wed Dec 2 00:11:10 2020 +0900
//  1 file changed, 1 deletion(-)

`$ cat develop.txt`
// header
// body
// footer

## - - 3 - -

### cherry-pick

`$ mkdir ~/study_git/cherrypick && cd ~/study_git/cherrypick`

`$ git clone  ~/study_git/server/project.git`
Cloning into 'project'...
done.

`$ cd ~/study_git/cherrypick/project`

`$ git checkout -b cherrypick`
Switched to a new branch 'cherrypick'

`$ sed -i -e "3i function1" develop.txt && git add . && git commit -m "[I] develop.txt `3i function1"
[cherrypick 550ea44] [I] develop.txt 3i function1
 1 file changed, 1 insertion(+)

`$ sed -i -e "4i function2" develop.txt && git add . && git commit -m "[J] develop.txt `4i function2"
[cherrypick 96e2f96] [J] develop.txt 4i function2
 1 file changed, 1 insertion(+)

`$ sed -i -e "5i function3" develop.txt && git add . && git commit -m "[K] develop.txt `5i function3"
[cherrypick 97cdff8] [K] develop.txt 5i function3
 1 file changed, 1 insertion(+)

`$ cat develop.txt`
header
title
function1
function2
function3
body
footer

`$ git log --oneline -3`
97cdff8 (HEAD -> cherrypick) [K] develop.txt 5i function3
96e2f96 [J] develop.txt 4i function2
550ea44 [I] develop.txt 3i function1

`$ git checkout main`
Switched to branch 'main'
Your branch is up to date with 'origin/main'.

`$ cat develop.txt`
header
title
body
footer

`$ git cherry-pick 96e2f96`
Auto-merging develop.txt
CONFLICT (content): Merge conflict in develop.txt
error: could not apply 96e2f96... [J] develop.txt 4i function2
hint: after resolving the conflicts, mark the corrected paths
hint: with 'git add <paths>' or 'git rm <paths>'
hint: and commit the result with 'git commit'

`$ git add . && git commit -m "[L] cherry-pick [J]"`
[main 17587f7] [L] cherry-pick [J]
 Date: Wed Dec 2 10:08:00 2020 +0900
 1 file changed, 2 insertions(+)

`$ git diff --word-diff HEAD^`
diff --git a/develop.txt b/develop.txt
index e158371..2fd2595 100644
--- a/develop.txt
+++ b/develop.txt
@@ -1,4 +1,6 @@
header
title
{+function1+}
{+function2+}
body
footer

### stash

`$ mkdir ~/study_git/stash && cd ~/study_git/stash`

`$ git clone ~/study_git/server/project.git`
Cloning into 'project'...
done.

`$ cd ~/study_git/stash/project`

`$ cat develop.txt`
header
title
body
footer

`$ sed -i -e "3i method1" develop.txt`

`$ cat develop.txt`
header
title
method1
body
footer

(バグが発生。対応するために作業中の変更は一旦避難＋好きに巻き戻す)
`$ git stash save "stash method1 on the way"`

(バグ対応中)
`$ gir reset --hard HEAD`
\- これはワークツリーを戻すためなのでHEADでreset

`$ sed -i -e "3i bug fix" develop.txt && git add . && git commit -m "[I] bug fix"`
// [main e2533ce] [I] bug fix
//  1 file changed, 1 insertion(+)

(もとの作業に戻る)

`$ git stash list`
// stash@{0}: On main: stash method1 on the way

(ドロップを削除(しなくてもいい))
`$ git stash drop stash@{0}`

### tag
`$ git log --oneline -6`

// e6c0251 (HEAD -> main, origin/main, origin/HEAD) [H] main.txt ABCGH
// 161b3d4 [G] main.txt ABCG
// b40a708 (origin/develop) [F] develop.txt merge
// 85394d4 [E] develop.txt 2i body
// 7d9e996 [D] develop.txt 2i title
// a32e38a [C] main.txt ABC / develop.txt new

`$ git tag v1.0 a32e38a`
`$ git tag v1.1 b40a708`
`$ git tag -a v1.2 -m "annotation message" e6c0251`
(タグでいろいろ指定)
`$ git log --oneline -6`
`$ git show v1.0`
`$ git log --oneline v1.0..v1.1`
`$ git diff --word-diff v1.0..v1.1`

### .gitignore
(ファイルを作って書いていくだけ。えでぃたでもいい)
(対象ファイル確認 指定したやつ全部無視)
`$ git status`


## - - 4 - -

- GiHub -
- リモートリポジトリ project 作成
- https https://github.com/[username]/project.git
- ssh   git@github.com:[username]/project.git

### 接続(https)

`$ git clone https://github.com/[username]/project.git`
(これだけ)
`(クローンじゃないなら $ git remote add origin https://github.com/[username]/project.git)`
(ログインダイアログがでたらログイン。Macの場合はターミナル)

### 接続(ssh)
`$ mkdir ~/study_git/repossh && cd ~/study_git/repossh`

ルートに.sshディレクトリが作られ、中にid_rsa(秘密鍵),id_rsa.pub(公開鍵),known_hostsを作成する 既存の場合はバックアップしとき
ssh-keygen -t [type] -b [bit]
ssh-keygen -t [type] -C [useremail] // なんかこっちで使ってる人がおおいので

`$ ssh-keygen -t rsa -b 4096`
`$ ssh-keygen -t rsa -C [useremail]`

// Generating public/private rsa key pair.
// Enter file in which to save the key (/c/Users/Owner/.ssh/id_rsa):
(このファイル名でよいかの確認 良いならエンター)
// Created directory '/c/Users/Owner/.ssh'.

// Enter passphrase (empty for no passphrase):
(パス入力)
// Enter same passphrase again:
(再入力)

// Your identification has been saved in /c/Users/Owner/.ssh/id_rsa
// Your public key has been saved in /c/Users/Owner/.ssh/id_rsa.pub
// The key fingerprint is:
// SHA256:g14XGGjs+2JQF5g5pjRIp38Su16K4Ux4M8ik0TxyLBs Owner@DESKTOP-1JQUCHC
// The key's randomart image is:
// +---[RSA 4096]----+
// | ..... =.        |
// |  .oo X .o       |
// |  ...* ....      |
// | + ..oo..  .     |
// |E.* +.ooS .      |
// |+X ..=.. o       |
// |=.* ..o.         |
// | = * oo .        |
// |  + o. .         |
// +----[SHA256]-----+

(鍵生成完了)

- GitHub -
- setting > SSH and GPG keys
- 任意のタイトルと公開鍵ファイルの内容の文字列を登録

`$ ssh -T git@github.com`
// The authenticity of host 'github.com (52.69.186.44)' can't be established.
// RSA key fingerprint is SHA256:nThbg6kXUpJWGl7E1IGOCspRomTxdCARLviKw6E5SY8.
// Are you sure you want to continue connecting (yes/no/[fingerprint])? yes
(接続しますかという確認にyesと入力)

// Warning: Permanently added 'github.com,52.69.186.44' (RSA) to the list of known hosts.
// Enter passphrase for key '/c/Users/Owner/.ssh/id_rsa':
(さっきのパス入力で接続完了)

// Hi [username]! You've successfully authenticated, but GitHub does not provide shell access.


`$ git clone git@github.com:[username]/project.git`
(パス入力でクローン完了)
`(クローンじゃないなら $ git remote add origin git@github.com:[username]/project.git)`
(以降もパス入力が必要なときは入力)

### プルリクエスト

`$ git checkout -b develop`
`$ touch app.txt && echo 'start' > app.txt && echo 'end' >> app.txt`
`$ cat app.txt`
`$ git add . && git commit -m "develop app"`
`$ git push origin develop`
(GitHubにブランチ追加 ブランチを切り替えるとファイルもある)

`$ git checkout -b feature-app`
`$ sed -i -e "2i methodo" app.txt`
`$ git add . && git commit -m "feature-app app"`
`$ git push origin feature-app`

(feature-appブランチをdevelopブランチにマージしたい)

(GitHub操作)
```
Pull requests
  > New pull request
Comparing changes
  base:develop compare:feature-app
  > Create pull request
Open a pull request
  > Create pull request
(レビュワー)
feature-app app #1
  > feature-app app
    レビューを書く 行をクリック 「method?」
    > Add single comment
(開発者側)
Pull requests
  > feature-app app
    レビューを確認
```

`$ sed -i -e "2c method" app.txt`
`$ git add . && git commit -m "feature-app app fix"`
`$ git push origin feature-app`

(GitHub操作)
```
レビュー画面にfixのが増えているので確認
Conversation
  > Merge pull request
    > Comfirm merge
      "Pull request successfully merged and closed
      You’re all set—the feature-app branch can be safely deleted."
        不要になったfeature-appブランチについて > Delete branch
マージしたので、プルリクエストの一覧からなくなる
```

`$ git checkout develop`

`$ cat app.txt`
// start
// end

`$ git pull origin develop`

`$ cat app.txt`
// start
// method
// end














