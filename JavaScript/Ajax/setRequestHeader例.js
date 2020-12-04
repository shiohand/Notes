const xhr = new XMLHttpRequest();

function post() {
  xhr.open('POST', 'to.php');
  xhr.setRequestHeader(
    'content-type',
    'application/x-www-form-uelencoded;charset=UTF-8'
  );
  xhr.send(`name=${encodeURIComponent(name)}`);
}