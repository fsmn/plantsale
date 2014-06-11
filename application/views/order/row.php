<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$flat_cost = $order->flat_cost;
$plant_cost = $order->plant_cost;
if ($order->flat_cost && ! $order->plant_cost) {
	$flat_cost = $order->flat_cost;
	$plant_cost = $order->flat_size / $order->flat_cost;
} elseif ($order->plant_cost && ! $order->flat_cost) {
	$plant_cost = $order->plant_cost;
	$flat_cost = $order->flat_size * $order->plant_cost;
}
?>


<tr id="order_<?=$order->id;?>">
	<td class="order-year field"><?=$order->year;?>
				</td>
	<td class="order-grower_id field"><?=$order->grower_id;?>
			</td>
	<td class="order-catalog_number field">
			<?=$order->catalog_number;?>
			</td>
	<td class="order-pot_size field"  style="width:10em"><?=$order->pot_size;?>
			</td>
	<td class="order-flat_size field"><?=$order->flat_size;?>
			</td>
	<td class="order-plant_cost field"><?=get_as_price($plant_cost);?>
			</td>
	<td class="order-price field"><?=get_as_price($order->price);?>
			</td>
	<td class="order-count_presale field">
			<?=$order->count_presale/$order->flat_size;?>
			</td>
	<td class="order-count_midsale field">
			<?=$order->count_midsale/$order->flat_size;?>
			</td>
				<td class="order-received_presale field">
			<?=$order->received_presale;?>
			</td>
	<td class="order-received_midsale field">
			<?=$order->received_midsale;?>
			</td>
<td class="order-sellout_friday field">
	<?=get_as_time($order->sellout_friday);?>
</td>
<td class="order-sellout_saturday field">
	<?=get_as_time($order->sellout_saturday);?>
</td>
<td class="order-remainder_friday field">
	<?=$order->remainder_friday;?>
</td>
<td class="order-remainder_saturday field">
	<?=$order->remainder_saturday;?>
</td>
<td class="order-remainder_sunday field">
	<?=$order->remainder_sunday;?>
</td>
<td class="order-count_dead field"><?=$order->count_dead;?>
			</td>
	
</tr>
