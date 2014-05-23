<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$sunlight = create_checkbox("sunlight[]", $sunlight, array());

?>

<form name="search-variety" id="search-variety"
		action="<?=site_url("variety/find"); ?>" method="GET">
	<p>
		<?=create_input($variety,"name","Common Name");?>
	</p>
	<p>
		<?=create_input($variety,"variety","Variety");?>
	</p>
	<p>
		<?=create_input($variety,"genus","Genus");?>
	</p>
	<p>
		<?=create_input($variety, "species","Species");?>
	</p>
	<p>
		<label for="category">Category: </label>
		<?=form_dropdown("category",$categories,"","id='category'");?>
	</p>
	<p>
		<label for="flag">Flag: </label>
		<?=form_dropdown("flag",$flags,"","id='flag'");?>
	</p>
	<p>
	<label for="plant_color">Plant Color: </label>
		<?=form_dropdown("plant_color",$plant_colors,"","id='plant_colors'");?>
	</p>
	<p>
	<label for="sunlight-boolean">Sunlight Options</label>
		<?=form_dropdown("sunlight-boolean",array("and"=>"and","or"=>"or","only"=>"only"),"and","id='sunlight-boolean'");?>
		<br/>
		<?=$sunlight;?>
	</p>
	<p>
		<?=create_input($variety, "description","General Description");?>
	</p>
	<p>
		<?=create_input($variety, "note","Variety Note");?>
	</p>
	<!-- <p>
		<?=create_input($variety,"min_height","Min Height");?>
	</p>
		<p>
		<?=create_input($variety,"max_height","Max Height");?>
	</p>
		<p>
		<?=create_input($variety,"height_unit","Unit");?>
	</p>
	<p>
		<?=create_input($variety,"min_width","Min Width");?>
	</p>
		<p>
		<?=create_input($variety,"max_width","Max Width");?>
	</p>
		<p>
		<?=create_input($variety,"width_unit","Unit");?>
	</p> -->
	<p>
		<label for="year">Year: </label><input type="text" name="year"
			value="<?=get_current_year();?>" />
	</p>
	<!-- <p>
	<label for="print_omit">Exclude Plants Omitted from Printing</label>
	<input type="checkbox" name="print_omit" id="print_omit" value="1" checked/>
	</p> -->
	<p>
		<input type="submit" value="Find" class="button" />
	</p>
</form>
