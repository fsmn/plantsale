<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form name="search-variety" id="search-variety"
		action="<?=site_url("variety/find"); ?>" method="POST">
	<p>
		<?=create_input($variety,"variety","variety");?>
	</p>
	<p>
		<?=create_input($variety, "species","Species");?>
	</p>
	<p>
		<label for="flag">Flag: </label>
		<?=form_dropdown("flag",$flags,get_value($variety,"flag"),"id='flag'");?>
	</p>
	<p>
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
	</p>
	<p>
		<label for="year">Year: </label><input type="text" name="year"
			value="<?=get_current_year();?>" />
	</p>
	<p>
		<input type="submit" value="Find" class="button" />
	</p>
</form>
