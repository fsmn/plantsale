<?php
if(empty($preferences) || empty($action) || empty($user_id)){
	return FALSE;
}
?>
<form name="preferences" method="post" action="<?php print base_url('preference/' . $action);?>">
	<input type="hidden" name="user_id" value="<?php print $user_id; ?>">
<?php foreach($preferences as $preference):?>
<label for="<?php print $preference->id; ?>"><?php print $preference->name;?></label>
<?php if($preference->format == 'checkbox'):?>
	<?php print form_dropdown(['name'=>$preference->id,'options'=>explode(',',$preference->options)],$preference->value);?>
<?php endif;?>
<div class="description"><?php print $preference->description; ?></div>

<?php endforeach;?>
	<input type="submit" class="button" value="<?php print ucfirst($action); ?>">
</form>

