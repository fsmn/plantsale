<?php defined('BASEPATH') OR exit('No direct script access allowed');

// color_order.php Chris Dart Mar 4, 2013 8:44:25 PM chrisdart@cerebratorium.com
if($orders):
?>

<table class="list">
	<thead>
		<tr>
			<th>Year</th>
			<th>Vendor</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Presale Count</th>
			<th>Midsale Count</th>
			<th>Total Plants</th>
			<th>Pot Size</th>
			<th>Price</th>
			<th>Vendor Code</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($orders as $order): ?>
		<tr class="grouping" id="order_<?=$order->id;?>">
			<td class="order-year field"><?=$order->year;?>
			</td>
			<td class="order-vendor field"><?=$order->vendor_id;?>
			</td>
			<td class="order-flat_size field"><?=$order->flat_size;?>
			</td>
			<td class="order-flat_cost field"><?=get_as_price($order->flat_cost);?>
			</td>
			<td class="order-plant_cost field"><?=get_as_price($order->plant_cost);?>
			</td>
			<td class="order-count_presale field"><?=$order->count_presale;?>
			
			<td class="order-count_midsale field"><?=$order->count_midsale;?>
			</td>
			<td class="order-total_plants field"><?=$order->count_midsale + $order->count_presale;?>
			</td>
			<td class="order-pot_size field"><?=$order->pot_size;?>
			</td>
				<td class="order-price field"><?=get_as_price($order->price);?>
			</td>
			<td class="order-vendor_code field"><?=$order->vendor_code;?>
			</td>
		</tr>
		<? endforeach;?>
	</tbody>
</table>
<? endif;
