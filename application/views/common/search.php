<?php defined('BASEPATH') OR exit('No direct script access allowed');
$sunlight = create_checkbox("sunlight[]", $sunlight, array());

?>

<form name="edit-common" id="edit-common" action="<?=site_url("common/find"); ?>" method="POST">
<p><?=create_input($common,"name","Name");?></p>
<p><?=create_input($common, "genus","Genus");?></p>
<p><label for="category">Category: </label><?=form_dropdown("category",$categories,get_value($common,"category"),"id='category'");?></p>
<p><?=create_input($common,"subcategory","Subcategory");?></p>
<p>
<?=$sunlight;?>
</p>
<p><label for="description">Description:</label><br/>
<p><input type="submit" value="Find" class="button"/></p>
</form>