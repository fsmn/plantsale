<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<input
	type="hidden" id="id" name="id" value="<?=$color->id;?>" />
<input type="hidden" id="order_id"
	name="order_id" value="<?=$color->order_id;?>" />
<h2>
	<?="$color->common_name: $color->color";?>
</h2>
<?=$color->common_id;?>
<fieldset class="block color-info" id="color">
	<legend>General Info</legend>
	<p>
		<label>Common Name:</label> <span class="field"><?=$color->common_name;?>
		</span> <a href="<?=site_url("common/view/$color->common_id");?>"
			title="View details for <?=$color->common_name;?>" class="button">Details</a>
	</p>

	<?=create_edit_field("color", $color->color, "Color");?>

	<?=create_edit_field("species", $color->species, "Species");?>
	<p class="category">
		<label>Category: </label> <span class="field"><?=$color->category; ?>
		</span>
	</p>
	<p class="description">
		<label>Description: </label> <span class="field"><?=$color->description; ?>
		</span>
	</p>
	<?=create_edit_field("note", $color->note, "Note", array("class"=>"textarea"));?>
	<? if($color->species && $color->genus): ?>
	<p class="latin-name"><label>Latin Name: </label><span class="field"><em>
	<?=ucfirst(substr($color->genus, 1, 1));?>.
	<?=strtolower($color->species);?></em></span>
	</p>
	<? endif;?>

</fieldset>
<fieldset class="order-info block" id="order">
	<legend>
		Order Info for
		<?=get_current_year();?>
	</legend>
	<div class="column column-odd">
		<?=create_edit_field("vendor_id", $color->vendor_id, "Vendor Id");?>
		<?=create_edit_field("year", $color->year, "Year");?>
		<?=create_edit_field("flat_size", $color->flat_size, "Flat Size");?>


		<? if($color->flat_cost && !$color->plant_cost){
			$plant_cost = $color->flat_cost/$color->flat_size;
			$flat_cost = $color->flat_cost;
		}elseif($color->plant_cost && !$color->flat_cost){
		$plant_cost = $color->plant_cost;
		$flat_cost = $color->plant_cost * $color->flat_size;
	}else{
		$plant_cost = $color->plant_cost;
		$flat_cost = $color->flat_cost;
	}
	?>
		<?=create_edit_field("flat_cost", get_as_price($flat_cost), "Flat Cost", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("plant_cost", get_as_price($plant_cost), "Plant Cost", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("price", get_as_price($color->price), "Sale Price", array("attributes"=>"format='currency'"));?>
		<?=create_edit_field("pot_size", $color->pot_size, "Pot Size");?>
	</div>
	<div class="column column-even">
		<?=create_edit_field("count_presale",$color->count_presale, "Presale Count");?>
		<?=create_edit_field("count_midsale",$color->count_midsale, "Midsale Count");?>
		<?=create_edit_field("sellout_friday", $color->sellout_friday, "Friday Sellout");?>
		<?=create_edit_field("remainder_friday", $color->remainder_friday, "Friday Remainder");?>
		<?=create_edit_field("sellout_saturday", $color->sellout_saturday, "Saturday Sellout");?>
		<?=create_edit_field("remainder_saturday", $color->remainder_saturday, "Saturday Remainder");?>
		<?=create_edit_field("remainder_sunday", $color->remainder_sunday, "Sunday Remainder");?>
		<?=create_edit_field("count_dead", $color->count_dead, "Dead Count");?>
		<?=create_edit_field("vendor_code", $color->vendor_code, "Vendor Code");?>
	</div>
</fieldset>

