<?php defined('BASEPATH') OR exit('No direct script access allowed');
 if(!get_value($variety,"image_id",FALSE) && IS_EDITOR): ?>
			<a class="button new small add-image" id="add-image_<?=$variety->id;?>" href="<?=base_url("variety/new_image/?variety_id=$variety->id");?>">Add Image</a>
			<? else: ?>
			<img src="<?=site_url("files/$variety->image_name");?>" style="height:200px;"/>
	<? if(IS_EDITOR): ?>
		<span class="button delete delete-image" id="delete-image_<?=$variety->image_id;?>">Delete Image</span>
	<? endif;?>
<? endif;?>
