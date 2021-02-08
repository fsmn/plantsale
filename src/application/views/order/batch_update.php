<?php
defined('BASEPATH') or exit ('No direct script access allowed');
if (empty($pot_sizes)) {
	$pot_sizes = [];
}
?>

<form id="batch-update" name="batch-update" method="post"
	  action="<?php echo base_url("order/batch_update"); ?>">
	<input type="hidden" id="ids" name="ids"
		   value="<?php echo implode(",", $ids); ?>"/>
	<input type="hidden" id="action" name="action" value="update"/>
	<h2>DANGER: Updating <?php echo count($ids); ?> Records</h2>
	<p class="notice">Changes you submit here cannot be undone!</p>
	<div class="orders-flat_size field">
		<label for="year">Year (Be very careful here):&nbsp;
			<?php echo form_dropdown('year',get_year_array(get_current_year(), 2),get_current_year());?>
		</label>
	</div>
	<div class="orders-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;
			<input type="number"
				   name="flat_size"
				   value=""
				   class="size"
				   autocomplete="off"/></label>
	</div>
	<div class="orders-flat_cost field">
		<label for="flat_cost">Flat Cost: $
			<input type="number"
				   name="flat_cost"
				   value=""
				   class="cost"
				   autocomplete="off"/></label>
	</div>
	<div class="orders-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;$
			<input type="number"
				   name="plant_cost"
				   value=""
				   class="cost"
				   autocomplete="off"/></label>
	</div>
	<div class="orders-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;
			<input
					type="number"
					class="count"
					name="count_presale" value="" autocomplete="off"/></label>
	</div>
	<div class="orders-count_friday field">
		<label for="count_friday">Friday Count (2021 only):&nbsp;
			<input
					type="number"
					class="count"
					name="count_friday" value="" autocomplete="off"/></label>
	</div>
	<div class="orders-count_saturday field">
		<label for="count_saturday">Saturday Count (2021 only):&nbsp;
			<input
					type="number"
					class="count"
					name="count_saturday" value="" autocomplete="off"/></label>
	</div>
	<div class="orders-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;
			<input
					type="number"
					class="count"
					name="count_midsale" value="" autocomplete="off"/></label>
	</div>
	<div class="orders-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;
			<?php echo form_dropdown('pot_size', $pot_sizes); ?></label>
	</div>
	<div class="orders-price field">
		<label for="price">Price:&nbsp;$
			<input type="number" name="price"
				   value=""
				   class="cost"
				   autocomplete="off"/></label>
	</div>
	<div class="orders-flat_area field">
		<label for="flat_area">Flat Area:&nbsp;
			<input type="text"
				   name="flat_area"
				   value=""
				   autocomplete="off"/></label>
	</div>
	<div class="orders-tiers field">
		<label for="tiers">Tiers:&nbsp;
			<input type="text" name="tiers"
				   value=""
				   autocomplete="off"/></label>
	</div>
	<div class="grower-code field">
		<label for="grower_code">Grower Code:&nbsp;
			<input type="text"
				   name="grower_code"
				   value=""
				   autocomplete="off"/></label>
	</div>
	<div class="flat-exclude field">
		<label for="flat_exclude">Exclude from flat totals:
			<?php print form_dropdown('flat_exclude', [
					0 => '',
					'no' => 'No',
					'yes' => 'Yes',
			]); ?></label>
	</div>
	<input type="submit" class="button delete"/>
</form>

<script type="text/javascript">
	jQuery("#batch-update").submit(function () {
		let is_sure = confirm("Are you absolutely sure you want to do this? It cannot be undone!");
		if (!is_sure) {
			return false;
		}
	});
</script>
