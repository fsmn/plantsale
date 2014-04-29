<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $lights = array();

if(get_value($common,"sunlight",FALSE)){
	$lights = explode(",",get_value($common,"sunlight")) ;
}

$sunlight = create_checkbox("sunlight[]", $sunlight, $lights );

?>

<form name="edit-common" id="edit-common" action="<?=site_url("common/$action"); ?>" method="POST">
<input type="hidden" name="id" id="common_id" value="<?=get_value($common,"id");?>"/>
<p><?=create_input($common,"name","Name");?></p>
<p><?=create_input($common, "genus","Genus");?></p>
<p><label for="category">Category: </label><?=form_dropdown("category",$categories,get_value($common,"category"),"id='category'");?></p>
<p><?=create_input($common,"subcategory","Subcategory");?></p>
<p>
<?=$sunlight;?>
</p>
<p><label for="description">Description:</label><br/>
<textarea name="description" id="description"><?=get_value($common,"description");?></textarea></p>
<p><input type="submit" value="<?=ucfirst($action);?>" class="button new"/></p>
</form>