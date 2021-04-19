<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders) :
?>
	<!-- order/tracking -->
	<h3>Inventory Tracking Printable Report</h3>
	<div style="margin-bottom:2em;width:100%;" class="no-wrap">
		Your Name: <input type="text" style="padding: .5em;width:25em;" value="" name="your_name" />&nbsp;
		Start time: <input type="text" name="your_start_time" value="" style="padding: .5em; width:10em;" />&nbsp;
		End Time: <input type="text" name="your_end_time" value="" style="padding: .5em; width: 10em;" />
	</div>
	<table class="list tracking small">
		<thead>
			<tr>
				<th class="inventory-tracking-title"><?php print $options['category']; ?></th>
			</tr>
			<tr>
				<th>Cat&#35;</th>
				<th>Grower</th>
				<th>Price</th>
				<th>Genus</th>
				<th>Common</th>
				<th>Variety</th>
				<th>Pot Size</th>
				<th>Wed<br />Rec'd</th>
				<th>Fri<br />Rem</th>
				<th>Sat<br />Rec'd</th>
				<th>Sat<br />Rem</th>
				<th>Sun<br />Rem</th>
				<th>Sun<br />Dead</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($orders as $order) : ?>
				<tr id="order_<?php print $order->id; ?>">
					<td><?php print $order->catalog_number; ?></td>
					<td><?php print $order->grower_id; ?></td>
					<td><?php print $order->price; ?></td>
					<td><?php print $order->genus; ?></td>
					<td class="no-wrap"><?php print $order->name; ?></td>
					<td class="no-wrap"><?php print $order->variety; ?></td>
					<td class="no-wrap"><?php print $order->pot_size; ?></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
