<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if (!empty($orders)) :
	//sort by catalog number
	usort($orders, function($a,$b){
		return $a->catalog_number > $b->catalog_number;
	});
// used for sorting below if there's no $option[category]
	$last_category = NULL;
	if(empty($options['category'])):	?>
		<h1 class="no-print alert message">For best results, you should select a category to print this report. <a href="<?php print base_url('order/search?refine=1');?>" class="search refine dialog search-orders active">Try again?</a> </h1>
	<?php endif; ?>

<h3>Printable Shelf-Checking Report</h3>
	<?php print create_button_bar(['refine'=>['text'=>'Refine','class'=>['no-print','search','button','refine','dialog'], 'href'=>base_url('order/search')]]); ?>
	<!-- order/shelfchecking -->
	<table class="list shelf-checking small">
		<thead>
		<?php if (!empty($options['category'])): ?>
			<tr>
				<th class="inventory-tracking-title"><?php print $options['category']; ?></th>
			</tr>
		<?php endif; ?>
			<tr>
				<th>Yr</th>
				<th>Cat&#35;</th>
				<th class="text-cell">Common Name</th>
				<th class="no-wrap">Pot-Size</th>
				<th class="text-cell">Variety</th>
				<th>Weds<br />Ordered</th>
				<th>Qty</th>
				<th class="no-wrap">Too tall<br /> for table</th>
				<th>Needs<br />Sign</th>
				<th>Needs<br />Tags</th>
				<th>Comments</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($orders as $order) : ?>
				<?php if (empty($options['category']) && $last_category != $order->category): ?>
					<tr>
						<td colspan="11"><strong><?php print $order->category; ?></strong></td>
					</tr>
					<?php $last_category = $order->category; ?>
				<?php endif; ?>
				<tr id="order_<?php print $order->id; ?>">
					<td><?php print $order->year; ?></td>
					<td><?php print $order->catalog_number; ?></td>
					<td><?php print $order->name; ?></td>
					<td class="no-wrap"><?php print $order->pot_size; ?></td>
					<td><?php print $order->variety; ?></td>
					<td><?php print $order->count_presale; ?></td>
					<td class="checkbox">&nbsp;</td>
					<td class="checkbox">&nbsp;</td>
					<td class="checkbox">&nbsp;</td>
					<td class="checkbox">&nbsp;</td>
					<td class="comment">&nbsp;</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
