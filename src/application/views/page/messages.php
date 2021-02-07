<?php
$has_message = FALSE;
 if($this->session->flashdata("notice")):?>
<div id="notice" class="message notice" data-clipboard-target="#notice">
	<h2>NOTICE</h2><?php echo $this->session->flashdata('notice');?></div>
<?php $has_message = TRUE;?>
<?php endif;?>
<?php if($this->session->flashdata("alert")):?>
	<div id="alert" class="message alert" data-clipboard-target="#alert"><h2>ALERT</h2><?php echo $this->session->flashdata('alert');?></div>
<?php $has_message = TRUE;?>

<?php endif;?>
