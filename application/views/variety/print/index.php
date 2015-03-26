<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
<title><?=$title;?></title>
<? $this->load->view("variety/print/head"); ?>

</head>
<body class="<?=$classes;?>">
<? $this->load->view($target); ?>
</body>
</html>