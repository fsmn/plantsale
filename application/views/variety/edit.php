<?php defined('BASEPATH') OR exit('No direct script access allowed');
$colors = array();

if(!get_value($variety,"plant_color",FALSE)){
	$colors = explode(",",get_value($variety,"plant_color")) ;
}

//$plant_colors = create_checkbox("plant_color[]", $plant_colors, $colors );
$plant_colors = form_multiselect("plant_color[]",$plant_colors, $colors );
?>

<form name="variety-editor" id="variety-editor" action="<?=site_url("variety/$action");?>" method="post">
<input type="hidden" id="id" name="id" value="<?=get_value($variety, "id");?>"/>
<input type="hidden" id="common_id" name="common_id" value="<?=$common_id;?>"/>
<p><?=create_input($variety,"variety","Variety");?></p>
<p><?=create_input($variety,"species","Species");?></p>
<p>
<label for="new_year">First Year at Sale (YYYY)</label>
<input name="new_yeara" id="new_year" value="<?=get_cookie("sale_year");?>"/>
</p>
<div class="field-group">
<div class="label"><strong>Height</strong></div>
<div class="dimension field-set"><?=create_input($variety,"min_height","Min");?></div>
<div class="dimension field-set"><?=create_input($variety,"max_height","Max");?></div>
<div class="dimension field-set"><label for="height_unit">Measure:</label><?=form_dropdown("height_unit",$measure_units, get_value($variety,"height_unit"),"id='height_unit'");?></div>
</div>
<div class="field-group">
<div class="label"><strong>Width</strong></div>
<div class="dimension field-set"><?=create_input($variety,"min_width","Min");?></div>
<div class="dimension field-set"><?=create_input($variety,"max_width","Max");?></div>
<div class="dimension field-set"><label for="width_unit">Measure:</label><?=form_dropdown("width_unit",$measure_units, get_value($variety,"width_unit"),"id='width_unit'");?></div>
</div>
<div style="clear:both;">
<div class="label"><strong>Plant Color(s)</strong></div>
<div class="field-set"><?php echo $plant_colors; ?></div>
</div>
<div class="field-group"><label for="print_description">Variety Description:</label><br/><textarea id="print_description" name="print_description"><?=get_value($variety,"print_description");?></textarea></div>
<div class="field-group"><label for="web_description">Web Description:</label><br/><textarea id="web_description" name="web_description"><?=get_value($variety,"web_description");?></textarea></div>

<div class="field-group"><label for="add_order">Add a New Order for this variety:</label><input type="checkbox" id="add_order" name="add_order" checked value="true"/>
</div>
<div class="field-group"><label for="needs_copy_review">Needs Copy Review:</label><input type="checkbox" id="needs_copy_review" name="needs_copy_review" <?php echo $action=="insert"?"checked":""?> value="yes"/>
</div>
<div class="button-box">
<input type="submit" name="submit" class="variety-<?=$action;?> button <?php echo $action;?>" value="<?=ucfirst($action);?>"/>
</div>
</form>