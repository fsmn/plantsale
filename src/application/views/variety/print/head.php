<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link
		type="text/css"
		rel="stylesheet"
		media="all"
		href="<?php echo base_url('css/' . $format . '.css?') . date('U'); ?>"/>
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

	.price:hover, .pot-size:hover, .catalog-number:hover {
		background-color: yellow;
		cursor: pointer;
	}
</style>
<script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="<?php print base_url('js/signs.js'); ?>"></script>
