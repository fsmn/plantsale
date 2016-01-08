<div class="login">
<h2>Friends School Plantsale Database</h2>
<p><?php echo lang('login_subheading');?></p>
<?php if(isset($message)):?>
<div class="message alert"><?php echo $message;?></div>
<?php endif;?>
<?php echo form_open("auth/login");?>

  <p>
    <label for="identity">Email/Username: </label>
    <?php echo form_input($identity);?>
  </p>

  <p>
    <label for='password'>Password: </label>
    <?php echo form_input($password);?>
  </p>

  <p><?php echo form_submit('submit', "Login", "class='button'");?></p>

<?php echo form_close();?>

<p><a style="font-weight:bold;" href="forgot_password">Forgot your password?</a></p>
</div>