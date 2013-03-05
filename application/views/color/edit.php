<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<form name="color-editor" id="color-editor" action="<?=site_url("color/$action");?>" method="post">
<input type="hidden" id="id" name="id" value="<?=get_value($color, "id");?>"/>
<input type="hidden" id="common_id" name="common_id" value="<?=$common_id;?>"/>
<p><?=create_input($color,"species","Species");?></p>
<p><?=create_input($color,"color","Color");?></p>
<p><?=create_input($color,"height","Height");?></p>
<p><?=create_input($color,"width","Width");?></p>
<p><textarea id="note" name="note"><?=get_value($color,"note");?></textarea>
<p>
<input type="submit" name="submit" value="<?=ucfirst($action);?>"/>
</p>
</form>