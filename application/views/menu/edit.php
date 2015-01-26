<?php defined('BASEPATH') OR exit('No direct script access allowed');

// edit.php Chris Dart Jan 26, 2015 4:20:03 PM chrisdart@cerebratorium.com
if(IS_ADMIN):
?>
<? if(!$ajax):?>
<h2><?=$title;?></h2>
<? endif;?>
<form id="menu-item-editor" name="menu-item-editor" action="<?=site_url("menu/$action");?>" method="post">
<input type="hidden" name="id" value="<?=get_value($item,"id");?>"/>
<p>
<label for="category">Category: </label>
<?=form_dropdown("category",$categories,get_value($item,"category"));?>
</p>
<p>
<?=create_input($item,"key","Key (A-z,0-9,-,_)","key",TRUE,TRUE);?>

</p>
<p>
<?=create_input($item,"value","Value","value",TRUE,TRUE);?>
</p>
<p>
<input type="submit" class="button <?=$action;?>" value="<?=ucfirst($action);?>"/>
</p>
</form>
<? else: ?>
<h2>You are not authorized to edit menu items</h2>
<? endif;