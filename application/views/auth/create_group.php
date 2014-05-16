<h1><?php echo lang('create_group_heading');?></h1>
<p><?php echo lang('create_group_subheading');?></p>

<div id="infoMessage"><?php echo $message;?></div>

<?php echo form_open("auth/create_group");?>

      <p>
            <?php echo form_label("Group Name:", 'group_name');?> <br />
            <?php echo form_input($group_name);?>
      </p>

      <p>
            <?php echo form_label("Description:", 'description');?> <br />
            <?php echo form_input($description);?>
      </p>

      <p><?php echo form_submit('submit', "Add Group","class='button new'");?></p>

<?php echo form_close();?>