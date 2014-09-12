<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!-- <input
	type="hidden" id="id" name="id" value="<?=$variety->id;?>" />

<input type="hidden"
	id="order_id" name="order_id"
	value="<?=get_value($current_order,"id");?>" /> -->
	<h4><?=$variety->common_name;?> <?=$variety->variety;?></h4>
<p>
<?=$this->load->view("variety/menu");?>
</p>
<? if( $is_new):?>
			<div id="is_new"><span class="is_new"><img src="<?=site_url("images/new.gif");?>"/>Is New</span></div>
<? endif;?>
<div class="grouping block variety-info" id="variety">
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Height</strong>
			</legend>

			<div class="field-set">
				<?=edit_field("min_height", $variety->min_height,"Min","variety",$variety->id, array("envelope"=>"div"));?>

			</div>
			<div class="field-set">
				<?=edit_field("max_height", $variety->max_height, "Max", "variety",$variety->id, array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=edit_field("height_unit", $variety->height_unit, "Measure","variety",$variety->id, array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"div"));?>
			</div>
		</fieldset>
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Width</strong>
			</legend>

			<div class="field-set">
				<?=edit_field("min_width", $variety->min_width, "Min","variety",$variety->id,array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=edit_field("max_width", $variety->max_width, "Max","variety",$variety->id,array("envelope"=>"div"));?>
			</div>
			<div class="field-set">
				<?=edit_field("width_unit", $variety->width_unit, "Measure","variety",$variety->id, array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"div"));?>
			</div>

		</fieldset>
			<p><?=edit_field("plant_color",$variety->plant_color, "Plant Color(s)","variety",$variety->id,array("class"=>"multiselect","attributes"=>"menu='plant_color'","class"=>"multiselect", "format"=>"multiselect"));?></p>
		<p>
			<label>Common Name:</label> <span class="field"><?=$variety->common_name;?>
			</span> <a href="<?=site_url("common/view/$variety->common_id");?>"
				title="View details for <?=$variety->common_name;?>" class="button">Details</a>
		</p>
		<p>
		<label>Other Names:</label> <span class="field">
		<?=$variety->other_names;?></span>
		</p>
		<p class="category">
			<label>Category: </label> <span class="field"><?=$variety->category; ?>
			</span>
		</p>
		<p class="description">
			<label>General Description: </label> <span class="field" title="You can only edit this field in the common name record"><?=$variety->description; ?>
			</span>
		</p>
		<p class="extended_description">
		<label>Extended Description (for website)</label>
		<span class="field" title="You can only edit this field in the common name record"><?=$variety->extended_description;?></span>
		</p>
		<p>
				<?=create_edit_field("note", $variety->note, "Variety Description", array("class"=>"textarea","envelope"=>"div"));?>
		</p>

		<div class="column odd">
			<h4>Flags</h4>
			<div id="flag-list">
			<? $this->load->view("flag/list");?>
			</div>
	<? if(DB_ROLE == 1):?>
			<? $flag_buttons[] = array("selection"=>"flag","text"=>"New Flag","type"=>"span","class"=>"button new flag-add","id"=>"fa_$variety->id");?>
			<?=create_button_bar($flag_buttons);?>
	<?endif;?>
		</div>
		<div class="column even">
		<h4>Sale Year</h4>
			<?=edit_field("new_year",$variety->new_year,"First Year at Sale","variety",$variety->id, array("envelope"=>"span"));?>
			<? if( $is_new):?>
			<span class="is-new"><img src="<?=site_url("images/new.gif");?>"/></span>
			<? endif;?>
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