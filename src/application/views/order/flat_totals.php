<?php defined('BASEPATH') OR exit('No direct script access allowed');
$sale_year = $this->session->userdata("sale_year");;
// totals.php Chris Dart Apr 21, 2014 2:06:25 PM chrisdart@cerebratorium.com
?>
<!-- order/flat-totals -->
<table class="chart">
<thead>
<tr>
<td>
</td>
<td colspan=3>
<?php echo $sale_year;?>
</td>
<td colspan=3>
<?php echo $sale_year -1;?>
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
<?php foreach($categories["current"] as $category) : ?>
	<tr>
	<td>
	<a href="<?php echo site_url("order/search?find=1&year=$sale_year&category_id=$category->category_id&sorting%5B%5D=genus&direction%5B%5D=ASC");?>"><?php echo $category->category;?></a>
	</td>
	<td><?php echo number_format($category->presale_count,0);?></td>
	<td><?php echo number_format($category->midsale_count+ $category->friday_count+ $category->saturday_count,0);?></td>
	<td style="font-weight:bold"><?php echo number_format($category->presale_count + $category->midsale_count +$category->friday_count+ $category->saturday_count,0);?></td>
	<?php foreach($categories["previous"] as $old_category): ?>
		<?php if($old_category->category == $category->category):?>
			<td><?php echo number_format($old_category->presale_count,0);?></td>
	<td><?php echo number_format($old_category->midsale_count + $old_category->friday_count + $old_category->saturday_count,0);?></td>
	<td  style="font-weight:bold"><?php echo number_format($old_category->presale_count + $old_category->midsale_count  + $old_category->friday_count + $old_category->saturday_count,0);?></td>
		<?php endif;?>
	<?php endforeach;?>
	</tr>
<?php endforeach; ?>
</tbody>
	<tfoot>
	<tr>
		<td colspan="7">
			<div class="message">
				<p>Excluded from these results are any orders marked with "Hide from Flat Counts".
					The default are orders for "bulbs", "bareroots" "tubers", or "seeds" or any orders for the genus "Paeonia" (except for 2021).
				</p>
				<?php if(IS_ADMIN): ?>
				<p>Numbers don't look right? <a href="<?php print site_url('index/reset_flat_exclusions'); ?>" title="Reset flat exclusions to defaults">Click here</a> to reset these.</p>
				<?php endif; ?>
			</div>
		</td>
	</tr>
	</tfoot>
</table>

