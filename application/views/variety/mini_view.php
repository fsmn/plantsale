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
				<div class="field-envelope"
					id="variety__min_height__<?=$variety->id;?>">
					<label>Min:&nbsp;</label> <span class="live-field text"
						name="min_height"><input type="text" name="min_height" value="<?=$variety->min_height;?>"
						id="min-height_<?=$variety->id;?>" size="6" category=""></span>
				</div>
			</div>
			<div class="field-set">
				<div class="field-envelope"
					id="variety__max_height__<?=$variety->id;?>">
					<label>Max:&nbsp;</label> <span class="live-field text"
						name="max_height"><input type="text" name="max_height" value="<?=$variety->max_height;?>"
						id="max-height_<?=$variety->id;?>" size="5" category=""></span>
				</div>
			</div>
			<div class="field-set">
				<div class="field-envelope"
					id="variety__height_unit__<?=$variety->id;?>">
					<label>Measure:&nbsp;</label> <span
						class="dropdown live-field text" menu="measure_unit"
						name="height_unit">
<?php echo form_dropdown("height_unit",array("0"=>"","Feet"=>"Feet","Inches"=>"Inches"),get_value($variety,"height_unit"),"class='live-field'");?>
</span>
				</div>
			</div>
		</fieldset>
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Width</strong>
			</legend>

			<div class="field-set">
				<div class="field-envelope" id="variety__min_width__<?=$variety->id;?>">
<label>Min:&nbsp;</label>
<span class="live-field text" name="min_width"><input type="text" name="min_width" value="<?=$variety->min_width;?>" id="min-width_<?=$variety->id;?>" size="5" category=""></span></div>
			</div>
			<div class="field-set">
<div class="field-envelope" id="variety__max_width__<?=$variety->id;?>">
<label>Max:&nbsp;</label>
<span class="live-field text" name="max_width"><input type="text" name="max_width" value="<?=$variety->max_width;?>" id="max-width_<?=$variety->id;?>" size="5" category=""></span></div>
			</div>
			<div class="field-set">

			<div class="field-envelope" id="variety__width_unit__<?=$variety->id;?>">
<label>Measure:&nbsp;</label>
<span class="dropdown live-field text" menu="measure_unit" name="width_unit">
<?php echo form_dropdown("width_unit",array("0"=>"","Feet"=>"Feet","Inches"=>"Inches"),get_value($variety,"width_unit"),"class='live-field'");?>

</span></div>
</div>

		</fieldset>
		<div><?=edit_field("plant_color",$variety->plant_color, "Plant Color(s)","variety",$variety->id,array("class"=>"multiselect","attributes"=>"menu='plant_color'","class"=>"multiselect", "format"=>"multiselect"));?></div>
		<div>
			<label>Common Name:</label> <span class="field"><?=$variety->common_name;?>
			</span>
						<?php echo create_button(array("text"=>"Details","class"=>array("button","details"),"href"=>site_url("common/view/$variety->common_id"),"title"=>"View details for $variety->common_name"));?>
		</div>
		<div>
			<label>Other Names:</label> <span class="field">
		<?=$variety->other_names;?></span>
		</div>
		<div class="category">
			<label>Category: </label> <span class="field"><?=$variety->category; ?>
			</span>
		</div>
		<p class="sunlight">
			<label>Sunlight: </label> <span class="field"><?=$variety->sunlight;?></span>
		</p>
		<div class="description">
			<div class="field-envelope"
				id="common__description__<?=$variety->common_id;?>">
				<label>General Description:&nbsp;</label> <span
					class="textarea live-field text" name="description"><textarea
						name="description" cols="40" rows="10"
						id="description_<?=$variety->common_id;?>" size="127" type="textarea"
						category=""><?php echo get_value($variety,"description");?></textarea></span>
			</div>
		</div>
		<div class="extended_description">
			<div class="field-envelope"
				id="variety__extended_description__<?=$variety->id?>">
				<label>Variety Description:&nbsp;</label> <span
					class="textarea live-field text" name="extended_description"><textarea
						name="extended_description" cols="40" rows="10"
						id="extended-description_<?=$variety->id;?>" size="5" type="textarea" category=""><?=get_value($variety,"extended_description");?></textarea></span>
			</div>
		</div>

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