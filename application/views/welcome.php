<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<h1>Welcome to the Friends School Plant Sale Database!</h1>

<p>This could be a landing page with common activities. Maybe a user-configurable page where common tasks could be added as desired.</p>

<p>
<div class="button-bar">
<p><span class="button new common-create">New Common Name</span></p>
</div>
<h3>Totals</h3>

<div style="width:350px;margin:0 auto; float: left;">
<?=create_button_bar(array(array("selection"=>"order","text"=>"Show Order Totals","class"=>"button show-order-totals")));?>
<div id="order-totals">
</div>
</div>
<div style="float:left; width: 350px;">
<?=create_button_bar(array(array("selection"=>"variety","text"=>"Show Category Totals", "class"=>"button show-category-totals")));?>
<div id="category-totals">
</div>
</div>
<div style="float:left; width: 350px">
<?=create_button_bar(array(array("selection"=>"variety","text"=>"Show Flat Totals", "class"=>"button show-flat-totals")));?>
<div id="flat-totals">
</div>
</div>
<!--  how many items (ie. pots) for sale 250,000-size number
how many new varieties... 400 or so
how many total varieties... 2500 or so
price range (lowest price and highest price, average price(?))
how many in each category
current to past year comparisons by category (number of flats pre-sale current year/previous year)
category space use

-->