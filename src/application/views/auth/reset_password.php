<h1><?php print lang('reset_password_heading'); ?></h1>

<div id="infoMessage"><?php print $message; ?></div>

<?php print form_open('auth/reset_password/' . $code); ?>

<p>
	<label for="new_password"><?php print sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label>
	<br />
	<?php print form_input($new_password); ?>
</p>

<p>
	<?php print lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?> <br />
	<?php print form_input($new_password_confirm); ?>
</p>

<?php print form_input($user_id); ?>
<?php print form_hidden($csrf); ?>

<p><?php print form_submit('submit', lang('reset_password_submit_btn'), 'class="button"'); ?></p>

<?php print form_close(); ?>