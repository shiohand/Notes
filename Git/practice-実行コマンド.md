# practice-実行コマンド

- [頻出まとめ](#頻出まとめ)
- [初出コマンドまとめ](#初出コマンドまとめ)
- [全実行コマンド](#全実行コマンド)
  - [- - 1 - -](#----1----)
  - [- - 2 - -](#----2----)
  - [- - 3 - -](#----3----)
  - [- - 4 - -](#----4----)

## 頻出まとめ
push pull mergeなどでは、自分のブランチと相手のブランチの関係をよく確認すること

```
$ cd ~/study_git/user1/project
$ cd ~/study_git/user2/project
$ git add . && git commit -m "[] main.txt"
$ git push origin main
$ git checkout develop
$ echo -n 'A' >> main.txt
$ git pull origin develop
$ git fetch origin develop
$ git merge --no-edit
$ git reset --soft HEAD^
$ git reflog -3
$ git revert --no-edit HEAD
$ git cherry-pick 96e2f96
$ git stash save "stash method1 on the way"
$ git stash list
$ git stash apply stash@{0}
```

## 初出コマンドまとめ

```
$ cd ~/study_git
$ mkdir server server/project.git user1 user1/project user2
$ git init
$ touch main.txt
$ echo -n 'A' >> main.txt
$ git add main.txt
$ git status
$ git commit -m "[A] main.txt A"
$ git add .
$ git log --oneline
$ git show a1555de
$ git init --bare --shared
$ git remote add origin ~/study_git/server/project.git
$ git remote -v
$ git branch -a
$ git push origin main
$ git clone ~/study_git/server/project.git
$ git branch -vv
$ git branch develop
$ git checkout develop
$ git push -u origin develop
$ git checkout -b develop
$ sed -i -e "2i title" develop.txt
$ git fetch origin develop
$ git diff --word-diff FETCH_HEAD..HEAD
$ git merge --no-edit
$ git log --graph --oneline
$ git log --oneline -3
$ git reset --soft HEAD^
$ git reflog -3
$ git revert --no-edit HEAD
$ git cherry-pick 96e2f96
$ git stash save "stash method1 on the way"
$ git stash list
$ git stash apply stash@{0}
$ git stash drop stash@{0}
$ git tag v1.0 a32e38a
$ git tag -a v1.2 -m "annotation message" e6c0251
```

## 全実行コマンド

空の"~/study_git"がある状態から

### - - 1 - -

```
$ cd ~/study_git
$ mkdir server server/project.git user1 user1/project user2
$ cd ~/study_git/user1/project
$ git init
$ touch main.txt
$ echo -n 'A' >> main.txt
$ git status
$ git add main.txt
$ git status
$ git commit -m "[A] main.txt A"
$ echo -n 'B' >> main.txt
$ git add .
$ git commit -m "[B] main.txt AB"
$ git log --oneline
$ git show a1555de
$ cd ~/study_git/server/project.git
$ git init --bare --shared
$ cd ~/study_git/user1/project
$ git remote add origin ~/study_git/server/project.git
$ git remote -v
$ git branch -a
$ git push origin main
$ git branch -a
$ git log --oneline
$ cd ~/study_git/user2
$ git clone ~/study_git/server/project.git
$ cd ~/study_git/user2/project
$ git branch -vv
$ git branch develop
$ git checkout develop
$ echo -n 'C' >> main.txt
$ touch develop.txt && echo 'header' >> develop.txt && echo 'footer' >> develop.txt
$ git add . && git commit -m "[C] main.txt ABC / develop.txt new"
$ git push -u origin develop
$ git branch -vv
$ cd ~/study_git/user1/project
$ git checkout -b develop
$ git pull origin develop
$ sed -i -e "2i title" develop.txt
$ git add . && git commit -m "[D] develop.txt 2i title"
$ git push origin develop
$ cd ~/study_git/user2/project
$ sed -i -e "2i body" develop.txt
$ git add . && git commit -m "[E] develop.txt 2i body"
$ git fetch origin develop
$ git diff --word-diff FETCH_HEAD..HEAD
$ git merge --no-edit
( user2のdevelop.txtで競合の修正 )
$ git add . && git commit -m "[F] develop.txt merge"
$ git push origin develop
$ cd ~/study_git/user1/project
$ git pull origin develop
$ git checkout main
$ git merge develop
$ git push origin main
$ cd ~/study_git/user2/project
$ git checkout main
$ git pull origin main

- - 1+ - -
$ echo -n 'G' >> main.txt
$ git add . && git commit -m "[G] main.txt ABCG"
$ echo -n 'H' >> main.txt
$ git add . && git commit -m "[H] main.txt ABCGH"
$ git push origin main
$ git log --graph --oneline
```

### - - 2 - -

```
$ mkdir ~/study_git/reset
$ cd ~/study_git/reset
$ git clone ~/study_git/server/project.git
$ cd ~/study_git/reset/project
$ echo -n 'I' >> main.txt
$ git add . && git commit -m "[I] main.txt ABCGHI"
$ git log --oneline -3
$ git reset --soft HEAD^
$ git diff --cached --word-diff
$ git reset --hard 161b3d4
$ git reflog -3
$ git reset --hard HEAD@{1}
$ mkdir ~/study_git/revert && cd ~/study_git/revert
$ git clone ~/study_git/server/project.git
$ cd ~/study_git/revert/project
$ echo -n 'I' >> main.txt
$ git add . && git commit -m "[I] main.txt ABCGHI"
$ git revert --no-edit HEAD
$ git reset --hard HEAD^
$ git revert --no-edit -m 1 b40a708
```

### - - 3 - -

```
/* cherry-pick */
$ mkdir ~/study_git/cherrypick && cd ~/study_git/cherrypick
$ git clone ~/study_git/server/project.git
$ cd ~/study_git/cherrypick/project
$ git checkout -b cherrypick
$ sed -i -e "3i function1" develop.txt && git add . && git commit -m "[I] develop.txt 3i function1"
$ sed -i -e "4i function2" develop.txt && git add . && git commit -m "[J] develop.txt 4i function2"
$ sed -i -e "5i function3" develop.txt && git add . && git commit -m "[K] develop.txt 5i function3"
$ cat develop.txt
$ git log --oneline -3
$ git checkout main
$ git cherry-pick 96e2f96
$ git add . && git commit -m "[L] cherry-pick [J]"
/* stash */
$ mkdir ~/study_git/stash && cd ~/study_git/stash
$ git clone ~/study_git/server/project.git
$ cd ~/study_git/stash/project
$ sed -i -e "3i method1" develop.txt
(バグが発生。対応するために巻き戻す＋作業中の変更は一旦避難)
$ git stash save "stash method1 on the way"
(バグ対応中)
$ git reset --hard HEAD
$ cat develop.txt
$ sed -i -e "3i bug fix" develop.txt && git add . && git commit -m "[I] bug fix"
(もとの作業に戻る)
$ git stash list
$ git stash apply stash@{0}
$ git stash drop stash@{0}
/* tag */
$ mkdir ~/study_git/tag && cd ~/study_git/tag
$ git clone ~/study_git/server/project.git
$ cd ~/study_git/tag/project
$ git log --oneline -6
(タグをつけたいコミットを確認した [C][F][H])
$ git tag v1.0 a32e38a
$ git tag v1.1 b40a708
$ git tag -a v1.2 -m "annotation message" e6c0251
(タグでいろいろ指定)
$ git log --oneline -6
$ git show v1.0
$ git log --oneline v1.0..v1.1
$ git diff --word-diff v1.0..v1.1
/* .gitignore */
$ mkdir -p ~/study_git/ignore/project && cd ~/study_git/ignore/project
$ touch {a.txt,ignore.txt,ignore_a.js,ignore_b.js}
$ mkdir ignoredir && touch ignoredir/ignore2.txt
$ git init
(対象ファイル確認 全部いり)
$ git status
(ファイルを作って書いていくだけ。えでぃたでもいい)
$ touch .gitignore
$ echo 'ignore.txt' > .gitignore
$ echo 'ignore_a.js' >> .gitignore
$ echo 'ignore_b.js' >> .gitignore
$ echo 'ignoredir/' >> .gitignore
$ cat .gitignore
(対象ファイル確認 指定したやつ全部無視)
$ git status
```

### - - 4 - -

```
/* 接続(https) */
$ mkdir ~/study_git/repohttps && cd ~/study_git/repohttps
$ git clone https://github.com/shiohand/project.git
$ cd ~/study_git/repohttps/project
$ git remote -v
$ touch test.txt
$ echo 'test' > test.txt
$ git add . && git commit -m "test"
$ git push origin main
(ログインダイアログがでたらログイン。Macの場合はターミナル)

/* 接続(ssh) */
$ mkdir ~/study_git/repossh && cd ~/study_git/repossh
(ルートに.sshディレクトリが作られ、中にid_rsa(秘密鍵),id_rsa.pub(公開鍵),known_hostsを作成する 既存の場合はバックアップしとき)
(ssh-keygen -t [type] -b [bit])
$ ssh-keygen -t rsa -b 4096
(このファイル名でよいかの確認 良いならエンター)
(Enter passphrase (empty for no passphrase): パス入力)
(Enter same passphrase again: 再入力)
(鍵生成完了 GitHubのsettingで"SSH and GPG keys"に任意のタイトルと公開鍵ファイルの内容の文字列を登録)
$ ssh -T git@github.com
(接続しますかという確認にyesと入力)
(さっきのパス入力で接続完了)
$ git clone git@github.com:shiohand/project.git
(パス入力でクローン完了)
(以降もパス入力が必要なときは入力)

/* プルリクエスト */
$ git checkout -b develop
$ touch app.txt && echo 'start' > app.txt && echo 'end' >> app.txt
$ cat app.txt
$ git add . && git commit -m "develop app"
$ git push origin develop
$ git checkout -b feature-app
$ sed -i -e "2i methodo" app.txt
$ git add . && git commit -m "feature-app app"
$ git push origin feature-app

(GitHub操作)
  Pull requests
    > New pull request
  Comparing changes
    base:develop compare:feature-app
    > Create pull request
  Open a pull request
    > Create pull request
  feature-app app #1
    > feature-app app
      レビューを書く 行をクリック 「method?」
      > Add single comment
  Pull requests
    > feature-app app
      レビューを確認

$ sed -i -e "2c method" app.txt
$ git add . && git commit -m "feature-app app fix"
$ git push origin feature-app

(GitHub操作)
  レビュー画面にfixのが増えているので確認
  Conversation
    > Merge pull request
      > Comfirm merge
        不要なfeature-appブランチについて > Delete branch
  マージしたので、プルリクエストの一覧からなくなる

$ git checkout develop
$ git pull origin develop