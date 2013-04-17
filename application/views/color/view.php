<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<input
	type="hidden" id="id" name="id" value="<?=$color->id;?>" />

<input type="hidden"
	id="order_id" name="order_id"
	value="<?=get_value($current_order,"id");?>" />
<h2>
	<?="$color->common_name: $color->color";?>
</h2>
				<div class="button delete color-delete">Delete Color</div>

<div class="grouping block color-info" id="color">
	<div class='column column-odd'>
	
		<div class='field-set'>
			<?=create_edit_field("color", $color->color, "Color",array("envelope"=>"div"));?>
		</div>
		<div class='field-set'>

			<?=create_edit_field("species", $color->species, "Species",array("envelope"=>"div"));?>
		</div>
		<? if($color->species && $color->genus): ?>
		<div class='field-set'>
			<div class="latin-name">
				<label>Latin Name: </label><span class="field"><em> <?=ucfirst(substr($color->genus, 0, 1));?>.
						<?=strtolower($color->species);?>
				</em> </span>
			</div>
		</div>
		<? endif;?>
		<fieldset class="field-group">
			<legend class="label">
				<strong>Height</strong>
			</legend>

			<div class="field-set">
				<?=create_edit_field("min_height", $color->min_height,"Min",array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("max_height", $color->max_height, "Max", array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("height_unit", $color->height_unit, "Measure", array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"div"));?>
			</div>
		</fieldset>
		<fieldset class="field-group">
			<legend class="label">
				<strong>Width</strong>
			</legend>

			<div class="field-set">
				<?=create_edit_field("min_width", $color->min_width, "Min",array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("max_width", $color->max_width, "Max",array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=create_edit_field("width_unit", $color->width_unit, "Measure", array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"div"));?>
			</div>

		</fieldset>
		<?=create_edit_field("note", $color->note, "Note", array("class"=>"textarea","envelope"=>"div"));?>
		
	</div>
	<div class='common-info column column-even'>
		<p>
			<label>Common Name:</label> <span class="field"><?=$color->common_name;?>
			</span> <a href="<?=site_url("common/view/$color->common_id");?>"
				title="View details for <?=$color->common_name;?>" class="button">Details</a>
		</p>
		<p class="category">
			<label>Category: </label> <span class="field"><?=$color->category; ?>
			</span>
		</p>
		<p class="description">
			<label>Description: </label> <span class="field"><?=$color->description; ?>
			</span>
		</p>

		<div class="block" id="flags">
			<h4>Flags</h4>
			<div id="flag-list">
			<? $this->load->view("flag/list");?>
</div>
			<? $flag_buttons[] = array("selection"=>"flag","text"=>"New Flag","type"=>"span","class"=>"button new flag-add","id"=>"fa_$color->id");
			echo create_button_bar($flag_buttons);
			?>
		</div>
	</div>
</div>

<div class="all-orders block">
	<h3>Orders</h3>
	<? $this->load->view("order/list");?>

</div>
<?
$order_buttons[] = array("selection"=>"order","text"=>"New Order","type"=>"span","class"=>"button new order-create", "id" => "oc_$color->id");
echo create_button_bar($order_buttons);