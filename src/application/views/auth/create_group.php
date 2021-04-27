<h1><?php print lang('create_group_heading'); ?></h1>
<p><?php print lang('create_group_subheading'); ?></p>

<div id="infoMessage"><?php print $message; ?></div>

<?php print form_open('auth/create_group'); ?>

<p>
    <?php print form_label('Group Name:', 'group_name'); ?> <br />
    <?php print form_input($group_name); ?>
</p>

<p>
    <?php print form_label('Description:', 'description'); ?> <br />
    <?php print form_input($description); ?>
</p>

<p><?php print form_submit('submit', 'Add Group', 'class="button new"'); ?></p>

<?php print form_close(); ?>