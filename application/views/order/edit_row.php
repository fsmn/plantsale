<?php defined('BASEPATH') OR exit('No direct script access allowed');

// row.php Chris Dart Mar 4, 2013 9:25:12 PM chrisdart@cerebratorium.com
?>
<form name="order-row" action="<?=site_url("order/$action");?>" method="post">
<input type="hidden" name="variety_id" value="<?=$variety_id;?>"/>
<table>
	<thead>
		<tr>
			<th>Year</th>
			<th>grower</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Presale Count</th>
			<th>Midsale Count</th>
			<th>Pot Size</th>
			<th>Price</th>
			<th>grower Code</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<tr class="order-row" id="or_<?=$variety_id;?>">
			<td class="order-year field"><input type="text" name="year" value=""/>
			</td>
			<td class="order-grower field"><input type="text" name="grower_id" value=""/>
			</td>
			<td class="order-flat_size field"><input type="text" name="flat_size" value=""/>
			</td>
			<td class="order-flat_cost field"><input type="text" name="flat_cost" value=""/>
			</td>
			<td class="order-plant_cost field"><input type="text" name="plant_cost" value=""/>
			</td>
			<td class="order-count_presale field"><input type="text" name="count_presale" value=""/>
			
			<td class="order-count_midsale field"><input type="text" name="count_midsale" value=""/>
			</td>
			<td class="order-pot_size field"><input type="text" name="pot_size" value=""/>
			</td>
			<td class="order-price field"><input type="text" name="price" value=""/>
			</td>
			<td class="order-grower_code field"><input type="text" name="grower_code" value=""/>
			</td>
			<td>
			<? if(DB_ROLE == 1): ?>
			<input type="submit" value="Add" class="button"/>
			<? endif;?>
			</td>
		</tr>
	</tbody>
</table>
</form>