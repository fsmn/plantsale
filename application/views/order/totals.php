<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

$sale_year = get_cookie("sale_year");


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
New varieties
</td>
<td>
<a href="#" title="would show a list of all new varieties"><?=count($totals->new_varieties["current"]);?></a>
</td>
<td>
<?=number_format(count($totals->new_varieties["previous"]));?>
</td>
</tr>
<tr>
<td>
Total varieties
</td>
<td>
<?=number_format(count($totals->varieties["current"]));?>
</td>
<td>
<?=number_format(count($totals->varieties["previous"]));?>
</td>
</tr>
</tbody>
</table>
