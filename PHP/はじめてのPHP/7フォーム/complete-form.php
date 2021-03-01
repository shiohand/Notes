<!-- complete-form.php フォームを出力 -->
<form method="POST" action="<?= $form->encode($_SERVER['PHP_SELF']) ?>">
<table>

  <?php if ($errors) { ?>
    <tr>
      <td>エラー箇所を修正してください</td>
      <td><ul>
          <?php foreach ($errors as $error) { ?>
            <li><?= $form->encode($error) ?></li>
          <?php } ?>
      </ul></td>
    </tr>
    <!-- </tr>閉じタグはテキストになかったけど多分あるので書いておく -->
  <?php } ?>

  <tr>
    <!-- input()を利用。'name' => 'name要素', 'value' => 'value要素' -->
    <td>Your Name:</td><td><?= $form->input('text', ['name' => 'name']) ?></td>
  </tr>

  <tr>
    <td>Size:</td>
    <td><?= $form->input('radio', ['name' => 'size', 'value' => 'small']) ?>Small<br></td>
    <td><?= $form->input('radio', ['name' => 'size', 'value' => 'medium']) ?>Medium<br></td>
    <td><?= $form->input('radio', ['name' => 'size', 'value' => 'large']) ?>Large<br></td>
  </tr>

  <tr>
    <td>Pick one sweet item:</td>
    <td><?= $form->select($GLOBALS['sweets'], ['name' => 'sweet']) ?></td>
  </tr>

  <tr>
    <td>Pick two main dishes:</td>
    <td><?= $form->select($GLOBALS['main_dishes'], ['name' => 'main_dish', 'multiple' => true]) ?></td>
  </tr>

  <tr>
    <td>Do you want your order delivered?</td>
    <td><?= $form->input('checkbox', ['name' => 'delivery', 'value' => 'yes']) ?> Yes </td>
  </tr>

  <tr>
    <td>
      その他のご要望<br>デリバリーをご利用の場合、こちらに配達先住所を入力してください:
    </td>
    <td><?= $form->textarea(['name' => 'comments']) ?></td>
  </tr>

  <tr>
    <td colspan="2" align="center"><?= $form->input('submit', ['value' => '注文']) ?></td>
  </tr>

</table>
</form>