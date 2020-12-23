<?php

function form_group($field_name, $field_value, $label, $field_type = "text", $class=FALSE)
{
	if($label){
	$label_string = sprintf ( "<label for='%s' class='control-label'>%s</label>", $field_name, $label );
	}else{
		$label_string = "";
	}
	$field = sprintf ( "<input type='%s' class='form-control number %s' id='%s' name='%s' value='%s'/>", $field_type, $class, $field_name,$field_name, $field_value);
	$output = sprintf ( "<div class='form-group'>%s<div class='field-wrapper'>%s</div></div>", $label_string, $field );
	return $output;
}

$edit_fields = array (
		"sellout_friday" => array("label"=>"Sellout Time Friday","type"=>"time","day"=>"Friday"),
		//"remainder_friday"=>array("label"=>"Remainder Friday","type"=>"text","day"=>"Friday"),
		//"received_midsale"=> array("label"=>"Received Saturday","type"=>"text","day"=>"Saturday"),
		"sellout_saturday"=>array("label"=>"Sellout Saturday","type"=>"time","day"=>"Saturday"),
		//"remainder_sunday"=>array("label"=>"Remainder Sunday","type"=>"text","day"=>"Sunday"),
		//"count_dead"=>array("label"=>"Dead Count","type"=>"text","day"=>"Sunday"),
);


?>
<form name="inventory-editor" id="inventory-editor" class="form" method="post" action="<?php echo site_url("inventory/check");?>">
<input type="hidden" name="id" value="<?php echo $item->id;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="catalog_number" value="<?php echo $item->catalog_number;?>"/>
<div class="row">
<div class="col-xs-6 col-xs-offset-2" style="position: relative;">
<?php foreach ($edit_fields as $field=>$key):?>
<?php $today = date('l');?>
<?php if(in_array($today,array("Monday","Tuesday","Wednesday","Thursday")) || $key['day'] == $today || IS_EDITOR):?>
<?php echo form_group($field, $step==1?$item->$field:cookie($field), $key['label'] ,$key['type']);?>
<?php endif;?>
<?php endforeach;?>
</div>
</div>
<div class="row">
<div class="col-xs-3 col-xs-offset-1">
<button type="submit" class="btn btn-lg btn-success" id="submit" name="submit">Submit</button>
</div>
<div class="col-xs-3 col-xs-offset-2">
<a href="<?php echo site_url("inventory/index");?>" class="btn btn-danger btn-lg">Cancel</a>
</div>
</div>
</form>
