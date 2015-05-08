<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders)
:
	?>
<!-- order/sellouts -->
<table class="list sellouts small">
	<thead>
		<tr class="top-row">
			<th></th>
			<th colspan=3>Wednesday</th>
			<th class="no-wrap" colspan=2>Sold Out Time</th>
			<th colspan=6></th>
		</tr>
		<tr>
			<th>Cat&#35;</th>
			<th>Ord'd</th>
			<th>Per-Flat</th>
			<th>Rec'd</th>
			<th class="big">Fri</th>
			<th class="big">Sat</th>
			<th>Common</th>
			<th>Latin</th>
			<th>Variety</th>
			<th>Pot Size</th>
			<th>Grower</th>
			<th>Category</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($orders as $order):?>
		<tr id="order_<?=$order->id;?>">
		<td><?=$order->catalog_number;?></td>
		<td><?=$order->count_presale;?></td>
		<td><?=$order->flat_size;?></td>
		<td><?=$order->received_presale;?></td>
		<td class="big"></td>
		<td class="big"></td>
		<td class="no-wrap"><?=$order->name;?></td>
		<td class="no-wrap"><?=format_latin_name($order->genus,$order->species);?></td>
		<td class="no-wrap"><?=$order->variety;?></td>
		<td class="no-wrap"><?=$order->pot_size;?></td>
		<td><?=$order->grower_id;?></td>
		<td><?=$order->category;?></td>
</tr>
		<? endforeach;?>
	</tbody>
</table>


<? endif;
