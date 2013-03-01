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
	type="hidden" id="order_id" name="order_id"
	value="<?=$color->order_id;?>" />
<h2>
	<?="$color->common_name: $color->name";?>
</h2>
<fieldset class="block color-info" id="color">
	<legend>General Info</legend>
	<p>
		<label>Common Name:</label>
		<?=$color->common_name;?>
		<a href="<?=site_url("common/view/$color->common_id");?>"
			title="View details for <?=$color->common_name;?>" class="button">Details</a>
	</p>
	<?=create_edit_field("name", $color->name, "Name");?>

	<?=create_edit_field("color", $color->color, "Color");?>

	<?=create_edit_field("species", $color->species, "Species");?>

	<?=create_edit_field("latin_name", $color->latin_name, "Latin Name");?>

	<p class="category">
		<label>Category: </label>
		<?=$color->category; ?>
	</p>
	<p class="description">
		<label>Description: </label>
		<?=$color->description; ?>
	</p>
	<?=create_edit_field("note", $color->note, "Note");?>

</fieldset>
<fieldset class="order-info block" id="order">
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
	<?=create_edit_field("count_dead", $color->count_dead, "Dead Count");?>
	<?=create_edit_field("vendor_code", $color->vendor_code, "Vendor Code");?>
</fieldset>
