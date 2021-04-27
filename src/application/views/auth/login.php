<div class="login">
  <h2>Friends School Plantsale Database</h2>
  <p><a style="font-weight:bold;" href="forgot_password">Forgot your password?</a></p>
  <?php if (isset($message) && $message != '') : ?>
    <div class="message alert"><?php print $message; ?></div>
  <?php endif; ?>
  <?php print form_open('auth/login'); ?>

  <p>
    <?php print form_input($identity, '', 'placeholder="email address"'); ?>
  </p>

  <p>
    <?php print form_input($password, '', 'placeholder="password"'); ?>
  </p>

  <p><?php print form_submit('submit', 'Login', 'class="button"'); ?></p>

  <?php print form_close(); ?>

</div>