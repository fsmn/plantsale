<?php defined('BASEPATH') OR exit('No direct script access allowed');

// edit_common.php Chris Dart Dec 1, 2014 5:14:01 PM chrisdart@cerebratorium.com

//edit the common id for the variety

?>

<form name="edit-common-id" id="edit-common-id" method="post" action="<?=site_url("variety/edit_common_id");?>" style="width: 36ex;">
<div class="alert">Be very careful making changes. This cannot be undone!</div>
<input type="hidden" name="id" id="id" value="<?=$variety->id;?>"/>
<input type="hidden" name="original_id" id="original_id" value="<?=$variety->common_id;?>"/>
<p>
<input type="number" name="common_id" id="common_id" style="width:15ex" value="<?=$variety->common_id;?>"/>&nbsp;
<?php echo create_button(array("text"=>"Check","class"=>array("button","small"),"id"=>"change-button"));?>
</p>
<div id="common-name"><?=$variety->common_name;?></div>
<p>
<input type="submit" name="submit" id="submit" value="Change" class="button edit" style="display:none;"/>
<?php echo create_button(array("text"=>"Revert","class"=>array("button","hidden"),"id"=>"revert"));?>

</p>
</form>