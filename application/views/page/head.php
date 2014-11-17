<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<!--<meta name="viewport"
		content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
		--><title><?=$title;?></title>
<link type="text/css" rel="stylesheet" media="all" href="<?=base_url("css/main.css")?>" />
<link type="text/css" rel="stylesheet" media="all" href="<?=base_url("css/color.css")?>"/>
<link type="text/css" rel="stylesheet" media="all" href="<?=base_url("css/popup.css")?>" />
<? if($this->ion_auth->in_group(array(1,2))): ?>
<link type="text/css" rel="stylesheet" media="screen" href="<?=base_url("css/edit.css");?>"/>
<? endif;?>
<link type="text/css" rel="stylesheet" media="print" href="<?=base_url("css/print.css")?>" />
<!-- jquery scripts -->
<script type="text/javascript">
var base_url = '<?=base_url("index.php") . "/";?>';
</script>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=base_url("js/stickytable.js");?>"></script>

<!-- General Script  -->
<script type="text/javascript" src="<?=base_url("js/general.js");?>"></script>

<? if($this->ion_auth->in_group(array(1,2))) {
   //$this->load->view("page/secure_javascript.php");
} ?>
<!-- Common Name Scripts -->
<script type="text/javascript" src="<?=base_url("js/common.js");?>"></script>

<!-- variety Scripts -->
<script type="text/javascript" src="<?=base_url("js/variety.js");?>"></script>

<!-- Order Scripts -->
<script type="text/javascript" src="<?=base_url("js/order.js");?>"></script>

<!-- admin scripts -->
<script type="text/javascript" src="<?=base_url("js/password.js");?>"></script>
<script type="text/javascript" src="<?=base_url("js/user.js");?>"></script>