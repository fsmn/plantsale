<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<h1>Welcome to the Friends School Plant Sale Database!</h1>

<p>This could be a landing page with common activities. Maybe a user-configurable page where common tasks could be added as desired.</p>

<p>
<div class="button-bar">
<p><span class="button new common-create">New Common Name</span></p>
</div>
<div style="width:350px;margin:0 auto;">
<h3>Totals</h3>
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
<tr>
<td>
Lowest Price
</td>
<td>
<?=get_as_price($totals->price_range["current"]->min_price);?>
</td>
<td>
<?=get_as_price($totals->price_range["previous"]->min_price);?>
</td>
</tr>
<tr>
<td>
Highest Price
</td>
<td>
<a href="#" title="would show the highest priced plant"><?=get_as_price($totals->price_range["current"]->max_price);?></a>
</td>
<td>
<a href="#"  title="would show the highest priced plant"><?=get_as_price($totals->price_range["previous"]->max_price);?></a>
</td>
</tr>
<tr>
<td>
Average Price
</td>
<td>
<?=get_as_price($totals->price_range["current"]->average_price);?>
</td>
<td>
<?=get_as_price($totals->price_range["previous"]->average_price);?>
</td>
</tr>
<?foreach($totals->categories["current"] as $category) : ?>
	<tr>
	<td>
	<a href="<?=site_url("order/category_totals?category=$category->category");?>"><?=$category->category;?></a>
	</td>
	<td>
	<?=$category->count;?>
	
	</td>
	<td>
	<? //it's clumsy, but it works ?>
	<?foreach($totals->categories["previous"] as $old_category): ?>
		<? if($old_category->category == $category->category):?>
			<?=$old_category->count;?>
		<? endif;?>
	<? endforeach;?>
	</td>
	</tr>
<?endforeach; ?>
</tbody>
</table>
</div>

<!--  how many items (ie. pots) for sale 250,000-size number
how many new colors... 400 or so
how many total colors... 2500 or so
price range (lowest price and highest price, average price(?))
how many in each category
current to past year comparisons by category (number of flats pre-sale current year/previous year)
category space use

-->