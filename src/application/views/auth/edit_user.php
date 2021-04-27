<?php if (!$ajax) : ?>
	<h1><?php print lang('edit_user_heading'); ?></h1>
	<p><?php print lang('edit_user_subheading'); ?></p>
<?php endif; ?>
<div id="infoMessage"><?php print $message; ?></div>

<?php print form_open(uri_string()); ?>

<p>
	<?php print form_label('First Name:', 'first_name'); ?> <br />
	<?php print form_input($first_name); ?>
</p>

<p>
	<?php print form_label('Last Name:', 'last_name'); ?> <br />
	<?php print form_input($last_name); ?>
</p>
<p>
	<?php print form_label('Email:', 'email'); ?> <br />
	<?php print form_input($email); ?>
</p>
<p>
	<?php print form_label('Password:', 'password'); ?> <br />
	<?php print form_input($password); ?>
</p>

<p>
	<?php print form_label('Confirm Password:', 'password_confirm'); ?><br />
	<?php print form_input($password_confirm); ?>
</p>

<?php if ($this->ion_auth->is_admin()) : ?>

	<h3>Member of Groups</h3>
	<?php foreach ($groups as $group) : ?>
		<label class="checkbox">
			<?php
			$gID = $group['id'];
			$checked = null;
			$item = null;
			foreach ($currentGroups as $grp) {
				if ($gID == $grp->id) {
					$checked = ' checked="checked"';
					break;
				}
			}
			?>
			<input type="checkbox" name="groups[]" value="<?php print $group['id']; ?>" <?php print $checked; ?>>
			<?php print $group['name']; ?>
		</label>
	<?php endforeach ?>

<?php endif ?>

<?php print form_hidden('id', $user->id); ?>
<?php print form_hidden($csrf); ?>

<p><?php print form_submit('submit', 'Save User', 'class="button"'); ?></p>

<?php print form_close(); ?>