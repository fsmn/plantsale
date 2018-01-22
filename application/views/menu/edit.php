<?php defined('BASEPATH') OR exit('No direct script access allowed');

// edit.php Chris Dart Jan 26, 2015 4:20:03 PM chrisdart@cerebratorium.com
if(IS_ADMIN):
?>
<?php if(!$ajax):?>
<h2><?php echo $title;?></h2>
<?php endif;?>
<form id="menu-item-editor" name="menu-item-editor" action="<?php echo site_url("menu/$action");?>" method="post">
<input type="hidden" name="id" value="<?php echo get_value($item,"id");?>"/>
<p>
<label for="category">Category: </label>
<?php echo form_dropdown("category",$categories,get_value($item,"category"));?>
</p>
<p>
<?php echo create_input($item,"key","Key (A-z,0-9,-,_)","key",TRUE,TRUE);?>

</p>
<p>
<?php echo create_input($item,"value","Value","value",TRUE,TRUE);?>
</p>
<p>
<input type="submit" class="button <?php echo $action;?>" value="<?php echo ucfirst($action);?>"/>
</p>
</form>
<?php else: ?>
<h2>You are not authorized to edit menu items</h2>
<?php  endif;