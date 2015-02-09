<?php defined('BASEPATH') OR exit('No direct script access allowed');
$refine = $this->input->get("refine");
$sunlight = create_checkbox("sunlight[]", $sunlight, $refine ? explode(",",get_cookie("sunlight")): array());
?>
<div class="message">Enter "NULL" (with no spaces) in any field to find records with no entry in that field. Enter "NOT NULL" to find items where that field is not empty.</div>
<form name="search-variety" id="search-variety" class="search-form"
		action="<?=site_url("variety/find"); ?>" method="GET">
	<p><label for="action[]">List </label><input type="radio" name="action[]" value="full_list" checked/>&nbsp;
<label for="action[]">Variety History</label><input type="radio" name="action[]" value="history"/></p>
	<p>
		<label for="year">Year: </label><input type="number" name="year" style="width: 5em"
			value="<?=get_cookie("sale_year");?>" />
	</p>
	<p><input type="checkbox" name="crop_failure" value="1"/><label for="crop_failure">Show Only Crop Failures</label></p>
	<div class="field-set">
	<div class="column first">
		<?=create_input($variety,"name","Common Name","name", $refine);?>
	</div>
	<div class="column last">
		<?=create_input($variety,"variety","Variety","variety",$refine);?>
	</div>
	</div>
	<div class="field-set">
	<div class="column first">
		<?=create_input($variety,"genus","Genus","genus",$refine);?>
	</div>
	<div class="column last">
		<?=create_input($variety, "species","Species","species",$refine);?>
	</div>
	</div>
	<div class="field-set block">
	<label for="new_year">Year the Variety was Introduced:&nbsp;</label>
	<input type="number" style="width:5em" value="<?=get_value($variety,"new_year",($refine ? get_cookie("new_year"):''));?>" name="new_year" id="new_year"/>
	</div>
		<div class="field-set block">
		<div class="column first">
		<label for="category_id">Category: </label><?=form_dropdown("category_id",$categories,($refine ? get_cookie("category_id"):""),'id="category_id"');?>
		</div>
		<div class="column last">
	<label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope"><?=form_dropdown("subcategory_id",$subcategories,($refine ? get_cookie("subcategory_id"):""),'id="subcategory_id"');?></span>

		</div>
	</div>
	<div class="field-set">
	<div class="column first">
		<label for="flag">Flag: </label>
		<?=form_dropdown("flag",$flags,array($refine ? get_cookie("flag"):''),"id='flag'");?>
		<br/>
		<input type="checkbox" name="not_flag" style="width:auto;" value=1 id="not_flag"
		<?=get_cookie("not_flag") ? "checked":"";?>
		title="Check here if you want to find everything that is not the flag value">
		<strong>Negate</strong>

	</div>
	<div class="column last">
	<label for="plant_color">Plant Color: </label>
		<?=form_dropdown("plant_color",$plant_colors,array($refine ? get_cookie("plant_color") : ""),"id='plant_colors'");?>
	</div>
	</div>
	<div class="field-set block">
	<label for="sunlight-boolean">Sunlight Options</label>
		<?=form_dropdown("sunlight-boolean",array("and"=>"and","or"=>"or","only"=>"only"),$refine ? get_cookie("sunlight-boolean"):"and","id='sunlight-boolean'");?>
		<br/>
		<?=$sunlight;?>
	</div>
	<div class="field-set block">
	<div class="column first">
		<?=create_input($variety, "description","General Description");?>
	</div>
	<div class="column last">
		<?=create_input($variety, "extended_description","Variety Description","extended_description",$refine);?>
	</div>
	</div>
	<p>
	<?=create_input($variety,"grower_id","Grower ID","grower_id",$refine);?>
	</p>
	<p>
<input type="checkbox" name="no_image" id="no_image" value="1"/><label for="no_image">Missing Image</label>
	</p>
	<!-- <p>
		<?=create_input($variety,"min_height","Min Height","min_height",$refine);?>
	</p>
		<p>
		<?=create_input($variety,"max_height","Max Height","max_height",$refine);?>
	</p>
		<p>
		<?=create_input($variety,"height_unit","Unit","height_unit",$refine);?>
	</p>
	<p>
		<?=create_input($variety,"min_width","Min Width","min_width", $refine);?>
	</p>
		<p>
		<?=create_input($variety,"max_width","Max Width", "max_width", $refine);?>
	</p>
		<p>
		<?=create_input($variety,"width_unit","Unit","width_unit", $refine);?>
	</p> -->

	<div id="sort-block">
<?
$data["basic_sort"] = TRUE;
$this->load->view("order/sort",$data);?>
</div>
<? $buttons[] = array("type"=>"pass-through","text"=>"<input type='submit' value='Find' class='button'/>");
$buttons[] = array("type"=>"pass-through","text"=>"<input type='reset' value='Reset' class='button delete'/>");
 print create_button_bar($buttons); ?>

</form>
