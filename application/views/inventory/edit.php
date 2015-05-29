<?php

function form_group($field_name, $field_value, $label, $field_type = "text", $class=FALSE)
{
	if($label){
	$label_string = sprintf ( "<label for='%s' class='control-label col-sm-2'>%s</label>", $field_name, $label );
	}else{
		$label_string = "";
	}
	$field = sprintf ( "<input type='%s' class='form-control number %s' id='%s' name='%s' value='%s'/>", $field_type, $class, $field_name,$field_name, $field_value);
	$output = sprintf ( "<div class='form-group'>%s<div class='field-wrapper col-sm-10'>%s</div></div>", $label_string, $field );
	return $output;
}

$edit_fields = array (
		"received_presale" => array("label"=>"Rec'd Thurs","type"=>"text"),
		"sellout_friday" => array("label"=>"Sellout Time Fri","type"=>"time"),
		"remainder_friday"=>array("label"=>"Rem. Fri","type"=>"text"),
		"received_midsale"=> array("label"=>"Rec'd Sat","type"=>"text"),
		"sellout_saturday"=>array("label"=>"Sellout Sat","type"=>"time"),
		"remainder_sunday"=>array("label"=>"Rem. Sun","type"=>"text"),
		"count_dead"=>array("label"=>"Dead Count","type"=>"text"),
		
		
);


?>
<form name="inventory-editor" id="inventory-editor" class="form-horizontal" method="post" action="<?php echo site_url("inventory/check");?>">
<input type="hidden" name="id" value="<?php echo $item->id;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="catalog_number" value="<?php echo $item->catalog_number;?>"/>
<?php foreach ($edit_fields as $field=>$key):?>
<?php echo form_group($field, $step==1?$item->$field:get_cookie($field), $key['label'] ,$key['type']);?>
<?php endforeach;?>
<?php echo form_group("submit","Submit",FALSE,"submit","btn btn-success");?>
</form>
