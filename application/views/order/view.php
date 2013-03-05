<?php defined('BASEPATH') OR exit('No direct script access allowed');

// view.php Chris Dart Mar 4, 2013 9:14:14 PM chrisdart@cerebratorium.com
?>
<div class="grouping order-info block" id="order">
<h3>
Order Info for
		<?=get_current_year();?>
	</h3>
	<div class="column column-odd">
		<?=create_edit_field("vendor_id", $current_order->vendor_id, "Vendor Id");?>
		<?=create_edit_field("year", $current_order->year, "Year");?>
		<?=create_edit_field("flat_size", $current_order->flat_size, "Flat Size");?>


		<? if($current_order->flat_cost && !$current_order->plant_cost){
			$plant_cost = $current_order->flat_cost/$current_order->flat_size;
			$flat_cost = $current_order->flat_cost;
		}elseif($current_order->plant_cost && !$current_order->flat_cost){
		$plant_cost = $current_order->plant_cost;
		$flat_cost = $current_order->plant_cost * $current_order->flat_size;
	}else{
		$plant_cost = $current_order->plant_cost;
		$flat_cost = $current_order->flat_cost;
	}
	?>
		<?=create_edit_field("flat_cost", get_as_price($flat_cost), "Flat Cost", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("plant_cost", get_as_price($plant_cost), "Plant Cost", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("price", get_as_price($current_order->price), "Sale Price", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("pot_size", $current_order->pot_size, "Pot Size");?>
	</div>
	<div class="column column-even">
		<?=create_edit_field("count_presale",$current_order->count_presale, "Presale Count");?>
		<?=create_edit_field("count_midsale",$current_order->count_midsale, "Midsale Count");?>
		<?=create_edit_field("sellout_friday", $current_order->sellout_friday, "Friday Sellout");?>
		<?=create_edit_field("remainder_friday", $current_order->remainder_friday, "Friday Remainder");?>
		<?=create_edit_field("sellout_saturday", $current_order->sellout_saturday, "Saturday Sellout");?>
		<?=create_edit_field("remainder_saturday", $current_order->remainder_saturday, "Saturday Remainder");?>
		<?=create_edit_field("remainder_sunday", $current_order->remainder_sunday, "Sunday Remainder");?>
		<?=create_edit_field("count_dead", $current_order->count_dead, "Dead Count");?>
		<?=create_edit_field("vendor_code", $current_order->vendor_code, "Vendor Code");?>
	</div>
</div>