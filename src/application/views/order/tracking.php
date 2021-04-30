<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if (!empty($orders)) :
	//make sure they're sorted by catalog number
	usort($orders, function($a,$b){
		return $a->catalog_number > $b->catalog_number;
	});
	// used for sorting below if there's no $option[category]
	$last_category = NULL;
	if(empty($options['category'])):?>
		<h1 class="no-print alert message">For best results, you should select a category to print this report. <a href="<?php print base_url('order/search?refine=1');?>" class="search refine dialog search-orders active">Try again?</a> </h1>
	<?php endif; ?>
	<!-- order/tracking -->
	<h3 class="no-print">Inventory Tracking Printable Report</h3>

	<table class="list tracking small">
		<thead>
		<?php if (!empty($options['category'])): ?>
			<tr>
				<th class="inventory-tracking-title"><?php print $options['category']; ?></th>
			</tr>
		<?php endif; ?>
		<tr>
			<th colspan="14">
				<div style="margin-bottom:2em;width:100%;" class="no-wrap">
					Your Name: <input type="text"
									  style="padding: .5em;width:25em;" value=""
									  name="your_name"/>&nbsp;
					Start time: <input type="text" name="your_start_time"
									   value=""
									   style="padding: .5em; width:10em;"/>&nbsp;
					End Time: <input type="text" name="your_end_time" value=""
									 style="padding: .5em; width: 10em;"/>
				</div>
			</th>
		</tr>

		<tr>
			<th>Cat&#35;</th>
			<th>Grower</th>
			<th>Common</th>
			<th>Variety</th>
			<th>Pot Size</th>
			<th>Cat&#35;</th>
			<th>Fri<br/>Rem</th>
			<th>Sat<br/>Rem</th>
			<th>Sun<br/>Rem</th>
		</tr>
		</thead>
		<tbody>

		<?php foreach ($orders as $order) : ?>
			<?php if (empty($options['category']) && $last_category != $order->category): ?>
				<tr>
					<td colspan="13"><strong><?php print $order->category; ?></strong></td>
				</tr>
				<?php $last_category = $order->category; ?>
			<?php endif; ?>
			<tr id="order_<?php print $order->id; ?>">
				<td><strong><?php print $order->catalog_number; ?></strong></td>
				<td><?php print $order->grower_id; ?></td>
				<td><strong><?php print $order->name; ?></strong></td>
				<td class="no-wrap"><?php print $order->variety; ?></td>
				<td class="no-wrap"><?php print $order->pot_size; ?></td>
				<td><strong><?php print $order->catalog_number; ?></strong></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
