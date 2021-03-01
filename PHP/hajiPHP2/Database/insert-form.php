<form action="<?php echo $form->encode($_SERVER['PHP_SELF']) ?>" method="post">
<table>
  <?php if ($errors) { ?>
    <tr>
      <td>You need to correct the following errors:</td>
      <td>
        <ul>
          <?php foreach ($errors as $error) { ?>
          <li><?php echo $form->encode($error) ?></li>
          <?php } ?>
        </ul>
      </td>
    </tr>
  <?php } ?>
  <tr>
    <td>Dish Name:</td>
    <td><?php echo $form->input('text', ['name' => 'dish_name']) ?></td>
  </tr>
  <tr>
    <td>Dish Price:</td>
    <td><?php echo $form->input('text', ['name' => 'price']) ?></td>
  </tr>
  <tr>
    <td>Spicy:</td>
    <td><?php echo $form->input('checkbox', ['name' => 'is_spicy', 'value' => 'yes']) ?> Yes </td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php echo $form->input('submit', ['name' => 'save', 'value' => 'Order']) ?></td>
  </tr>
</table>
</form>