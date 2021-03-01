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
    <td>Minimum Price:</td>
    <td><?php echo $form->input('text', ['name' => 'min_price']) ?></td>
  </tr>
  <tr>
    <td>Maximum Price:</td>
    <td><?php echo $form->input('text', ['name' => 'max_price']) ?></td>
  </tr>
  <tr>
  <tr>
    <td>Spicy:</td>
    <td><?php echo $form->select($GLOBALS['spicy_choices'], ['name' => 'is_spicy']) ?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php echo $form->input('submit', ['name' => 'search', 'value' => 'Search']) ?></td>
  </tr>
</table>
</form>