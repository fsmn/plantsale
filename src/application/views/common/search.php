<?php defined('BASEPATH') OR exit('No direct script access allowed');
$refine = $this->input->get("refine");
$sunlight = create_checkbox("sunlight[]", $sunlight, array());

?>
<form name="search-common" id="search-common"
	action="<?php echo site_url("common/search"); ?>" method="GET">
	<input type="hidden" name="find" value="1"/>
	<p>
	<label for="name">Name: </label><input type="text" name="name" id="name" value="<?php echo $refine?cookie("name"):'';?>" class="">
	</p>
	<p>
		<label for="genus">Genus: </label><input type="text" name="genus" id="genus" value="<?php echo $refine?cookie("genus"):'';?>" class="">
	
	</p>
<p><label for="category_id">Category: </label><?php echo form_dropdown("category_id",$categories,$refine?cookie("category_id"):"",'id="category_id"');?></p>
	<p ><label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope"><?php echo form_dropdown("subcategory_id",$subcategories,$refine?cookie("subcategory_id"):"", 'id="subcategory_id"');?></span></p>

	<p>
		<?php echo $sunlight;?>
		<br />
		<?php echo form_dropdown("sunlight-boolean",array("and"=>"and","or"=>"or","only"=>"only"),"and","id='sunlight-boolean'");?>
	</p>
	<p>
		<label for="description">Description:</label><br />
		<textarea name="description" id="description"><?php echo $refine?cookie("description"):'';?></textarea>
	</p>
	<p>
		<label for="year">Year: </label><input type="text" name="year"
			value="<?php echo $refine?cookie("year"):"";?>" />
	</p>
	<p>
		<input type="submit" value="Find" class="button" />
	</p>
</form>
