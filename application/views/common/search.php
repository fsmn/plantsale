<?php defined('BASEPATH') OR exit('No direct script access allowed');
$sunlight = create_checkbox("sunlight[]", $sunlight, array());

?>

<form name="search-common" id="search-common"
	action="<?=site_url("common/find"); ?>" method="GET">
	<p>
		<?=create_input($common,"name","Name");?>
	</p>
	<p>
		<?=create_input($common, "genus","Genus");?>
	</p>
<p><label for="category_id">Category: </label><?=form_dropdown("category_id",$categories,FALSE,'id="category_id"');?></p>
	<p ><label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope"><?=form_dropdown("subcategory_id",$subcategories,'id="subcategory_id"');?></span></p>

	<p>
		<?=$sunlight;?>
		<br />
		<?=form_dropdown("sunlight-boolean",array("and"=>"and","or"=>"or","only"=>"only"),"and","id='sunlight-boolean'");?>
	</p>
	<p>
		<label for="description">Description:</label><br />
		<textarea name="description" id="description"></textarea>
	</p>
	<p>
		<label for="year">Year: </label><input type="text" name="year"
			value="<?=get_current_year();?>" />
	</p>
	<p>
		<input type="submit" value="Find" class="button" />
	</p>
</form>
