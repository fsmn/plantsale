<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
if (! get_value ( $variety, "image_id", FALSE ) && IS_EDITOR)
:
	?>
 <?php
	
echo create_button ( array (
			"text" => "Add Image",
			"class" => array (
					"new",
					"button",
					"small",
					"add-image" 
			),
			"id" => "add-image_$variety->id",
			"href" => base_url ( "variety/new_image/?variety_id=$variety->id" ) 
	)
	 );
	?>
			<? else: ?>
<img src="<?=site_url("files/$variety->image_name");?>"
	style="height: 200px;" />
<? if(IS_EDITOR): ?>
	<?php echo create_button(array("text"=>"Delete Image","class"=>array("button","delete","delete-image"),"id"=>"delete-image_$variety->image_id"));?>
	<? endif;?>
<? endif;?>
