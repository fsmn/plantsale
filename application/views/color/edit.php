<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<form name="color-editor" id="color-editor" action="<?=site_url("color/$action");?>" method="post">
<input type="hidden" id="id" name="id" value="<?=get_value($color, "id");?>"/>
<input type="hidden" id="common_id" name="common_id" value="<?=$common_id;?>"/>
<p><?=create_input($color,"species","Species");?></p>
<p><?=create_input($color,"color","Color");?></p>

<div class="field-group">
<div class="label"><strong>Height</strong></div>
<div class="dimension field-set"><?=create_input($color,"min_height","Min");?></div>
<div class="dimension field-set"><?=create_input($color,"max_height","Max");?></div>
<div class="dimension field-set"><label for="height_unit">Measure:</label><?=form_dropdown("height_unit",$measure_units, get_value($color,"height_unit"),"id='height_unit'");?></div>
</div>
<div class="field-group">
<div class="label"><strong>Width</strong></div>
<div class="dimension field-set"><?=create_input($color,"min_width","Min");?></div>
<div class="dimension field-set"><?=create_input($color,"max_width","Max");?></div>
<div class="dimension field-set"><label for="width_unit">Measure:</label><?=form_dropdown("width_unit",$measure_units, get_value($color,"width_unit"),"id='width_unit'");?></div>
</div>

<div class="field-group"><label for="note">Note:</label><br/><textarea id="note" name="note"><?=get_value($color,"note");?></textarea></div>
<div class="field-group"><label for="add_order">Add a New Order for this Color:</label><input type="checkbox" id="add_order" name="add_order" checked value="true"/>
</div>
<div class="button-box">
<input type="submit" name="submit" class="color-<?=$action;?>" value="<?=ucfirst($action);?>"/>
</div>
</form>