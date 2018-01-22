<?php

?>
<form method="post" enctype="multipart/form-data" name="variety-image-editor" id="variety-image-editor" action="<?php echo site_url("variety/attach_image");?>">
<input type="hidden" name="variety_id" id="variety_id" value="<?php echo $variety_id;?>"/>
<input type="hidden" name="id" id="id" value="<?php echo get_value($image,'id');?>"/>

<p>
<strong>Image must be no larger than 2 MB</strong>
<br/>
	<input type="file" name="userfile" class="" size="20" /></p>
	<p><label for="image_source">Attribution or Source</label><br />
<input type="text" name="image_source" id="image_source" value="Unknown" required/></p>
<p><input type="submit" class="button attach-variety-image" value="Attach"/>
</p>
</form>
