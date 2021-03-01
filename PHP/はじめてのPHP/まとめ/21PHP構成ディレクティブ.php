構成ディレクティブの変更
  php.ini (ファイルの場所はphpinfo()から確認できる)
  Apache の httpd.conf や htaccess構成ファイル
  PHPプログラム内
  .user.ini (サーバーがCGIやFastCGIを使用している場合)
phpinfo()
単体で実行するだけでPHPのバージョンとか全部表示する出力をしてくれる

httpd.conf
  だいたいphp.iniと同じだが、構成ディレクティブの名前の前にphp_valueとかphp_flagとか、値の形式が書いてある
例
// ; 注意以外のすべてのエラーを報告する
// php_value error_reporting "E_ALL & ~E_NOTICE"
// 
// ; エラーログにエラーを記録する
// php_flag log_errors On

プログラム内で変更
  ini_set(構成ディレクティブ名, 値) // 設定値がOn/Offの場合は1/0を渡す
  ini_get(構成ディレクティブ名)もあるよ


知って楽しい構成ディレクティブ抜粋(楽しくない)
allow_url_fopen
auto_append_file auto_prepend_file
date.timezone
display_errors
error_reporting
extension
extension_dir
file_uploads
include_path
log_errors
output_buffering
session.suto_start
session.gc_maxlifetime
session.gc_probability
short_open_tag
track_errors
upload_max_filesize