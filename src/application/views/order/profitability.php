<?php
defined('BASEPATH') or exit('No direct script access allowed');
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders) :
	$total_gross = 0;
	$total_net = 0;
	$total_adjusted_net = 0;
	$total_flat_area = 0;
	?>
	<!-- order/inventory -->
	<h2 class="column-instructions">
		Click on a header label to hide a column [
		<a href="#" class=" reset-columns">Reset</a>
		]
	</h2>

	<table class="list profitability hideable-columns">
		<thead>
		<tr class="top-row">
			<th colspan="4"></th>
			<th colspan="<?php print $year == 2021 ? 4 : 3; ?>">Orders</th>
			<th colspan="6"></th>
			<th colspan="3">Area (sq ft)</th>
			<th colspan="3">
				Protential<br/>Profit
			</th>
		</tr>
		<tr>
			<th></th>
			<th>Year</th>
			<th>Cat&#35;</th>
			<th>Name</th>
			<th>Pre</th>
			<?php if ($year == 2021): ?>
				<th>Fri</th>
				<th>Sat</th>
			<?php else: ?>
				<th>Mid</th>
			<?php endif; ?>
			<th>Total</th>
			<th>Rem Sat</th>
			<th>Pot Size</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Price</th>
			<th class="no-wrap">Flat</th>
			<th>Total</th>
			<th>Tiers</th>
			<th>Gross Profit</th>
			<th>Net Profit</th>
			<th>Adjusted Profit</th>
		</tr>
		</thead>
		<tbody>
		<?php
		$presale_total = 0;
		$friday_total = 0;
		$saturday_total = 0;
		$midsale_total = 0;
		$flat_cost_total = 0;
		foreach ($orders as $order) :
			$flat_cost = $order->flat_cost;
			$plant_cost = $order->plant_cost;
			if ($order->flat_cost && !$order->plant_cost) {
				$flat_cost = $order->flat_cost;
				$plant_cost = $order->flat_size / $order->flat_cost;
			}
			elseif ($order->plant_cost && !$order->flat_cost) {
				$plant_cost = $order->plant_cost;
				$flat_cost = $order->flat_size * $order->plant_cost;
			}
			$row_classes = [
					'grouping',
			];
			$latest_year = get_value($order, 'latest_year', TRUE);

			if ($order->received_presale == '0.000') {
				$row_classes[] = 'crop-failure';
			}

			$presale_total += $order->count_presale;
			$friday_total += $order->count_friday;
			$saturday_total += $order->count_saturday;
			$midsale_total += $order->count_midsale;
			$flat_cost_total += $order->flat_cost * ($order->count_presale + $order->count_midsale + $order->count_friday + $order->count_saturday);
			$row_classes[] = has_price_discrepancy($order);

			?>
			<tr class="<?php print implode(' ', $row_classes); ?>"
				id="order_<?php print $order->id; ?>">
				<td class="no-wrap">
					<?php if (IS_ADMIN) : ?>
						<span tabindex=-1 class="omit-row omit button"
							  id="omit-order_<?php print $order->id; ?>">Omit</span>
					<?php endif; ?>

					<?php if (IS_EDITOR) : ?>
						<?php print create_button([
								'text' => 'Edit',
								'href' => site_url('order/edit/' . $order->id),
								'class' => [
										'button',
										'edit',
										'dialog',
										'edit-order',
								],
								'id' => 'edit-order_' . $order->id,
								'tabindex' => "-1'",
						]); ?>

					<?php else : ?>
						<?php print create_button([
								'text' => 'Details',
								'class' => [
										'button',
										'details',
										'view-order',
								],
								'href' => site_url('order/view/' . $order->id),
						]); ?>
					<?php endif; ?>
				</td>
				<td tabindex=-1 class="order-year field">
					<?php print edit_field('year', $order->year, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td tabindex=-1 class="order-catalog_number field">
					<!-- if there is no catalog number, show the first letter of the category -->
					<?php print edit_field('catalog_number', $order->catalog_number ? $order->catalog_number : ucfirst(substr($order->category, 0, 1)), '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td>
					<a tabindex=-1
					   href="<?php print site_url(format_string('common/find?genus=@genus', ['@genus' => $order->genus])); ?>"
					   title="View all <?php print $order->genus; ?>">
						<?php print $order->genus; ?>
					</a>
					<a tabindex=-1
					   href="<?php print site_url('common/view/' . $order->common_id); ?>"
					   title="View the details for <?php print $order->name; ?>">
						<?php print $order->name; ?>
					</a>
					<a tabindex=-1 style="font-weight: bold"
					   href="<?php print site_url('variety/view/' . $order->variety_id); ?>"
					   title="View the details for <?php print $order->variety; ?>">
						<?php print $order->variety; ?>
					</a>
				</td>
				<td tabindex=-1 class="order-count_presale field">
					<?php print edit_field('count_presale', $order->count_presale, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<?php if ($order->year == 2021): ?>
					<td tabindex=-1 class="order-count_friday field">
						<?php print edit_field('count_friday', $order->count_friday, '', 'order', $order->id, ['envelope' => 'span']); ?>
					</td>
					<td tabindex=-1 class="order-count_saturday field">
						<?php print edit_field('count_saturday', $order->count_saturday, '', 'order', $order->id, ['envelope' => 'span']); ?>
					</td>
				<?php else: ?>
				<td tabindex=-1 class="order-count_midsale field">
					<?php print edit_field('count_midsale', $order->count_midsale, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<?php endif; ?>
				<td class="order-total_plants field">
					<?php

					$flat_total = $order->count_midsale + $order->count_presale + $order->count_friday + $order->count_saturday;
					print $flat_total;
					?>
				</td>
				<td class="order-remainder_saturday field" style="width: 31px;">
					<?php print live_field('remainder_saturday', $order->remainder_saturday, 'order', $order->id, [
							'envelope' => 'span',
							'size' => 31,
					]); ?>
				</td>
				<td class="order-pot_size field no-wrap">
					<?php print edit_field('pot_size', $order->pot_size, '', 'order', $order->id, [
							'envelope' => 'span',
							'class' => 'pot-size',
					]); ?>
				</td>
				<td class="order-flat_size field">
					<?php print edit_field('flat_size', $order->flat_size, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td class="order-flat_cost field cost-field no-wrap"
					id="flat_cost">
					$
					<span id="edit-flat-cost_<?php print $order->id; ?>"
						  class="edit-cost"><?php print number_format($order->flat_cost, 2); ?></span>
				</td>
				<td tabindex=-1
					class="no-wrap order-plant_cost field cost-field no-wrap"
					id="plant_cost">
					$
					<span id="edit-plant-cost_<?php print $order->id; ?>"
						  class="edit-cost"><?php print number_format($order->plant_cost, 2); ?></span>
				</td>
				<td tabindex=-1 class="no-wrap order-price field">
					$<?php print edit_field('price', $order->price, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td class="order-flat_area field">
					<?php print edit_field('flat_area', $order->flat_area, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td>
					<?php print $order->flat_area * $flat_total; ?>
					<?php $total_flat_area += $order->flat_area * $flat_total; ?>
				</td>
				<td class="order-tiers field">
					<?php print edit_field('tiers', $order->tiers, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<?php
				$plant_count = ($flat_total) * $order->flat_size;
				$gross = $order->price * $plant_count;
				$total_gross += $gross;
				$net_price = $order->price - $order->plant_cost;
				$net = $net_price * $plant_count;
				$total_net += $net;
				$less_remainder = $order->remainder_saturday * $order->flat_size * $net_price;
				$adjusted_net = $net - $less_remainder;
				$total_adjusted_net += $adjusted_net;
				?>
				<td><?php print get_as_price($gross); ?></td>
				<td><?php print get_as_price($net); ?></td>
				<td><?php print get_as_price($adjusted_net); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		<tfoot>
		<tr>
			<td colspan=4></td>
			<td><?php print number_format($presale_total); ?></td>
			<td><?php print number_format($presale_total + $midsale_total); ?></td>
			<td colspan=3></td>
			<td><?php print get_as_price($flat_cost_total); ?></td>
			<td colspan=3></td>
			<td><?php print number_format($total_flat_area); ?></td>
			<td></td>
			<td><?php print get_as_price($total_gross); ?></td>
			<td><?php print get_as_price($total_net); ?></td>
			<td><?php print get_as_price($total_adjusted_net); ?></td>

		</tr>
		</tfoot>
	</table>


<?php endif;
