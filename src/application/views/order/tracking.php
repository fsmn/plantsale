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
		<tr id="order_<?php echo $order->id;?>">
		<td><?php echo $order->catalog_number;?></td>
		<td><?php echo $order->count_presale;?></td>
		<td><?php echo $order->flat_size;?></td>
		<td><?php echo $order->received_presale;?></td>
		<td class="big"></td>
		<td class="big"></td>
		<td class="no-wrap"><?php echo $order->name;?></td>
		<td class="no-wrap"><?php echo format_latin_name($order);?></td>
		<td class="no-wrap"><?php echo $order->variety;?></td>
		<td class="no-wrap"><?php echo $order->pot_size;?></td>
		<td><?php echo $order->grower_id;?></td>
		<td><?php echo $order->category;?></td>
</tr>
		<?php endforeach;?>
	</tbody>
</table>


<?php endif;
