<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<html>
<head>
<title><?php print $title;?></title>
<?php $this->load->view('variety/print/head'); ?>

</head>
<body class="<?php print $classes;?>">
<?php $this->load->view($target); ?>
</body>
</html>
