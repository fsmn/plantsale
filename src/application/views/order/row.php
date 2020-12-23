<?php defined('BASEPATH') or exit ('No direct script access allowed');
if (empty($order)) {
	return FALSE;
}
$flat_cost = $order->flat_cost;
$plant_cost = $order->plant_cost;
$is_covid_year = get_value($order, 'year') == 2021;
if ($order->flat_cost && !$order->plant_cost) {
	$flat_cost = $order->flat_cost;
	$plant_cost = $order->flat_size / $order->flat_cost;
}
elseif ($order->plant_cost && !$order->flat_cost) {
	$plant_cost = $order->plant_cost;
	$flat_cost = $order->flat_size * $order->plant_cost;
}

$row_classes = [];
$row_classes[] = has_price_discrepancy($order);

if ($order->received_presale == "0.000") {

	$row_classes[] = "crop-failure";
}
$row_classes = implode(" ", $row_classes);
?>
<!-- order/row.php -->
<tr
		id="order_<?php echo $order->id; ?>"
		class="<?php echo $row_classes; ?>">
	<td>
		<?php if (IS_EDITOR): ?>
			<?php echo create_button([
					"text" => "Edit",
					"href" => site_url("order/edit/$order->id"),
					"class" => ["button", "edit", "dialog", "edit-order"],
					"id" => sprintf("edit-order_%s", $order->id),
			]); ?>

		<?php else: ?>
			<?php echo create_button([
					"text" => "Details",
					"class" => ["button", "details"],
					"href" => site_url("order/view/$order->id"),
			]); ?>
		<?php endif; ?>
		<?php if ($order->received_presale == "0.000"): ?>
			&nbsp;CROP FAILURE&nbsp;
		<?php endif; ?>
	</td>
	<td class="order-year field"><?php echo edit_field("year", $order->year, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<td class="order-grower_id field"><?php echo edit_field("grower_id", $order->grower_id, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<td class="order-catalog_number field"><?php echo edit_field("catalog_number", $order->catalog_number, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<td class="order-pot_size field no-wrap"><?php echo edit_field("pot_size", $order->pot_size, "", "order", $order->id, [
				"envelope" => "span",
				"class" => "pot-size",
		]); ?>
	</td>
	<td
			class="order-flat_size field cost-field"
			id="flat_size"><span
				id="edit-flat-size_<?php echo $order->id; ?>"
				class="edit-cost"><?php echo $order->flat_size; ?></span></td>
	<td
			class="order-flat_cost field cost-field no-wrap"
			id="flat_cost">$<span
				id="edit-flat-cost_<?php echo $order->id; ?>"
				class="edit-cost"><?php echo number_format($order->flat_cost, 2); ?></span>
	</td>
	<td class="order-flat_area field"><?php echo edit_field("flat_area", $order->flat_area, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<td
			class="order-plant_cost field cost-field no-wrap"
			id="plant_cost">$<span
				id="edit-plant-cost_<?php echo $order->id; ?>"
				class="edit-cost"><?php echo number_format($order->plant_cost, 2); ?></span>
	</td>

	<td class="order-price field">
		$<?php echo edit_field("price", $order->price, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<td class="order-count_presale field" title="Enter 'x' to clear value">
		<?php echo edit_field('count_presale', $order->count_presale, "", "order", $order->id, ["envelope" => "span"]); ?>

	</td>
	<td class="order-received_presale field" title="Enter 'x' to clear value">
		<?php echo edit_field('received_presale', $order->received_presale, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<?php $field_list = [
			'friday' => $is_covid_year,
			'saturday' => $is_covid_year,
			'midsale' => !$is_covid_year,
	]; ?>
	<?php foreach ($field_list as $field => $value): ?>
		<?php $field_name = 'count_' . $field; ?>
		<td class="order-<?php print $field_name; ?> field"
			title="<?php print $value?'Enter \'x\' to clear value':'This is not editable for this year';?>">
			<?php if ($value): ?>
				<?php echo edit_field($field_name, get_value($order, $field_name), NULL, 'order', $order->id, ['envelope' => 'span']); ?>
			<?php endif; ?>
		</td>
		<?php $field_name = 'received_' . $field; ?>
		<td class="order-<?php print $field_name; ?> field"
			title="<?php print $value?'Enter \'x\' to clear value':'This is not editable for this year';?>">
			<?php if ($value): ?>
				<?php echo edit_field($field_name, get_value($order, $field_name), NULL, 'order', $order->id, ['envelope' => 'span']); ?>
			<?php endif; ?>
		</td>
	<?php endforeach; ?>

	<td class="order-sellout_friday field" title="<?php print !$is_covid_year?'Friday sellouts':'This field is not editable this year';?>">
		<?php if (!$is_covid_year): ?>
			<?php echo edit_field("sellout_friday", get_as_time($order->sellout_friday), "", "order", $order->id, [
					"envelope" => "span",
					"type" => "time",
			]); ?>
		<?php endif; ?>
	</td>
	<td class="order-sellout_saturday field" title="<?php print !$is_covid_year?'Saturday sellouts':'This field is not editable this year';?>">
		<?php if (!$is_covid_year): ?>
			<?php echo edit_field("sellout_saturday", get_as_time($order->sellout_saturday), "", "order", $order->id, [
					"envelope" => "span",
					"type" => "time",
			]); ?>
		<?php endif; ?>
	</td>
	<td class="order-remainder_friday field" title="<?php print !$is_covid_year?'Friday remainder':'This field is not editable this year';?>">
		<?php if (!$is_covid_year): ?>
			<?php echo edit_field("remainder_friday", $order->remainder_friday, "", "order", $order->id, ["envelope" => "span"]); ?>
		<?php endif; ?>
	</td>
	<td class="order-remainder_saturday field">
		<?php echo edit_field("remainder_saturday", $order->remainder_saturday, "", "order", $order->id, ["envelope" => "span"]); ?>

	</td>
	<td class="order-remainder_sunday field">
		<?php echo edit_field("remainder_sunday", $order->remainder_sunday, "", "order", $order->id, ["envelope" => "span"]); ?>
	</td>
	<td class="order-count_dead field">
		<?php echo edit_field("count_dead", $order->count_dead, "", "order", $order->id, ["envelope" => "span"]); ?>

	</td>
	<td>
		<?php if (IS_EDITOR): ?>
			<?php echo create_button([
					"text" => "Move",
					"href" => base_url("order/move/$order->id?ajax=1&start=1"),
					"class" => ["button", "edit", "dialog"],
					"title" => "Move this order to a new variety",
			]); ?>

		<?php endif; ?>
	</td>
</tr>
