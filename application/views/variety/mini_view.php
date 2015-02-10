<?php defined('BASEPATH') OR exit('No direct script access allowed');?>

<h4><?=$variety->common_name;?> <?=$variety->variety;?></h4>
<? if( $is_new):?>
<div id="is_new">
	<span class="is_new"><img src="<?=site_url("images/new.gif");?>" />Is
		New</span>
</div>
<? endif;?>
<div class="variety-mini-view">
	<div class="grouping block variety-info" id="variety">
		<div class="block" id="image">
	<? $this->load->view("image/view"); ?>

</div>
		<div class='field-set' tabindex=1>
			<?=edit_field("variety", $variety->variety, "Variety","variety",$variety->id, array("envelope"=>"span"));?>
			<?php echo create_button(array("text"=>"Edit","class"=>"button edit variety-edit","id"=>"edit-variety_$variety->id","href"=>site_url("variety/view/$variety->id"),"selection"=>"home"));?>
		</div>
		<div class='field-set'>
			<label for="genus">Genus:&nbsp;</label><span class='field'><?=$variety->genus;?></span>
		</div>
		<div class='field-set'>
			<?=edit_field("species", $variety->species, "Species","variety",$variety->id, array("envelope"=>"div"));?>
		</div>

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
			<div class="field-set" >
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
			</span>
						<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"href"=>site_url("common/view/$variety->common_id"),"title"=>"View details for $variety->common_name"));?>
		</p>
		<p>
			<label>Other Names:</label> <span class="field">
		<?=$variety->other_names;?></span>
		</p>
		<p class="category">
			<label>Category: </label> <span class="field"><?=$variety->category; ?>
			</span>
		</p>
		<p class="sunlight">
			<label>Sunlight: </label> <span class="field"><?=$variety->sunlight;?></span>
		</p>
		<p class="description">
		   <?=edit_field("description", $variety->description, "General Description","common",$variety->common_id, array("class"=>"textarea","envelope"=>"div"));?>
		</p>
		<p class="extended_description">
							<?=edit_field("extended_description", $variety->extended_description, "Variety Description","variety",$variety->id, array("class"=>"textarea","envelope"=>"div"));?>
				
		</p>

		<div class="column odd">
			<h4>Flags</h4>
			<div id="flag-list">
			<? $this->load->view("flag/list");?>
			</div>
	<? if(IS_EDITOR):?>
			<? $flag_buttons[] = array("selection"=>"flag","text"=>"New Flag","type"=>"span","class"=>"button new flag-add","id"=>"fa_$variety->id");?>
			<?=create_button_bar($flag_buttons);?>
	<?endif;?>
		</div>
		<div class="column even">
			<h4>Sale Year</h4>
			<?=edit_field("new_year",$variety->new_year,"First Year at Sale","variety",$variety->id, array("envelope"=>"span"));?>
			<? if( $is_new):?>
			<span class="is-new"><img src="<?=site_url("images/new.gif");?>" /></span>
			<? endif;?>
			</div>
	</div>
</div>