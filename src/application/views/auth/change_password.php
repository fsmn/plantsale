<h1><?php echo lang('change_password_heading');?></h1>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/change_password");?>

      <p>
            <?php echo form_label("Old Password", 'old_password');?> <br />
            <?php echo form_input($old_password);?>
      </p>

      <p>
            <label for="new_password"><?php echo sprintf("New Password (at least %s characters long):", $min_password_length);?></label> <br />
            <?php echo form_input($new_password);?>
      </p>

      <p>
            <?php echo form_label("Confirm New Password:", 'new_password_confirm');?> <br />
            <?php echo form_input($new_password_confirm);?>
      </p>

      <?php echo form_input($user_id);?>
      <p><?php echo form_submit('submit', "Change Password","class='button edit'");?></p>

<?php echo form_close();?>
