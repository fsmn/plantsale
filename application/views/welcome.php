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
<table class="chart">
<thead>
<tr>
<td>
</td>
<td>
<?=$sale_year;?>
</td>
<td>
<?=$sale_year -1;?>
</td>
</tr>
</thead>
<tbody>
<tr>
<td>
Total Plants
</td>
<td>
<?=number_format($totals->total["current"]);?>
</td>
<td>
<?=number_format($totals->total["previous"]);?>
</td>
</tr>
<tr>
<td>
New Colors
</td>
<td>
<a href="#" title="would show a list of all new colors"><?=count($totals->new_colors["current"]);?></a>
</td>
<td>
<?=number_format(count($totals->new_colors["previous"]));?>
</td>
</tr>
<tr>
<td>
Total Colors
</td>
<td>
<?=number_format(count($totals->colors["current"]));?>
</td>
<td>
<?=number_format(count($totals->colors["previous"]));?>
</td>
</tr>
</tbody>
</table>
</div>
<div style="float:left">
<?=create_button_bar(array(array("selection"=>"color","text"=>"Show Plant Totals", "class"=>"button show-category-totals")));?>
<div id="category-totals">
</div>
</div>
<!--  how many items (ie. pots) for sale 250,000-size number
how many new colors... 400 or so
how many total colors... 2500 or so
price range (lowest price and highest price, average price(?))
how many in each category
current to past year comparisons by category (number of flats pre-sale current year/previous year)
category space use

-->