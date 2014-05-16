<h1><?php echo lang('create_user_heading');?></h1>
<p><?php echo lang('create_user_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_user");?>

      <p>
            <?php echo form_label("First Name:", 'first_name');?> <br />
            <?php echo form_input($first_name);?>
      </p>

      <p>
            <?php echo form_label("Last Name:", 'last_name');?> <br />
            <?php echo form_input($last_name);?>
      </p>
      <p>
            <?php echo form_label("Email:", 'email');?> <br />
            <?php echo form_input($email);?>
      </p>
      <p>
            <?php echo form_label("Password:", 'password');?> <br />
            <?php echo form_input($password);?>
      </p>

      <p>
            <?php echo form_label("Confirm Password:", 'password_confirm');?> <br />
            <?php echo form_input($password_confirm);?>
      </p>


      <p><?php echo form_submit('submit', "Create User","class='button new'");?></p>

<?php echo form_close();?>
