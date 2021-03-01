textとselectを受け取って表示する
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  <input type="text" name="product_id">
  <select name="category">
  <option value="ovenmitt">Pot Holder</option>
  <option value="fryingpan">Frying Pan</option>
  <option value="torch">Kitchin Torch</option>
  </select>
  <input type="submit" name="submit">
</form>
送信された結果:<br>
product_id: <?php echo $_POST['product_id'] ?? '未選択' ?><br>
category: <?php echo $_POST['category'] ?? '未選択' ?>