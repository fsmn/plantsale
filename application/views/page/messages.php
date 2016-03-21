<?php
if($this->session->flashdata("notice")):?>
<div id="notice" class="message notice" data-clipboard-target="#notice"><?php echo $this->session->flashdata('notice');?></div>
<?php endif;?>
<?php if($this->session->flashdata("alert")):?>
<div id="alert" class="message alert" data-clipboard-target="#alert"><?php echo $this->session->flashdata('alert');?></div>
<?php endif;?>
<script>new Clipboard(".message");</script>