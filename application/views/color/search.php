<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form name="search-color" id="search-color"
		action="<?=site_url("color/find"); ?>" method="POST">
	<p>
		<?=create_input($color,"color","Color");?>
	</p>
	<p>
		<?=create_input($color, "species","Species");?>
	</p>
	<p>
		<label for="flag">Flag: </label>
		<?=form_dropdown("flag",$flags,get_value($color,"flag"),"id='flag'");?>
	</p>
	<p>
		<?=create_input($color,"min_height","Min Height");?>
	</p>
		<p>
		<?=create_input($color,"max_height","Max Height");?>
	</p>
		<p>
		<?=create_input($color,"height_unit","Unit");?>
	</p>
	<p>
		<?=create_input($color,"min_width","Min Width");?>
	</p>
		<p>
		<?=create_input($color,"max_width","Max Width");?>
	</p>
		<p>
		<?=create_input($color,"width_unit","Unit");?>
	</p>
	<p>
		<label for="year">Year: </label><input type="text" name="year"
			value="<?=get_current_year();?>" />
	</p>
	<p>
		<input type="submit" value="Find" class="button" />
	</p>
</form>
