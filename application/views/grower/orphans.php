<?php

defined('BASEPATH') or exit('No direct script access allowed');

// orphans.php Chris Dart Jan 12, 2015 3:47:05 PM chrisdart@cerebratorium.com
$sale_year = get_cookie("sale_year");
?>
<h3><?=$title;?></h3>
<p><?=$message;?></p>
<? if($orphans): ?>
<table class="list">
	<thead>
		<tr>
			<th>Grower ID</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<? foreach($orphans as $orphan):?>
<tr>
			<td>
<?=$orphan->grower_id;?>
</td>
			<td><a
				href="<?=site_url("grower/create/$orphan->grower_id");?>"
				class="button new"
				title="Create a new record for this grower">Add Grower</a></td>
			<td><a
				href="<?=site_url("order/search?grower_id=$orphan->grower_id&year=$sale_year&sorting%5B%5D=genus&direction%5B%5D=ASC");?>"
				title="Show Orders from this Orphan Grower">Show Orders</a></td>
		</tr>

<? endforeach;?>
</tbody>
</table>
<? endif;