$GLOBALS['変数名'];
  毎回つける。ローカルに同じ変数があっても分けて使える。
global $変数, $変数2, $変数3;
  これで宣言した変数はそのローカル内での利用が以降全てグローバル。
  しかしそのスコープを出たら無効。
<?php
//$glo変数を上で定義
$glo = 'global';

function local_echo() {
  echo 'start func'."\n";
  if(isset($glo)) { // false
    echo $glo."\n";
  } else {
    echo 'false'."\n";
  }
  echo $GLOBALS['glo']."\n"; // global
  $GLOBALS['glo'] = 'new global';
  $glo = 'local';
  echo $GLOBALS['glo']."\n"; // new global
  echo $glo."\n"; // local

  echo 'end func'."\n";
}

local_echo();
echo $GLOBALS['glo']."\n"; // new global
echo $glo."\n"; // new global GLOBALS使って編集したので

function local_echo2() {
  global $glo;
  $glo = 'new2 global';
  $GLOBALS['glo'] = 'new3 global';
  echo $glo.' '.$GLOBALS['glo']."\n"; // new3 global new3 global
}
local_echo2();
echo $glo.' '.$GLOBALS['glo']."\n"; // new3 global new3 global

function local_echo3() {
  $glo = 'new4 global'; // グローバルじゃない
}
local_echo3();
echo $glo.' '.$GLOBALS['glo']."\n"; // new3 global new3 global
?>
