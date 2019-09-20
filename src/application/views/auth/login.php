<div class="login">
<h2>Friends School Plantsale Database</h2>
<p><a style="font-weight:bold;" href="forgot_password">Forgot your password?</a></p>
<?php  if(isset($message) && $message != ''):?>
<div class="message alert"><?php echo $message;?></div>
<?php endif;?>
<?php echo form_open("auth/login");?>

  <p>
    <?php echo form_input($identity,"","placeholder='email address'");?>
  </p>

  <p>
    <?php echo form_input($password,"","placeholder='password'");?>
  </p>

  <p><?php echo form_submit('submit', "Login", "class='button'");?></p>

<?php echo form_close();?>

</div>
