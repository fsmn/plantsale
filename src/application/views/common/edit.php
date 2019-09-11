<?php defined('BASEPATH') OR exit('No direct script access allowed');
 $lights = array();

if(get_value($common,"sunlight",FALSE)){
	$lights = explode(",",get_value($common,"sunlight")) ;
}

$sunlight = create_checkbox("sunlight[]", $sunlight, $lights );

?>

<form name="edit-common" id="edit-common" action="<?php echo site_url("common/$action"); ?>" method="POST">
<input type="hidden" name="id" id="common_id" value="<?php echo get_value($common,"id");?>"/>
<p><?php echo create_input($common,"name","Name","name",NULL,TRUE);?></p>

<p><?php echo create_input($common, "genus","Genus",NULL,NULL,TRUE);?></p>
<p>
<label for="category_id">Category: </label>
<?php echo form_dropdown("category_id",$categories,FALSE,'id="category_id" required');?>
</p>
	<p ><label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope"><?php echo form_dropdown("subcategory_id",$subcategories,'id="subcategory_id"');?></span></p>

<p>
<?php echo $sunlight;?>
</p>
<p><label for="description">Description:</label><br/>
<textarea name="description" id="description"><?php echo get_value($common,"description");?></textarea></p>
<p><input type="submit" value="<?php echo ucfirst($action);?>" class="button <?php echo $action;?>"/></p>
</form>