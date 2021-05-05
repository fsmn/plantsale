<div class="login">
      <h2><?php print lang('forgot_password_heading'); ?></h2>
      <p><?php print sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>

      <div id="infoMessage"><?php print $message; ?></div>

      <?php print form_open('auth/forgot_password'); ?>

      <p>
            <label for="email"><?php print format_string('@identity_label:', ['@identity_label' => $identity_label]); ?></label>
            <?php print form_input($email); ?>
      </p>

      <p><?php print form_submit('submit', 'Reset Password', 'class="button edit"'); ?></p>

      <?php print form_close(); ?>
</div>