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
		//"received_presale" => array("label"=>"Received Thursday","type"=>"text","day"=>"Thursday"),
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
<?php foreach ($edit_fields as $field=>$key):?>
<?php $today = date('l');?>
<?php if(in_array($today,array("Monday","Tuesday","Wednesday","Thursday")) || $key['day'] == $today || IS_EDITOR):?>
<?php echo form_group($field, $step==1?$item->$field:get_cookie($field), $key['label'] ,$key['type']);?>
<?php endif;?>
<?php endforeach;?>
<div class="field-wrapper col-sm-5 col-md-2">
<input type="submit" class="form-control number btn btn-success" id="submit" name="submit" value="Submit"></div>
</form>
