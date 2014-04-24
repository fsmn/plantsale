<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<input
	type="hidden" id="id" name="id" value="<?=$variety->id;?>" />

<input type="hidden"
	id="order_id" name="order_id"
	value="<?=get_value($current_order,"id");?>" />
<h2>
	<?="$variety->common_name: $variety->variety";?>
</h2>
				<div class="button delete variety-delete">Delete Variety</div>

<div class="grouping block variety-info" id="variety">
	<div class='column column-odd'>

		<div class='field-set'>
			<?=create_edit_field("variety", $variety->variety, "Variety",array("envelope"=>"div"));?>
		</div>
		<div class='field-set'>
			<?=create_edit_field("species", $variety->species, "Species",array("envelope"=>"div"));?>
		</div>
		<div class='field-set'>
			<label for="genus">Genus:&nbsp;</label><span class='field'><?=$variety->genus;?></span>
		</div>
		<? if($variety->species && $variety->genus): ?>
		<div class='field-set'>
			<div class="latin-name">
				<label>Latin Name: </label><span class="field"><em> <?=ucfirst(substr($variety->genus, 0, 1));?>.
						<?=strtolower($variety->species);?>
				</em> </span>
			</div>
		</div>
		<? endif;?>
		<fieldset class="field-group">
			<legend class="label">
				<strong>Height</strong>
			</legend>

			<div class="field-set">
				<?=create_edit_field("min_height", $variety->min_height,"Min",array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("max_height", $variety->max_height, "Max", array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("height_unit", $variety->height_unit, "Measure", array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"div"));?>
			</div>
		</fieldset>
		<fieldset class="field-group">
			<legend class="label">
				<strong>Width</strong>
			</legend>

			<div class="field-set">
				<?=create_edit_field("min_width", $variety->min_width, "Min",array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("max_width", $variety->max_width, "Max",array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("width_unit", $variety->width_unit, "Measure", array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"div"));?>
			</div>

		</fieldset>

			<?=create_edit_field("plant_color",$variety->plant_color, "Plant Color(s)",array("class"=>"multiselect","attributes"=>"menu='plant_color'","format"=>"multiselect"));?>
		
		<?=create_edit_field("note", $variety->note, "Note", array("class"=>"textarea","envelope"=>"div"));?>

	</div>
	<div class='common-info column column-even'>
		<p>
			<label>Common Name:</label> <span class="field"><?=$variety->common_name;?>
			</span> <a href="<?=site_url("common/view/$variety->common_id");?>"
				title="View details for <?=$variety->common_name;?>" class="button">Details</a>
		</p>
		<p class="category">
			<label>Category: </label> <span class="field"><?=$variety->category; ?>
			</span>
		</p>
		<p class="description">
			<label>Description: </label> <span class="field"><?=$variety->description; ?>
			</span>
		</p>

		<div class="block" id="flags">
			<h4>Flags</h4>
			<div id="flag-list">
			<? $this->load->view("flag/list");?>
</div>
			<? $flag_buttons[] = array("selection"=>"flag","text"=>"New Flag","type"=>"span","class"=>"button new flag-add","id"=>"fa_$variety->id");
			echo create_button_bar($flag_buttons);
			?>
		</div>
	</div>
</div>

<div class="all-orders block">
	<h3>Orders</h3>
	<? $data["orders"] = $orders;
	$data["show_names"] = FALSE;
	 $this->load->view("order/list", $data);?>

</div>
<?
$order_buttons[] = array("selection"=>"order","text"=>"New Order","type"=>"span","class"=>"button new order-create", "id" => "oc_$variety->id");
echo create_button_bar($order_buttons);