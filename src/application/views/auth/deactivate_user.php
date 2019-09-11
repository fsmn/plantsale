<h1><?php echo lang('deactivate_heading');?></h1>
<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

<?php echo form_open("auth/deactivate/".$user->id);?>

  <p>
  	<?php echo form_label("Yes", 'confirm');?>
    <input type="radio" name="confirm" value="yes" checked="checked" />
    <?php echo form_label("No", 'confirm');?>
    <input type="radio" name="confirm" value="no" />
  </p>

  <?php echo form_hidden($csrf); ?>
  <?php echo form_hidden(array('id'=>$user->id)); ?>

  <p><?php echo form_submit('submit', "Deactivate","class='button edit'");?></p>

<?php echo form_close();?>