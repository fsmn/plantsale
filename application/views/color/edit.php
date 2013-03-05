<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<form name="color-editor" id="color-editor" action="<?=site_url("color/$action");?>" method="post">
<input type="hidden" id="id" name="id" value="<?=get_value($color, "id");?>"/>
<input type="hidden" id="common_id" name="common_id" value="<?=$common_id;?>"/>
<p><?=create_input($color,"species","Species");?></p>
<p><?=create_input($color,"color","Color");?></p>
<p><?=create_input($color,"min_height","Min-Height");?></p>
<p><?=create_input($color,"max_height","Max-Height");?></p>
<p><?=create_input($color,"min_width","Min-Width");?></p>
<p><?=create_input($color,"max_width","Max-Width");?></p>
<p><textarea id="note" name="note"><?=get_value($color,"note");?></textarea>
<p>
<input type="submit" name="submit" value="<?=ucfirst($action);?>"/>
</p>
</form>