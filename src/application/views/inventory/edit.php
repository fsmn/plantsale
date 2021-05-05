<?php

function form_group($field_name, $field_value, $label, $field_type = 'text', $class = FALSE)
{
	if ($label) {
		$label_string = format_string('<label for="@field_name" class="control-label">@label</label>', [
			'@field_name' => $field_name,
			'@label' => $label,
		]);
	} else {
		$label_string = '';
	}
	$field = format_string('<input type="@field_type" class="form-control number @class" id="@field_name" name="@field_name" value="@field_value"/>', [
		'@field_type' => $field_type,
		'@class' => $class,
		'@field_name' => $field_name,
		'@field_value' => $field_value,
	]);
	$output = format_string('<div class="form-group">@label_string<div class="field-wrapper">@field</div></div>', [
		'@label_string' => $label_string,
		'@field' => $field,
	]);
	return $output;
}

$edit_fields = [
	'sellout_friday' => ['label' => 'Sellout Time Friday', 'type' => 'time', 'day' => 'Friday'],
	//"remainder_friday"=>array('label'=>"Remainder Friday",'type'=>"text",'day'=>"Friday"),
	//"received_midsale"=> array('label'=>"Received Saturday",'type'=>"text",'day'=>"Saturday"),
	'sellout_saturday' => ['label' => 'Sellout Saturday', 'type' => 'time', 'day' => 'Saturday'],
	//"remainder_sunday"=>array('label'=>"Remainder Sunday",'type'=>"text",'day'=>"Sunday"),
	//"count_dead"=>array('label'=>"Dead Count",'type'=>"text",'day'=>"Sunday"),
];


?>
<form name="inventory-editor" id="inventory-editor" class="form" method="post" action="<?php print site_url('inventory/check'); ?>">
	<input type="hidden" name="id" value="<?php print $item->id; ?>" />
	<input type="hidden" name="step" value="<?php print $step; ?>" />
	<input type="hidden" name="catalog_number" value="<?php print $item->catalog_number; ?>" />
	<div class="row">
		<div class="col-xs-6 col-xs-offset-2" style="position: relative;">
			<?php foreach ($edit_fields as $field => $key) : ?>
				<?php $today = date('l'); ?>
				<?php if (in_array($today, ['Monday', 'Tuesday', 'Wednesday', 'Thursday']) || $key['day'] == $today || IS_EDITOR) : ?>
					<?php print form_group($field, $step == 1 ? $item->$field : cookie($field), $key['label'], $key['type']); ?>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3 col-xs-offset-1">
			<button type="submit" class="btn btn-lg btn-success" id="submit" name="submit">Submit</button>
		</div>
		<div class="col-xs-3 col-xs-offset-2">
			<a href="<?php print site_url('inventory/index'); ?>" class="btn btn-danger btn-lg">Cancel</a>
		</div>
	</div>
</form>