<?php defined('BASEPATH') OR exit('No direct script access allowed');
$sale_year = get_cookie("sale_year");
// totals.php Chris Dart Apr 21, 2014 2:06:25 PM chrisdart@cerebratorium.com
?>
<table class="chart">
<thead>
<tr>
<td>
</td>
<td colspan=3>
<?=$sale_year;?>
</td>
<td colspan=3>
<?=$sale_year -1;?>
</td>
</tr>
<tr>
<td></td>
<td>Pre</td>
<td>Mid</td>
<td  style="font-weight:bold">Total</td>
<td>Pre</td>
<td>Mid</td>
<td  style="font-weight:bold">Total</td>
</tr>

</thead>
<tbody>
<? foreach($categories["current"] as $category) : ?>
	<tr>
	<td>
	<a href="<?=site_url("order/search?year=$sale_year&category=$category->category&sorting%5B%5D=genus&direction%5B%5D=ASC");?>"><?=$category->category;?></a>
	</td>
	<td><?=number_format($category->presale_count,0);?></td>
	<td><?=number_format($category->midsale_count,0);?></td>
	<td style="font-weight:bold"><?=number_format($category->presale_count + $category->midsale_count,0);?></td>
	<? //it's clumsy, but it works ?>
	<?foreach($categories["previous"] as $old_category): ?>
		<? if($old_category->category == $category->category):?>
			<td><?=number_format($old_category->presale_count,0);?></td>
	<td><?=number_format($old_category->midsale_count,0);?></td>
	<td  style="font-weight:bold"><?=number_format($old_category->presale_count + $old_category->midsale_count ,0);?></td>
		<? endif;?>
	<? endforeach;?>
	</tr>
<?endforeach; ?>
</tbody>
</table>
