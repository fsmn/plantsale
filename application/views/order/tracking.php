<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders)
:
	?>
<!-- order/tracking -->
<h3>Inventory Tracking Printable Report</h3>
<div style="margin-bottom:2em;width:100%;" class="no-wrap">
Your Name: <input type="text" style="padding: .5em;width:25em;" value="" name="your_name"/>&nbsp;
Start time: <input type="text" name="your_start_time" value="" style="padding: .5em; width:10em;"/>&nbsp;
End Time: <input type="text" name="your_end_time" value="" style="padding: .5em; width: 10em;"/>
</div>
<table class="list tracking small">
	<thead>
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
