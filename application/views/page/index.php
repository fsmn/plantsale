<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
if (isset ( $print ) && $print == TRUE) {
	$print = TRUE;
} else {
	$print = FALSE;
}
$body_classes [] = $this->uri->segment ( 1 );
if ($this->uri->segment ( 1 ) == "") {
	$body_classes [] = "front";
}

if ($this->ion_auth->logged_in ()) {
	$body_classes [] = "logged-in";
	if (IS_EDITOR) {
		
		$body_classes [] = "editor";
	} else {
		$body_classes [] = "viewer";
	}
} else {
	$body_classes [] = "not-logged-in";
}

$body_class = implode ( " ", $body_classes );
?>
<!DOCTYPE html>
<html>
<head>
<?php $this->load->view('page/head');?>
</head>
<body class="browser <?php echo $body_class;?>">
	<div id="page-wrapper">
		<div id="page">
<?php if(!$print): ?>
<div id='header'>
<?php if($_SERVER['HTTP_HOST'] == "plantsale"): ?>
<div id="page-title" class="message alert">WARNING: THIS IS THE STAGING SERVER!</div>
<?php else: ?>
<div id='page-title'>Friends School Plant Sale Database</div>
<?php endif;?>
<?php if($this->ion_auth->logged_in()):?>
<div id='utility'><?php $this->load->view('page/utility');?></div>
				<div id='navigation'>
<?php  $this->load->view('page/navigation'); ?>
</div>
<?php endif;?>
</div>
<?php endif; ?>

<!-- main -->

			<div id="main">
				<!-- content -->
				<div id="content">
				<?php $this->load->view("page/messages");?>
<?php
$this->load->view ( $target );
?></div>
				<!-- end content -->
				<div id="sidebar"></div>
				<!-- end sidebar -->
			</div>
			<div id='search_list'></div>
			<div id='autocomplete'></div>
		</div>
	</div>
	<div id="footer"><?$this->load->view('page/footer');?></div>

	<div class='mr-shmallow-image'>
		<img src='/images/MrShmallow.png' />
	</div>
</body>
</html>
