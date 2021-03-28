<?php
defined('BASEPATH') or exit ('No direct script access allowed');
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if (!empty($orders)) :

	?>
	<!-- order/inventory 2021 -->
	<h2 class="column-instructions">
		Click on a header label to hide a column [
		<a href="#" class=" reset-columns">Reset</a>
		]
	</h2>

	<table class="list inventory hideable-columns">
		<thead>
		<tr class="top-row">
			<th></th>
			<th></th>
			<?php if (!$show_names): ?>
				<th></th>
			<?php endif; ?>
			<th colspan=2></th>
			<?php if ($show_names): ?>
				<th colspan=3></th>

			<?php endif; ?>
			<th colspan=2>Presale</th>
			<th colspan=2>Friday</th>
			<th colspan=3>Saturday</th>
			<th>Sunday</th>
			<th colspan=8></th>

		</tr>
		<tr>
			<th></th>
			<?php if (!$show_names): ?>
				<th>Year</th>
			<?php endif; ?>
			<th>Grower</th>
			<th>Cat&#35;</th>
			<?php if ($show_names): ?>
				<th>Genus</th>
				<th>Species</th>
				<th>Common</th>
				<th>Variety</th>
			<?php endif; ?>
			<!-- Presale -->
			<th>Ord'd</th>
			<th>Rec'd</th>
			<!-- Friday -->
			<th>Ord'd</th>
			<th>Rec'd</th>
			<!-- Saturday -->
			<th>Ord'd</th>
			<th>Rec'd</th>
			<th>Rem</th>
			<!-- Sunday -->
			<th>Rem</th>
			<th>Dead Count</th>
			<th>Total</th>
			<th>Pot Size</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Price</th>
			<th>Grower Code</th>
			<!-- <th></th>-->
		</tr>
		</thead>
		<tbody>
		<?php
		$presale_total = 0;
		$thursday_total = 0;
		$friday_total = 0;
		$saturday_total = 0;
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
					"grouping",
			];
			$latest_year = get_value($order, "latest_year", TRUE);

			$row_title = "";

			if ($order->received_presale == "0.000") {
				$row_classes [] = "crop-failure";
				$row_title = "This plant has a crop failure";
			}
			if (!empty ($order->sellout_saturday)) {
				$row_classes [] = "complete-sellout";
				$row_title = "Complete sellout";
			}
			elseif (!empty ($order->sellout_friday) && empty ($order->count_midsale)) {
				$row_classes [] = "complete-sellout";
				$row_title = "Complete sellout";
			}
			elseif (!empty ($order->sellout_friday) && !empty ($order->count_midsale)) {
				$row_classes [] = "temporary-sellout";
				$row_title = "Temporary sellout";
			}

			$presale_total += $order->count_presale;
			$friday_total += $order->count_friday;
			$saturday_total += $order->count_saturday;
			$flat_cost_total += $order->flat_cost * ($order->count_presale + $order->count_friday + $order->count_saturday);
			$row_classes [] = has_price_discrepancy($order);

			?>
			<tr class="<?php echo implode(" ", $row_classes); ?>"
				id="order_<?php echo $order->id; ?>"
				title="<?php echo $row_title; ?>">


				<td class="no-wrap">
					<?php if (IS_ADMIN): ?>
						<span tabindex=-1 class="omit-row omit button"
							  id="omit-order_<?php echo $order->id; ?>">Omit</span>

					<?php endif; ?>
					<?php if (IS_EDITOR): ?>
						<?php echo create_button([
								"text" => "Edit",
								"href" => site_url("order/edit/$order->id"),
								"class" => [
										"button",
										"edit",
										"dialog",
										"edit-order",
								],
								"id" => "edit-order_$order->id",
								"tabindex" => "-1'",
						]); ?>

					<?php else: ?>
						<?php echo create_button([
								"text" => "Details",
								"class" => ["button", "details", "view-order"],
								"href" => site_url("order/view/$order->id"),
						]); ?>

					<?php endif; ?>
				</td>
				<?php if (!$show_names): ?>
					<td tabindex=-1
						class="order-year field"><?php echo edit_field("year", $order->year, "", "order", $order->id, ["envelope" => "span"]); ?>
					</td>
				<?php endif; ?>
				<td tabindex=-1
					class="order-grower_id field"><?php echo edit_field("grower_id", $order->grower_id, "", "order", $order->id, ["envelope" => "span"]); ?>
				</td>
				<td tabindex=-1 class="order-catalog_number field">
					<!-- if there is no catalog number, show the first letter of the category -->
					<?php echo edit_field("catalog_number", $order->catalog_number ? $order->catalog_number : ucfirst(substr($order->category, 0, 1)), "", "order", $order->id, ["envelope" => "span"]); ?>
				</td>
				<?php if ($show_names): ?>
					<td>
						<a tabindex=-1
						   href="<?php echo site_url(sprintf("common/find?genus=%s", $order->genus)); ?>"
						   title="View all <?php echo $order->genus; ?>"><?php echo $order->genus; ?></a>
					</td>
					<td tabindex=-1><?php echo $order->species; ?></td>
					<td>
						<a tabindex=-1
						   href="<?php echo site_url("common/view/$order->common_id"); ?>"
						   title="View the details for <?php echo $order->name; ?>"><?php echo $order->name; ?></a>
					</td>
					<td>
						<a tabindex=-1 style="font-weight: bold"
						   href="<?php echo site_url("variety/view/$order->variety_id"); ?>"
						   title="View the details for <?php echo $order->variety; ?>"
						><?php echo $order->variety; ?></a>
					</td>
				<?php endif; ?>
				<td tabindex=-1 class="order-count_presale field">
					<?php print edit_field("count_presale", $order->count_presale, "", "order", $order->id, ["envelope" => "span"]); ?>
				</td>
				<td class="order-received_presale field">
					<?php print live_field('received_presale', $order->received_presale, 'order', $order->id, [
							'type' => 'text',
							'envelope' => 'span',
					]); ?>
				</td>
				<td tabindex=-1 class="order-count_friday field">
					<?php echo edit_field('count_friday', $order->count_friday, '', 'order', $order->id, [
							'type' => 'text',
							'envelope' => 'span',
					]); ?>
				</td>
				<td class="order-received_friday field">
					<?php echo live_field('received_friday', $order->received_friday, 'order', $order->id, [
							'type' => 'text',
							'envelope' => 'span',
					]); ?>
				</td>
				<td tabindex=-1 class="order-count_saturday field">
					<?php echo edit_field('count_saturday', $order->count_saturday, '', 'order', $order->id, [
							'type' => 'text',
							'envelope' => 'span',
					]); ?>
				</td>
				<td class="order-received_saturday field">
					<?php echo live_field('received_saturday', $order->received_saturday, 'order', $order->id, [
							'type' => 'text',
							'envelope' => 'span',
					]); ?>
				</td>
				<td class="order-remainder_saturday field" style="width: 31px;">
					<?php echo live_field('remainder_saturday', $order->remainder_saturday, 'order', $order->id, [
							'envelope' => 'span',
							'size' => 31,
							'type' => 'text',
					]); ?>
				</td>
				<td class="order-remainder_sunday field" style="width: 31px;">
					<?php echo live_field('remainder_sunday', $order->remainder_sunday, 'order', $order->id, [
							'envelope' => 'span',
							'size' => 31,
							'type' => 'text',
					]); ?>
				</td>
				<td class="order-count_dead field" style="width: 31px;">
					<?php echo live_field('count_dead', $order->count_dead, 'order', $order->id, [
							'envelope' => 'span',
							'size' => 31,
							'type' => 'text',
					]); ?>
				</td>
				<td class="order-total_plants field">
					<?php echo $order->count_midsale + $order->count_presale; ?>
				</td>
				<td class="order-pot_size field no-wrap"><?php echo edit_field('pot_size', $order->pot_size, '', 'order', $order->id, [
							'envelope' => 'span',
							'class' => 'pot-size',
					]); ?>
				</td>
				<td class="order-flat_size field">
					<?php echo edit_field('flat_size', $order->flat_size, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td class="order-flat_cost field cost-field no-wrap"
					id="flat_cost">
					$
					<span id="edit-flat-cost_<?php echo $order->id; ?>"
						  class="edit-cost"><?php echo number_format($order->flat_cost, 2); ?></span>
				</td>
				<td tabindex=-1
					class="no-wrap order-plant_cost field cost-field no-wrap"
					id="plant_cost">
					$
					<span id="edit-plant-cost_<?php echo $order->id; ?>"
						  class="edit-cost"><?php echo number_format($order->plant_cost, 2); ?></span>
				</td>
				<td tabindex=-1 class="no-wrap order-price field">
					$<?php echo edit_field('price', $order->price, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
				<td tabindex=-1
					class="order-grower_code field"><?php echo edit_field('grower_code', $order->grower_code, '', 'order', $order->id, ['envelope' => 'span']); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
		<tfoot>
		<tr>
			<td colspan=<?php echo $show_names ? 7 : 4; ?>></td>
			<td><?php echo number_format($presale_total); ?></td>
			<td></td>
			<td><?php echo number_format($friday_total); ?></td>
			<td></td>
			<td><?php echo number_format($saturday_total); ?></td>
			<td colspan=4></td>
			<td><?php echo number_format($presale_total + $friday_total + $saturday_total); ?></td>
			<td></td>
			<td></td>
			<td><?php echo get_as_price($flat_cost_total); ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</tfoot>
	</table>


<?php endif;
