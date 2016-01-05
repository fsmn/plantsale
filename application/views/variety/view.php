<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<input type="hidden" id="id" name="id" value="<?=$variety->id;?>" />
<input type="hidden" id="order_id" name="order_id" value="<?=get_value($current_order,"id");?>" />
<h2>
	<?="$variety->common_name: $variety->variety";?>
</h2>

<? $this->load->view("variety/menu");?>
<div class="grouping block variety-info" id="variety">
	<div class='triptych'>
	<h4>Basic Variety Info</h4>
			<?=edit_field("variety", $variety->variety, "Variety","variety",$variety->id, array("envelope"=>"p"));?>

			<p><label for="genus">Genus:&nbsp;</label>
			<span class='field'><?=$variety->genus;?></span>
			</p>
		
			<?=edit_field("species", $variety->species, "Species","variety",$variety->id, array("envelope"=>"p"));?>
		
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Height</strong>
			</legend>

			<div class="field-set">
				<?=edit_field("min_height", $variety->min_height,"Min","variety",$variety->id, array("envelope"=>"span"));?>
			</div>
			<div class="field-set">
				<?=edit_field("max_height", $variety->max_height, "Max", "variety",$variety->id, array("envelope"=>"span"));?>
			</div>
			<div class="field-set">
				<?=edit_field("height_unit", $variety->height_unit, "Measure", "variety",$variety->id, array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"span"));?>
			</div>
		</fieldset>
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Width</strong>
			</legend>

			<div class="field-set">
				<?=edit_field("min_width", $variety->min_width, "Min","variety",$variety->id, array("envelope"=>"span"));?>
			</div>
			<div class="field-set">
				<?=edit_field("max_width", $variety->max_width, "Max","variety",$variety->id, array("envelope"=>"span"));?>
			</div>
			<div class="field-set">
				<?=edit_field("width_unit", $variety->width_unit, "Measure","variety",$variety->id,  array("class"=>"dropdown","attributes"=>"menu='measure_unit'","envelope"=>"span"));?>
			</div>

		</fieldset>
			<?=edit_field("plant_color",$variety->plant_color, "Plant Color(s)","variety",$variety->id, array("class"=>"multiselect","attributes"=>"menu='plant_color'","format"=>"multiselect"));?>

	<div class="column odd" id="flags">
			<h4>Flags</h4>
			<div class="flag-list" id="flag-list_<?=$variety->id;?>">
			<? $this->load->view("flag/list");?>

	</div>
	<? if(IS_EDITOR):?>
			<? $flag_buttons[] = array("selection"=>"flag","text"=>"New Flag","type"=>"span","class"=>"button new flag-add","id"=>"fa_$variety->id");?>
			<?=create_button_bar($flag_buttons);?>
	<?endif;?>
	</div>
		<div class="column even" id="is-new">
			<h4>Sale Year</h4>
			<?=edit_field("new_year",$variety->new_year,"First Year at Sale","variety",$variety->id, array("envelope"=>"p"));?>
			<? if( $is_new):?>
			<span class="is-new">
				<img src="<?=site_url("images/new.gif");?>" />
			</span>
			<? endif;?>
			</div>
	</div>



<div class='common-info triptych'>
<h4>Common Info</h4>
<p>
			<label>Common Name:</label>
			<span class="field">
				<a href="<?=site_url("common/view/$variety->common_id");?>" title="View details for <?=$variety->common_name;?>"><?=$variety->common_name;?></a>
			</span>
				<? if($this->ion_auth->in_group(1)):?>&nbsp;
				<?php
					
echo create_button ( array (
							"text" => "Change",
							"class" => array (
									"button",
									"edit",
									"change-common",
									"small" 
							)
							,
							"id" => "change-common_$variety->id" 
					) );
					
					?>
		<? endif;?>
		</p>
		<p>
			<label>Other Names:</label>
			<span class="field">
		<?=$variety->other_names;?></span>
		</p>
		<p class="category">
			<label>Category: </label>
			<span class="field"><?=$variety->category; ?>
			</span>
			<label>Subcategory: </label>
			<span class="field"><?=$variety->subcategory; ?>
			</span>
		</p>
		<p class="sunlight">
			<label>Sunlight: </label>
			<span class="field"><?=$variety->sunlight;?></span>
		</p>
		
		<div class="well block" id="image">
				<h4>Image</h4>
	<? $this->load->view("image/view"); ?>

</div>
</div>
	<div class='description-info triptych'>
		
			<h4>Copy Editing</h4>
			<p>
	<?php echo edit_field("editor",$variety->editor,"Editor","variety",$variety->id,  array("class"=>"user-dropdown","attributes"=>"menu='users'","envelope"=>"span"));?>

	 <?php echo edit_field("copywriter", $variety->copywriter, "Copywriter","variety",$variety->id, array("envelope"=>"span"));?>
	
</p>
			<p>
		
		<?php echo edit_field("needs_copy_review",$variety->needs_copy_review,"Needs Copy","variety",$variety->id,  array("class"=>"dropdown","attributes"=>"menu='boolean'","envelope"=>"span"));?>
				<?php echo edit_field("copy_received",$variety->copy_received,"Copy Received","variety",$variety->id,  array("class"=>"dropdown","attributes"=>"menu='boolean'","envelope"=>"span"));?>
		
		</p>
				<p class="description">
					 <?=edit_field("edit_notes", $variety->edit_notes, "Copy Editing Notes","variety",$variety->id, array("class"=>"textarea","envelope"=>"span"));?>
		
		</p>
<div class="well">
		<h4>Descriptions</h4>
			<p class="description">
						 <?=edit_field("description", $variety->description, "General Description (from Common)","common",$variety->common_id, array("class"=>"textarea","envelope"=>"span"));?>

		</p>
			<p class="print_description">

			 <?=edit_field("print_description", $variety->print_description, "Variety Description","variety",$variety->id, array("class"=>"textarea","envelope"=>"span"));?>
		</p>
			<p class="web_description">

			 <?=edit_field("web_description", $variety->web_description, "Variety Web Description","variety",$variety->id, array("class"=>"textarea","envelope"=>"span"));?>
		</p>



</div>
	</div>
</div>
<div class="all-orders block">
<? if(get_value($variety,"needs_bag",0)):?>
			<p>
		<span class="message">Based on the pot size, this variety will require a bag for packaging.</span>
	</p>
<? endif; ?>
	<h3>Orders</h3>
	<?
	
	$data ["orders"] = $orders;
	$data ["show_names"] = FALSE;
	$this->load->view ( "order/list", $data );
	?>

</div>
<?
$order_buttons [] = array (
		"selection" => "order",
		"text" => "New Order",
		"href" => site_url ( "order/create/?variety_id=$variety->id" ),
		"class" => "button new create dialog order-create",
		"id" => "oc_$variety->id" 
);
echo create_button_bar ( $order_buttons);