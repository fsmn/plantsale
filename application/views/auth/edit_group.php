<h1><?php echo lang('edit_group_heading');?></h1>
<p><?php echo lang('edit_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open(current_url());?>

      <p>
            <?php echo form_label("Group Name:", 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo form_label("Description:", 'description');?> <br />
            <?php echo form_input($group_description);?>
      </p>

      <p><?php echo form_submit('submit', "Save","class='button edit'");?></p>

<?php echo form_close();?>