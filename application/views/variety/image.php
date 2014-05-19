<?php

?>
<form method="post" enctype="multipart/form-data" name="variety-image-editor" id="variety-image-editor" action="<?=site_url("variety/attach_image");?>">
<input type="hidden" name="variety_id" id="variety_id" value="<?=$variety_id;?>"/>
<input type="hidden" name="id" id="id" value="<?=get_value($image,'id');?>"/>
<p><label for="image_source">Source of Image</label><br />
<input type="text" name="image_source" id="image_source" value="" /></p>
<p>
	<input type="file" name="userfile" class="" size="20" /></p>
<p><input type="submit" class="button attach-variety-image" value="Attach"/>
</p>
</form>
