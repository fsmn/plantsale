<?php defined('BASEPATH') OR exit('No direct script access allowed');

$buttons[] = array("selection" => "color",
		"text" => "Edit",
		"class" => array("button edit color_edit"),
		"id" => "ce_$color->id",
		"title" => "Edit this color");
echo create_button_bar($buttons);

print_r($color);

?>
<input
	type="hidden" id="id" name="id" value="<?=$color->id;?>" />
<h2>
	<?="$color->common_name: $color->name";?>
</h2>
<fieldset class="block color-info">
	<legend>General Info</legend>
	<p>
		<label>Common Name:</label>
		<?=$color->common_name;?>
	</p>
	<p>
		<label>Color Name: </label>
		<?=$color->name;?>
	</p>
	<p>
		<label>Color: </label>
		<?=$color->color; ?>
	</p>
	<p>
		<label>Species: </label>
		<?=$color->species; ?>
	</p>
	<p>
		<label>Latin Name: </label>
		<?=$color->latin_name; ?>
	</p>
	<p>
		<label>Category: </label>
		<?=$color->category; ?>
	</p>
	<p>
		<label>Description: </label>
		<?=$color->description; ?>
	</p>
	<p>
		<label>Color Notes: </label>
		<?=$color->note; ?>
	</p>
</fieldset>
<fieldset class="order-info block">
	<legend>
		Order Info for
		<?=get_current_year();?>
	</legend>
	<p>
		<label>Vendor:</label>
		<?=$color->vendor_id;?>
	</p>
	<p>
		<label>Year:</label>
		<?=$color->year;?>
	</p>
	<p>
		<label>Flat Size:</label>
		<?=$color->flat_size;?>
	</p>
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
	<p>
		<label>Flat Size:</label>
		<?=$color->flat_size;?>
	</p>
	<p>
		<label>Flat Cost: </label>
		<?=get_as_price($flat_cost);?>
	</p>
	<p>
		<label>Plant Cost: </label>
		<?=get_as_price($plant_cost);?>
	</p>
	<p>
		<label>Sale Price: </label>
		<?=get_as_price($color->price);?>
	</p>

</fieldset>
