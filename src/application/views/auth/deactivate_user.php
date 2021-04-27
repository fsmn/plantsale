<h1><?php print lang('deactivate_heading'); ?></h1>
<p><?php print sprintf(lang('deactivate_subheading'), $user->username); ?></p>

<?php print form_open('auth/deactivate/' . $user->id); ?>

<p>
  <?php print form_label('Yes', 'confirm'); ?>
  <input type="radio" name="confirm" value="yes" checked="checked" />
  <?php print form_label('No', 'confirm'); ?>
  <input type="radio" name="confirm" value="no" />
</p>

<?php print form_hidden($csrf); ?>
<?php print form_hidden(array('id' => $user->id)); ?>

<p><?php print form_submit('submit', 'Deactivate', 'class="button edit"'); ?></p>

<?php print form_close(); ?>