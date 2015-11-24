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
	<a href="<?=site_url("order/search?find=1&category_id=$category->id&sorting%5B%5D=genus&direction%5B%5D=ASC&year=$sale_year");?>"><?=$category->category;?></a>
	</td>
	<td>
	<?=number_format($category->count,0);?>

	</td>
	<td>
	<? //it's clumsy, but it works ?>
	<?foreach($categories["previous"] as $old_category): ?>
		<? if($old_category->category == $category->category):?>
			<?=number_format($old_category->count,0);?>
		<? endif;?>
	<? endforeach;?>
	</td>
	</tr>
<?endforeach; ?>
</tbody>
</table>
