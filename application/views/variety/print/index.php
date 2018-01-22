<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
<title><?php echo $title;?></title>
<?php $this->load->view("variety/print/head"); ?>

</head>
<body class="<?php echo $classes;?>">
<?php $this->load->view($target); ?>
</body>
</html>