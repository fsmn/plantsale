<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
<title><?=$title;?></title>
<? $this->load->view("variety/print/head"); ?>
<style type="text/css">
@media print {
	.no-print {
		display: none;
	}
	a {
	color: #000;
	text-decoration: none;
	}
}

</style>
</head>
<body class="<?=$classes;?>">
	<a
		href="javascript:history.back();"
		class="no-print">Back</a>
<? $this->load->view($target); ?>
</body>
</html>