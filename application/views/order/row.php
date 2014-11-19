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

$row_classes = array();
$row_classes[] = has_price_discrepancy($order);

if($order->crop_failure == 1){
	$row_classes[] = "crop-failure";
}
$row_classes = implode(" ",$row_classes);
?>
<!-- order/row.php -->
<tr
	id="order_<?=$order->id;?>"
	class="<?=$row_classes;?>">
	<td>
<? if(IS_EDITOR):?>
			<span
		class="button edit edit-order"
		id="<? printf("edit-order_%s",$order->id);?>">Edit</span>
				<? else: ?>
				 <a
		href="<?=site_url("order/view/$order->id");?>"
		class="button">View</a>
				<? endif; ?>
				<?php if($order->crop_failure):?>
				&nbsp;CROP FAILURE&nbsp;
				<?php endif;?>
				</td>
	<td class="order-year field"><?=edit_field("year",$order->year,"","order",$order->id,array("envelope"=>"span"));?>
				</td>
	<td class="order-grower_id field"><?=edit_field("grower_id",$order->grower_id,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-catalog_number field"><?=edit_field("catalog_number",$order->catalog_number,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-pot_size field no-wrap"><?=edit_field("pot_size",$order->pot_size,"","order",$order->id,array("envelope"=>"span","class"=>"pot-size-menu"));?>
</td>
	<td
		class="order-flat_size field"
		id="flat_size"><span
		id="edit-flat-size_<?=$order->id;?>"
		class="edit-cost"><?=$order->flat_size;?></span></td>
	<td
		class="order-flat_cost field no-wrap"
		id="flat_cost">$<span
		id="edit-flat-cost_<?=$order->id;?>"
		class="edit-cost"><?=$order->flat_cost;?></span>
	</td>
	<td
		class="order-plant_cost field no-wrap"
		id="plant_cost">$<span
		id="edit-plant-cost_<?=$order->id;?>"
		class="edit-cost"><?=$order->plant_cost;?></span>
	</td>
	<td class="order-plant_cost field">$<?=edit_field("plant_cost",$plant_cost,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-price field">$<?=edit_field("price",$order->price,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-count_presale field">
				<?=edit_field("count_presale",$order->count_presale,"","order",$order->id,array("envelope"=>"span"));?>

			<!-- <?=$order->count_presale/$order->flat_size;?> /-->
	</td>
	<td class="order-received_presale field">
	<?=edit_field("received_presale",$order->received_presale,"","order",$order->id,array("envelope"=>"span"));?>
	</td>
	<td class="order-count_midsale field">
				<?=edit_field("count_midsale",$order->count_midsale,"","order",$order->id,array("envelope"=>"span"));?>

			<!-- <?=$order->count_midsale/$order->flat_size;?> /-->
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
