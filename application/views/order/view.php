<?php defined('BASEPATH') OR exit('No direct script access allowed');
// view.php Chris Dart Mar 4, 2013 9:14:14 PM chrisdart@cerebratorium.com
?>
<div class="block">
<h3>Order Info for 
<?=$order->color;?>, <?=get_current_year();?>
</h3>

<p>
<label>Color: </label><?=$order->color;?> 
<a href="<?=site_url("color/view/$order->color_id");?>" class="button">View</a>
</p>
</div>
<input type="hidden" id="order_id" value="<?=$order->id;?>" name="order_id"/>
<div class="grouping order-info block" id="order">

	<div class="column column-odd">
		<?=create_edit_field("vendor_id", $order->vendor_id, "Vendor Id");?>
		<?=create_edit_field("year", $order->year, "Year", array("envelope"=>"div"));?>
		<?=create_edit_field("flat_size", $order->flat_size, "Flat Size");?>


		<? if($order->flat_cost && !$order->plant_cost){
				$plant_cost = $order->flat_cost/$order->flat_size;
				$flat_cost = $order->flat_cost;
			}elseif($order->plant_cost && !$order->flat_cost){
				$plant_cost = $order->plant_cost;
				$flat_cost = $order->plant_cost * $order->flat_size;
			}else{
				$plant_cost = $order->plant_cost;
				$flat_cost = $order->flat_cost;
			}
	?>
		<?=create_edit_field("flat_cost", get_as_price($flat_cost), "Flat Cost", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("plant_cost", get_as_price($plant_cost), "Plant Cost", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("price", get_as_price($order->price), "Sale Price", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("pot_size", $order->pot_size, "Pot Size");?>
	</div>
	<div class="column column-even">
		<?=create_edit_field("count_presale",$order->count_presale, "Presale Count");?>
		<?=create_edit_field("count_midsale",$order->count_midsale, "Midsale Count");?>
		<?=create_edit_field("sellout_friday", $order->sellout_friday, "Friday Sellout");?>
		<?=create_edit_field("remainder_friday", $order->remainder_friday, "Friday Remainder");?>
		<?=create_edit_field("sellout_saturday", $order->sellout_saturday, "Saturday Sellout");?>
		<?=create_edit_field("remainder_saturday", $order->remainder_saturday, "Saturday Remainder");?>
		<?=create_edit_field("remainder_sunday", $order->remainder_sunday, "Sunday Remainder");?>
		<?=create_edit_field("count_dead", $order->count_dead, "Dead Count");?>
		<?=create_edit_field("vendor_code", $order->vendor_code, "Vendor Code");?>
	</div>
</div>
