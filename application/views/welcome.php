<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<h1>Welcome to the Friends School Plant Sale Database!</h1>

<p>This could be a landing page with common activities. Maybe a user-configurable page where common tasks could be added as desired.</p>

<p>
<div class="button-bar">
<p><span class="button new common-create">New Common Name</span></p>
</div>
<h3>Totals</h3>

<div style="width:250px;margin:0 auto; float: left;">
<?=create_button_bar(array(array("selection"=>"order","text"=>"Show Order Totals","href"=>"#order-totals-end","class"=>"button show-order-totals")));?>
<div id="order-totals">
</div>
<div id="order-totals-end"></div>

</div>
<div style="float:left; width: 250px;">
<?=create_button_bar(array(array("selection"=>"variety","text"=>"Show Category Totals","href"=>"#category-totals-end", "class"=>"button show-category-totals")));?>
<div id="category-totals">
</div>
<div id="category-totals-end"></div>
</div>
<div style="float:left; width: 250px">
<?=create_button_bar(array(array("selection"=>"variety","text"=>"Show Flat Totals","href"=>"#flat-totals-end", "class"=>"button show-flat-totals")));?>
<div id="flat-totals">
</div>
<div id="flat-totals-end"></div>
</div>
