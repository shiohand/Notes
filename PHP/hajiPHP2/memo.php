<?php
$zipcode = trim($_POST['zipcode']);
$zip_length = strlen($zipcode);
if ($zip_length != 5) {
  print "Please enter a ZIP code that is 5 character long.";
}
?>
<?php
if (strlen(trim($_POST['zipcode'])) != 5) {
  print "Please enter a ZIP code that is 5 character long.";
}
if ($_POST['email'] == 'president@whitehouse.gov') {
  print "Welcome, Mr. President.";
}
if (strcasecmp($_POST['email'], 'president@whitehouse.gov') == 0) {
  print "Welcome, Mr. President.";
}
?>
<?php
$price = 5;
$tax = 0.075;
printf('The dish costs $%.2f', $price * (1 + $tax)); // $5.38
?>
<?php
print substr($_POST['comments'], 0, 30).'...';
print 'Card: XX'.substr($_POST['card'], -4, 4); // substr(文字列, -x, x) → 末尾x文字
?>
<?php
$my_class = 'lunch';
$html = '<span class="{class}">Fried Bean Curd</span>
<span class="{class}">Oil-Soaked Fish</span>';
print str_replace('{class}', $my_class, $html)
?>
<?php
if ($logged_in) {
  print "Welcome aboard, trusted user.";
} else if ($new_messages) {
  print "Dear stranger, there are new messages.";
} else if ($emergency) {
  print "Stranger, there are no news messages, but there is an emergency.";
} else {
  print "I don't know you, you have no messages, and there's no emergency.";
}
?>
<?php
print '<select name="people">';
$i = 1;
while ($i <= 10) {
  print "<option>$i</option>\n";
  $i++;
}
print '</selece>';
?>
<?php
print '<select name="doughnuts">';
// <option>1 - 10</option> 10ずつ増やす 50まで
for($min = 1, $max = 10; $max <= 50; $min += 10, $max += 10) {
  print "<option>$min - $max</option>\n";
}
print '</select>';
?>
<?php
$row_styles = ['even', 'odd']; // 偶数行と奇数行でクラスを変えたい
$style_index = 0;
$meal = ['breakfast' => 'Walnut Bun', 'lunch' => 'Cashew Nuts and White Mushrooms', 'snack' => 'DriedMulberries', 'dinner' => 'Eggplant with Chili Sauce'];
print "<table>\n";
foreach ($meal as $key => $value) {
  print '<tr class="'.$row_styles[$style_index].'">'; // class="even" と class="odd" の繰り返し
  print "<td>$key</td><td>$value</td></tr>\n";
  $style_index = 1 - $style_index; // 0のとき1, 1のとき0
}
print '</table>';
?>
<?php
$dinner = ['Sweet Corn and Asparagus', 'Lemon Chicken', 'Braised Bamboo Fungus'];
for ($i = 0, $num_dishes = count($dinner); $i < $num_dishes; $i++) {
  print "Dish number $i is $dinner[$i]\n";
}
?>
<?php
$row_styles = ['even', 'odd']; // 偶数行と奇数行でクラスを変えたい
$style_index = 0;
$meal = ['breakfast' => 'Walnut Bun', 'lunch' => 'Cashew Nuts and White Mushrooms', 'snack' => 'DriedMulberries', 'dinner' => 'Eggplant with Chili Sauce'];
print "<table>\n";
for ($i=0; $i < count($dinner); $i++) { 
  print '<tr>class="'.$row_styles[$style_index].'"';
  print "<td>Element $i</td><td>$dinner[$i]</td></tr>\n";
}
print '</table>';
?>
<?php
$meals - ['Walnut Bun' => 1, 'Cashew Nuts and White Mushrooms' => 4.95, 'Dried Mulberries' => 3.00, 'Eggplant withChiliSauce' => 6.50, 'Shrimp Puffs' => 0];
$books = ["The Easter's Guide to Chinese Characters", "How to Cook and Eat in Chinese"];

if (array_key_exists('Shrimp Puffs', $meals)) {
  print 'true';
}
if (array_key_exists('Steak Sandwich', $meals)) {
  print 'false';
}
if (array_key_exists(1, $books)) {
  print 'true';
}
if (in_array(3, $meals)) {
  print 'true';
}
if (in_array('How to Cook and Eat in Chinese', $books)) {
  print 'true';
}
if (in_array("the easter's guide to chinese characters", $books)) {
  print 'false';
}
?>
<?php
$specials = [
  ['Chestnut Bun', 'Walnut Bun', 'Peanut Bun'],
  ['Chestnut Salad', 'Walnut Salad', 'Peanut Salad']
];
for ($i=0; $i < count($specials); $i++) { 
  for ($m=0; $m < count($specials[$i]); $m++) { 
    print "Element [$i][$m] is {$specials[$i][$m]}\n";
  }
}
?>