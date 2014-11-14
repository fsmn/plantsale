<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($print) && $print == TRUE){
	$print = TRUE;
}else{
	$print = FALSE;
}
$body_classes[] = $this->uri->segment(1);
if($this->uri->segment(1) == ""){
	$body_classes[] = "front";
}

if($this->ion_auth->logged_in()){
	$body_classes[] = "logged-in";
	    if($this->ion_auth->in_group(array(1,2))){

	    $body_classes[] = "editor";
	}else{
	    $body_classes[] = "viewer";
	}
}else{
	$body_classes[] = "not-logged-in";
}



$body_class = implode(" ",$body_classes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<? $this->load->view('page/head');?>
</head>
<body class="browser <?=$body_class;?>">
<div id="page">
<?php if(!$print): ?>
<div id='header'>
<? if($_SERVER['HTTP_HOST'] == "plantsale.server.fsmn"): ?>
<div id="page-title" class="alert">WARNING: THIS IS THE STAGING SERVER!</div>
<? else: ?>
<div id='page-title'>Friends School Plant Sale Database</div>
<? endif;?>
<? if($this->ion_auth->logged_in()):?>
<div id='utility'><? $this->load->view('page/utility');?></div>
<div id='navigation'>
<?  $this->load->view('page/navigation'); ?>
</div>
<? endif;?>
</div>
<?php endif; ?>

<!-- main -->

<div id="main"><!-- content -->
<div id="content">
<? if($this->session->flashdata("notice")):?>
<div id="notice"><?=$this->session->flashdata('notice');?></div>
<? endif;?>
<?
$this->load->view($target);
?></div>
<!-- end content -->
<div id="sidebar"></div>
<!-- end sidebar --></div>
<div id='search_list'></div>
<div id='autocomplete'></div>
<div id="footer"><?$this->load->view('page/footer');?></div>
</div>
<div class='mr-shmallow-image'><img src='/images/MrShmallow.png'/></div>
</body>
</html>
