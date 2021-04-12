<?php defined('BASEPATH') or exit('No direct script access allowed');
// view.php Chris Dart Mar 4, 2013 9:14:14 PM chrisdart@cerebratorium.com
?>

<div class="block">
	<h3>Order Info for
		<?php print $order->variety; ?>, <?php print get_current_year(); ?>
	</h3>
	<p>
		<label>variety: </label><?php print $order->variety; ?>
		<?php print create_button_bar([[
			'text' => 'Details',
			'class' => [
				'button',
				'details'
			],
			'href' => site_url('variety/view/$order->variety_id')
		]]); ?>
	</p>
</div>
<input type="hidden" id="order_id" value="<?php print $order->id; ?>" name="order_id" />
<div class="grouping order-info block" id="order">
	<div class="column column-odd">
		<?php print create_edit_field('grower_id', $order->grower_id, 'Grower ID'); ?>
		<?php print create_edit_field('year', $order->year, 'Year', ['envelope' => 'div']); ?>
		<?php print create_edit_field('flat_size', $order->flat_size, 'Flat Size'); ?>
		<?php
		$plant_cost = $order->plant_cost;
		$flat_cost = $order->flat_cost;
		if ($order->flat_cost && !$order->plant_cost) {
			$plant_cost = $order->flat_size / $order->flat_cost;
			$flat_cost = $order->flat_cost;
		} elseif ($order->plant_cost && !$order->flat_cost) {
			$plant_cost = $order->plant_cost;
			$flat_cost = $order->plant_cost * $order->flat_size;
		}
		?>
		<?php print create_edit_field('flat_cost', get_as_price($flat_cost), 'Flat Cost', ['attributes' => 'format="currency"']); ?>
		<?php print create_edit_field('plant_cost', get_as_price($plant_cost), 'Plant Cost', ['attributes' => 'format="currency"']); ?>
		<?php print create_edit_field('price', get_as_price($order->price), 'Sale Price', ['attributes' => 'format="currency"']); ?>
		<?php print create_edit_field('pot_size', $order->pot_size, 'Pot Size'); ?>
	</div>
	<div class="column column-even">
		<?php print create_edit_field('count_presale', $order->count_presale, 'Presale Count'); ?>
		<?php print create_edit_field('count_midsale', $order->count_midsale, 'Midsale Count'); ?>
		<?php print create_edit_field('sellout_friday', $order->sellout_friday, 'Friday Sellout'); ?>
		<?php print create_edit_field('remainder_friday', $order->remainder_friday, 'Friday Remainder'); ?>
		<?php print create_edit_field('sellout_saturday', $order->sellout_saturday, 'Saturday Sellout'); ?>
		<?php print create_edit_field('remainder_saturday', $order->remainder_saturday, 'Saturday Remainder'); ?>
		<?php print create_edit_field('remainder_sunday', $order->remainder_sunday, 'Sunday Remainder'); ?>
		<?php print create_edit_field('count_dead', $order->count_dead, 'Dead Count'); ?>
		<?php print create_edit_field('grower_code', $order->grower_code, 'grower Code'); ?>
	</div>
</div>