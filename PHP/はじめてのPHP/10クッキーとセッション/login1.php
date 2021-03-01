<?php
require '../tstform/FormHelper.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors, $input) = validate_form();
  if ($errors) {
    show_form($errors);
  } else {
    process_form($input);
  }
} else {
  show_form();
}

function show_form($errors = array()) {
  $form = new FormHelper();

  if ($errors) {
    $errorHtml = '<ul><li>';
    $errorHtml .= implode('</li><li>', $errors);
    $errorHtml .= '</li</ul>';
  } else {
    $errorHtml = '';
  }

  print <<<_FORM_
  <form method="POST" action="{$form->encode($_SERVER['PHP_SELF'])}">
    $errorHtml
    Username: {$form->input('text', ['name' => 'username'])} <br>
    Password: {$form->input('password', ['name' => 'password'])} <br>
    {$form->input('submit', ['value' => 'Log In'])}
  </form>
  _FORM_;
}

function validate_form() {
  $input = array();
  $errors = array();

  $users = array('alice' => 'dog123', 'bob' => 'my^pwd', 'charlie' => '**fun**');

  $input['username'] = $_POST['username'] ?? '';
  if (! array_key_exists($input['username'], $users)) {
    $errors[] = '正確なusernameとpasswordを入力してください';
  } else {
    $saved_password = $users[$input['username']];
    $submitted_password = $_POST['password'] ?? '';
    if ($saved_password != $submitted_password) {
      $errors[] = '正確なusernameとpasswordを入力してください';
    }
  }
  return array($errors, $input);
}

function process_form($input) {
  $_SESSION['username'] = $input['username'];
  print 'Welcome, '.$_SESSION['username'];
}
?>
