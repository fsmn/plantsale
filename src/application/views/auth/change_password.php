<h1><?php print lang('change_password_heading');?></h1>

<div id="infoMessage"><?php print $message;?></div>

<?php print form_open('auth/change_password');?>

<p>
    <?php print form_label('Old Password', 'old_password');?> <br />
    <?php print form_input($old_password);?>
</p>

<p>
    <label
        for="new_password"><?php print sprintf('New Password (at least %s characters long):', $min_password_length);?></label>
    <br />
    <?php print form_input($new_password);?>
</p>

<p>
    <?php print form_label('Confirm New Password:', 'new_password_confirm');?> <br />
    <?php print form_input($new_password_confirm);?>
</p>

<?php print form_input($user_id);?>
<p><?php print form_submit('submit', 'Change Password','class="button edit"');?></p>

<?php print form_close();?>