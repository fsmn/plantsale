<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tabloid.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com

?>
<html>
<head>
<title>Tabloid Sign</title>
<link
	type="text/css"
	rel="stylesheet"
	media="all"
	href="<?=base_url("css/signage.css")?>" />
</head>
<body class="tabloid portrait">
	<div class="catalog-number">A321</div>
	<div class="common-name">Dental Floss</div>
	<div class="latin-name">Lombricoides</div>
	<div class="variety">Aescarus</div>
	<div class="image">
		<img src="<?=site_url("files/1078.jpg");?>" />
	</div>
	<div class="description">Fuzzy flower heads in attractive umbels. Easy
		to grow. Seeds eaten by finches.</div>
	<div class="note">Lavender-blue. Tall, vigorous, and good for cutting.</div>
	<div class="details-group">
		<div class="price-group">
			<div class="pot-size">6 plants in a pack</div>
			<div class="price"><?=get_as_price(5);?></div>
		</div>
		<div class="icons">
			<ul class="sunlight">
				<li class="full_sun">Full Sun</li>
				<li class="part-sun">Part Sun</li>
			</ul>
			<ul class="flags">
				<li class="bees">Bees</li>
				<li class="new">New</li>
				<li class="saturday">Saturday Delivery</li>
			</ul>
		</div>
		<div class="dimensions">
			<div class="width">
				<label>Width</label>
				<div class="text">20-30 inches</div>
			</div>
			<div class="height">
				<label>Height</label>
				<div class="text">20-30 inches</div>
			</div>
		</div>
		<div class="grower-name">Rush Creek Growers</div>
	</div>
	<div class="internals">
		<div class="year">Year: 2014</div>
		<div class="grower">RC</div>
	</div>
</body>
</html>