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
	<td class="order-year field"><?=edit_field("year",$order->year,"","order",$order->id,array("envelope"=>"span"));?>
				</td>
	<td class="order-grower_id field"><?=edit_field("year",$order->grower_id,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-catalog_number field"><?=edit_field("year",$order->catalog_number,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-pot_size field"  style="width:10em"><?=$order->pot_size;?>
			</td>
	<td class="order-flat_size field"><?=edit_field("flat_size",$order->flat_size,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-plant_cost field">$<?=edit_field("plant_cost",$plant_cost,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-price field">$<?=edit_field("price",$order->price,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-count_presale field">
			<?=$order->count_presale/$order->flat_size;?>
			</td>
	<td class="order-received_presale field">
	<?=edit_field("received_presale",$order->received_presale,"","order",$order->id,array("envelope"=>"span"));?>
	</td>
	<td class="order-count_midsale field">
			<?=$order->count_midsale/$order->flat_size;?>
	</td>		
	<td class="order-received_midsale field">
		<?=edit_field("received_midsale",$order->received_midsale,"","order",$order->id,array("envelope"=>"span"));?>
	
			</td>
<td class="order-sellout_friday field">
		<?=edit_field("sellout_friday",get_as_time($order->sellout_friday),"","order",$order->id,array("envelope"=>"span","type"=>"time"));?>
</td>
<td class="order-sellout_saturday field">
		<?=edit_field("sellout_saturday",get_as_time($order->sellout_saturday),"","order",$order->id,array("envelope"=>"span","type"=>"time"));?>
</td>
<td class="order-remainder_friday field">
		<?=edit_field("remainder_friday",$order->remainder_friday,"","order",$order->id,array("envelope"=>"span"));?>

</td>
<td class="order-remainder_saturday field">
			<?=edit_field("remainder_saturday",$order->remainder_saturday,"","order",$order->id,array("envelope"=>"span"));?>

</td>
<td class="order-remainder_sunday field">
			<?=edit_field("remainder_sunday",$order->remainder_sunday,"","order",$order->id,array("envelope"=>"span"));?>
</td>
<td class="order-count_dead field">
			<?=edit_field("count_dead",$order->count_dead,"","order",$order->id,array("envelope"=>"span"));?>

			</td>
	
</tr>
