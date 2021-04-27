<h1><?php print lang('edit_group_heading'); ?></h1>
<p><?php print lang('edit_group_subheading'); ?></p>

<div id="infoMessage"><?php print $message; ?></div>

<?php print form_open(current_url()); ?>

<p>
      <?php print form_label('Group Name:', 'group_name'); ?> <br />
      <?php print form_input($group_name); ?>
</p>

<p>
      <?php print form_label('Description:', 'description'); ?> <br />
      <?php print form_input($group_description); ?>
</p>

<p><?php print form_submit('submit', 'Save', 'class="button edit"'); ?></p>

<?php print form_close(); ?>