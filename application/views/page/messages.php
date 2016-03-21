<?php
$has_message = FALSE;
 if($this->session->flashdata("notice")):?>
<div id="notice" class="message notice" data-clipboard-target="#notice"><?php echo $this->session->flashdata('notice');?></div>
<?php $has_message = TRUE;?>
<?php endif;?>
<?php if($this->session->flashdata("alert")):?>
<div id="alert" class="message alert" data-clipboard-target="#alert"><?php echo $this->session->flashdata('alert');?></div>
<?php $has_message = TRUE;?>

<?php endif;?>
<?php if($has_message):?>
<script src="https://cdn.jsdelivr.net/clipboard.js/1.5.8/clipboard.min.js"></script>
<script>new Clipboard(".message");</script>
<?php endif; 