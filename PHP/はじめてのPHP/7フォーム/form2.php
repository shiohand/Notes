selectをmultipleで利用する
nameに配列を指定することで複数選択がまとめられる
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <select name="lunch[]" multiple>
  <option value="potk">BBQ Pork Bun</option>
  <option value="chicken">Chicken Bun</option>
  <option value="lotus">Lotus Bun</option>
  <option value="bean">Bean Bun</option>
  <option value="nest">Bird-Nest Bun</option>
  </select>
  <input type="submit" name="submit">
</form>
送信された結果:<br>
<?php
if (isset($_POST['lunch'])) {
  foreach ($_POST['lunch'] as $choice) {
    print "You want a $choice bun. <br>";
  }
}
?>