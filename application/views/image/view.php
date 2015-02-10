<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
if (! get_value ( $variety, "image_id", FALSE ) && IS_EDITOR):

$id = get_value ($variety,"id",$variety_id);
	
echo create_button ( array (
			"text" => "Add Image",
			"class" => array (
					"new",
					"button",
					"small",
					"add-image" 
			),
			"id" => "add-image_$id",
			"href" => base_url ( "variety/new_image/?variety_id=$id" ) 
	)
	 );
	?>
			<? else: ?>
<img src="<?=site_url("files/$variety->image_name");?>" />
<? if(IS_EDITOR): ?>
	<?php echo create_button(array("text"=>"Delete Image","class"=>array("button","delete","delete-image"),"id"=>"delete-image_$variety->image_id"));?>
	<? endif;?>
<? endif;?>
