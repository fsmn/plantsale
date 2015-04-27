<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<link
	type="text/css"
	rel="stylesheet"
	media="all"
	href="<?=base_url("css/$format.css")?>" />
<style type="text/css">
@media print {
	.no-print {
		display: none;
	}
}

a {
	text-decoration: none;
	color: #000;
}

a:hover {
	text-decoration: underline;
}

.price:hover,.pot-size:hover {
	background-color: yellow;
	cursor: pointer;
}
</style>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="<?=base_url("js/signs.js");?>"></script>