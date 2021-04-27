<h1><?php print lang('create_user_heading'); ?></h1>
<p><?php print lang('create_user_subheading'); ?></p>

<div id="infoMessage"><?php print $message; ?></div>

<?php print form_open('auth/create_user'); ?>

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
      <?php print form_label('Confirm Password:', 'password_confirm'); ?> <br />
      <?php print form_input($password_confirm); ?>
</p>


<p><?php print form_submit('submit', 'Create User', 'class="button new"'); ?></p>

<?php print form_close(); ?>