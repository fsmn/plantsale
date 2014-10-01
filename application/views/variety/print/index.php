<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
<title><?=$title;?></title>
<? $this->load->view("variety/print/head"); ?>
</head>
<body class="<?=$classes;?>">
<? $this->load->view($target); ?>
<div id="crop-failure">
<? if($order->crop_failure == 1):?>
CROP FAILURE
<? endif;?>
</div>
</body>
</html>