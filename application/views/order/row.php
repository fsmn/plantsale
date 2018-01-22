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

if($order->received_presale == "0.000"){
	
	$row_classes[] = "crop-failure";
}
$row_classes = implode(" ",$row_classes);
?>
<!-- order/row.php -->
<tr
	id="order_<?php echo $order->id;?>"
	class="<?php echo $row_classes;?>">
	<td>
<?php if(IS_EDITOR):?>
			<?php echo create_button(array("text"=>"Edit","href"=>site_url("order/edit/$order->id"),"class"=>array("button","edit","dialog","edit-order"),"id"=>sprintf("edit-order_%s",$order->id)));?>
			
				<?php else: ?>
				<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"href"=>site_url("order/view/$order->id")));?>
				<?php endif; ?>
				<?php if($order->received_presale == "0.000"):?>
				&nbsp;CROP FAILURE&nbsp;
				<?php endif;?>
				</td>
	<td class="order-year field"><?php echo edit_field("year",$order->year,"","order",$order->id,array("envelope"=>"span"));?>
				</td>
	<td class="order-grower_id field"><?php echo edit_field("grower_id",$order->grower_id,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-catalog_number field"><?php echo edit_field("catalog_number",$order->catalog_number,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-pot_size field no-wrap"><?php echo edit_field("pot_size",$order->pot_size,"","order",$order->id,array("envelope"=>"span","class"=>"pot-size"));?>
</td>
	<td
		class="order-flat_size field cost-field"
		id="flat_size"><span
		id="edit-flat-size_<?php echo $order->id;?>"
		class="edit-cost"><?php echo $order->flat_size;?></span></td>
	<td
		class="order-flat_cost field cost-field no-wrap"
		id="flat_cost">$<span
		id="edit-flat-cost_<?php echo $order->id;?>"
		class="edit-cost"><?php echo number_format($order->flat_cost,2);?></span>
	</td>
		<td class="order-flat_area field"><?php echo edit_field("flat_area",$order->flat_area,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td
		class="order-plant_cost field cost-field no-wrap"
		id="plant_cost">$<span
		id="edit-plant-cost_<?php echo $order->id;?>"
		class="edit-cost"><?php echo number_format($order->plant_cost,2);?></span>
	</td>

	<td class="order-price field">$<?php echo edit_field("price",$order->price,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
	<td class="order-count_presale field">
				<?php echo edit_field("count_presale",$order->count_presale,"","order",$order->id,array("envelope"=>"span"));?>

			<!-- <?php echo $order->count_presale/$order->flat_size;?> /-->
	</td>
	<td class="order-received_presale field">
	<?php echo edit_field("received_presale",$order->received_presale,"","order",$order->id,array("envelope"=>"span"));?>
	</td>
	<td class="order-count_midsale field">
				<?php echo edit_field("count_midsale",$order->count_midsale,"","order",$order->id,array("envelope"=>"span"));?>

			<!-- <?php echo $order->count_midsale/$order->flat_size;?> /-->
	</td>
	<td class="order-received_midsale field">
		<?php echo edit_field("received_midsale",$order->received_midsale,"","order",$order->id,array("envelope"=>"span"));?>

			</td>
	<td class="order-sellout_friday field">
		<?php echo edit_field("sellout_friday",get_as_time($order->sellout_friday),"","order",$order->id,array("envelope"=>"span","type"=>"time"));?>
</td>
	<td class="order-sellout_saturday field">
		<?php echo edit_field("sellout_saturday",get_as_time($order->sellout_saturday),"","order",$order->id,array("envelope"=>"span","type"=>"time"));?>
</td>
	<td class="order-remainder_friday field">
		<?php echo edit_field("remainder_friday",$order->remainder_friday,"","order",$order->id,array("envelope"=>"span"));?>

</td>
	<td class="order-remainder_saturday field">
			<?php echo edit_field("remainder_saturday",$order->remainder_saturday,"","order",$order->id,array("envelope"=>"span"));?>

</td>
	<td class="order-remainder_sunday field">
			<?php echo edit_field("remainder_sunday",$order->remainder_sunday,"","order",$order->id,array("envelope"=>"span"));?>
</td>
	<td class="order-count_dead field">
			<?php echo edit_field("count_dead",$order->count_dead,"","order",$order->id,array("envelope"=>"span"));?>

			</td>
			<td>
			<?php if(IS_EDITOR):?>
			<?php echo create_button(array("text"=>"Move","href"=>base_url("order/move/$order->id?ajax=1&start=1"),"class"=>array("button","edit","dialog"), "title"=>"Move this order to a new variety"));?>
			
			<?php endif;?>
			</td>
</tr>
