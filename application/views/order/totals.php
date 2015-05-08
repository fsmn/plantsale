<?php
defined('BASEPATH') or exit('No direct script access allowed');

$sale_year = get_cookie("sale_year");

?>
<!-- order/totals -->
<table class="chart">
	<thead>
		<tr>
			<td></td>
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
			<td>Total Plants</td>
			<td>
<?=number_format($totals->total["current"]);?>
</td>
			<td>
<?=number_format($totals->total["previous"]);?>
</td>
</tr>
<tr>
<td>New varieties</td>
<td>
<a
		href="<?=site_url("variety/find?action%5B%5D=full&year=$sale_year&new_year=$sale_year&sorting%5B%5D=genus&direction%5B%5D=ASC");?>"
		title="Show a list of all varieties ordered new this year (or after a long hiatus)"><?=$totals->new_varieties["current"];?></a>
</td>
<td>
<?=number_format($totals->new_varieties["previous"]);?>
</td>
</tr>
<tr>
<td>Reordered Plants</td>
<td><a
		href="<?=site_url("variety/show_reorders/" . get_cookie("sale_year"));?>"
		title="Show all reodrered plants (no new plants)"><?=number_format(count($totals->varieties["current"])-$totals->new_varieties["current"]);?></a>
</td>
<td>
<?=number_format(count($totals->varieties["previous"]) - $totals->new_varieties["previous"]);?>
</td>
</tr>
		<tr>
			<td>Total varieties</td>
			<td>
<?=number_format(count($totals->varieties["current"]));?>
</td>
			<td>
<?=number_format(count($totals->varieties["previous"]));?>
</td>
		</tr>
	</tbody>
</table>
