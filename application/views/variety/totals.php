<?php defined('BASEPATH') OR exit('No direct script access allowed');
$sale_year = get_cookie("sale_year");
// totals.php Chris Dart Apr 21, 2014 2:06:25 PM chrisdart@cerebratorium.com
?>
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
<? foreach($categories["current"] as $category) : ?>
	<tr>
	<td>
	<a href="<?=site_url("order/totals?category=$category->category&sorting%5B%5D=catalog_number&direction%5B%5D=ASC");?>"><?=$category->category;?></a>
	</td>
	<td>
	<?=$category->count;?>

	</td>
	<td>
	<? //it's clumsy, but it works ?>
	<?foreach($categories["previous"] as $old_category): ?>
		<? if($old_category->category == $category->category):?>
			<?=$old_category->count;?>
		<? endif;?>
	<? endforeach;?>
	</td>
	</tr>
<?endforeach; ?>
</tbody>
</table>