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
		<h1 class="no-print alert message">For best results, you should select a category to print this report. <a href="<?php print base_url('order/search');?>" class="search refine dialog search-orders active">Try again?</a> </h1>
	<?php endif; ?>
<h3>Printable Sellouts Report </h3>
<?php print create_button_bar(['refine'=>['text'=>'Refine','class'=>['no-print','search','button','refine','dialog'], 'href'=>base_url('order/search')]]); ?>

	<!-- order/sellouts -->
	<table class="list sellouts small">
		<thead>
		<?php if (!empty($options['category'])): ?>
			<tr>
				<th class="inventory-tracking-title"><?php print $options['category']; ?></th>
			</tr>
		<?php endif; ?>
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
			<?php foreach ($orders as $order) : ?>
				<?php if (empty($options['category']) && $last_category != $order->category): ?>
					<tr>
						<td colspan="12"><strong><?php print $order->category; ?></strong></td>
					</tr>
					<?php $last_category = $order->category; ?>
				<?php endif; ?>
				<tr id="order_<?php print $order->id; ?>">
					<td><?php print $order->catalog_number; ?></td>
					<td><?php print $order->count_presale; ?></td>
					<td><?php print $order->flat_size; ?></td>
					<td><?php print $order->received_presale; ?></td>
					<td class="big"></td>
					<td class="big"></td>
					<td class="no-wrap"><?php print $order->name; ?></td>
					<td class="no-wrap"><?php print format_latin_name($order); ?></td>
					<td class="no-wrap"><?php print $order->variety; ?></td>
					<td class="no-wrap"><?php print $order->pot_size; ?></td>
					<td><?php print $order->grower_id; ?></td>
					<td><?php print $order->category; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

<?php endif;
