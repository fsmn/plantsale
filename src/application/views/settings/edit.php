<?php
if (empty($action)) {
	return FALSE;
}
?>
<?php if (!empty($title)): ?>
	<h3><?php print $title; ?></h3>
<?php endif; ?>
<?php if (!empty($description)): ?>
	<div class="description">
		<?php print $description; ?>
	</div>
<?php endif; ?>
<form name="settings" method="post" action="<?php print base_url('settings/' . $action); ?>">
	<?php foreach ($settings as $setting): ?>
	<div>
		<?php print form_input(['name'=>$key . '[]'],$setting->value);?>
	</div>
	<?php endforeach; ?>
	<div>
	<?php print form_input(['name'=>$key . '[]']);?>
	</div>
	<input type="submit" class="button" value="Save"/>
</form>
