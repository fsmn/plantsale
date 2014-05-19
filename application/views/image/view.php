<?php defined('BASEPATH') OR exit('No direct script access allowed');
 if(!get_value($variety,"image_id",FALSE) && DB_ROLE == 1): ?>
			<a class="button new small add-image" id="add-image_<?=$variety->id;?>" href="<?=base_url("variety/new_image/?variety_id=$variety->id");?>">Add Image</a>
			<? else: ?>
			<img src="<?=site_url("files/$variety->image_name");?>" style="width:200px;height:200px;"/>
			<? if(DB_ROLE == 1): ?>
			<span class="button delete delete-image" id="delete-image_<?=$variety->image_id;?>">Delete Image</span>
			<? endif;?>
			<? endif;?>
