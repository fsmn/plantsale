<?php defined('BASEPATH') OR exit('No direct script access allowed');

$buttons[] = array("selection" => "color",
		"text" => "Edit",
		"class" => array("button edit color_edit"),
		"id" => "ce_$color->id",
		"title" => "Edit this color");
echo create_button_bar($buttons);


?>
<input
	type="hidden" id="id" name="id" value="<?=$color->id;?>" />
<input
	type="hidden" id="order_id" name="order_id" value="<?=$color->order_id;?>" />
<h2>
	<?="$color->common_name: $color->name";?>
</h2>
<fieldset class="block color-info">
	<legend>General Info</legend>
	<p>
		<label>Common Name:</label>
		<?=$color->common_name;?>
		<a href="<?=site_url("common/view/$color->common_id");?>"
			title="View details for <?=$color->common_name;?>">Details</a>
	</p>
	<p class="name">
		<label>Color Name: </label> <span class="edit-field"><?=$color->name;?>
		</span>
	</p>
	<p class="color">
		<label>Color: </label> <span class="edit-field"><?=$color->color; ?> </span>
	</p>
	<p class="species">
		<label>Species: </label> <span class="edit-field"><?=$color->species; ?>
		</span>
	</p>
	<p class="latin_name">
		<label>Latin Name: </label> <span class="edit-field"><?=$color->latin_name; ?>
		</span>
	</p>
	<p class="category">
		<label>Category: </label> <span class="edit-field"><?=$color->category; ?>
		</span>
	</p>
	<p class="description">
		<label>Description: </label> <span class="edit-field"><?=$color->description; ?>
		</span>
	</p>
	<p class="note">
		<label>Color Notes: </label> <span class="edit-field"><?=$color->note; ?>
		</span>
	</p>
</fieldset>
<fieldset class="order-info block">
	<legend>
		Order Info for
		<?=get_current_year();?>
	</legend>
	<?=create_edit_field("vendor_id", $color->vendor_id, "Vendor Id");?>
	<?=create_edit_field("year", $color->year, "Year");?>
	<?=create_edit_field("flat_size", $color->flat_size, "Flat Size");?>


	<? if($color->flat_cost && !$color->plant_cost){
		$plant_cost = $flat_cost/$flat_size;
		$flat_cost = $color->flat_cost;
	}elseif($color->plant_cost && !$color->flat_cost){
		$plant_cost = $color->plant_cost;
		$flat_cost = $color->plant_cost * $color->flat_size;
	}else{
		$plant_cost = $color->plant_cost;
		$flat_cost = $color->flat_cost;
	}
	?>
	<?=create_edit_field("flat_size", $color->flat_size, "Flat Size");?>
	<?=create_edit_field("flat_cost",get_as_price($flat_cost), "Flat Cost");?>
	<?=create_edit_field("plant_cost", get_as_price($plant_cost), "Plant Cost");?>
	<?=create_edit_field("price", get_as_price($color->price), "Sale Price");?>
	<?=create_edit_field("pot_size", $color->pot_size, "Pot Size");?>
	<?=create_edit_field("count_presale",$color->count_presale, "Presale Count");?>
	<?=create_edit_field("count_midsale",$color->count_midsale, "Midsale Count");?>
	<?=create_edit_field("sellout_friday", $color->sellout_friday, "Friday Sellout");?>
	<?=create_edit_field("remainder_friday", $color->remainder_friday, "Friday Remainder");?>
	<?=create_edit_field("sellout_saturday", $color->sellout_saturday, "Saturday Sellout");?>
	<?=create_edit_field("remainder_saturday", $color->remainder_saturday, "Saturday Remainder");?>
	<?=create_edit_field("remainder_sunday", $color->remainder_sunday, "Sunday Remainder");?>
	<?=create_edit_field("dead_count", $color->dead_count, "Dead Count");?>
	<?=create_edit_field("vendor_code", $color->vendor_code, "Vendor Code");?>
</fieldset>


