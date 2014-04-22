<?php defined('BASEPATH') OR exit('No direct script access allowed');
// row.php Chris Dart Mar 4, 2013 9:25:12 PM chrisdart@cerebratorium.com
?>
<form name="order-edit" action="<?=site_url("order/$action");?>"
	method="post">
	<input type="hidden" name="variety_id" value="<?=$variety_id;?>" />
	<div class="order-year field">
		<label for="year">Year:&nbsp;</label><input type="text" name="year" value="<?=get_current_year();?>" />
	</div>

	<div class="order-vendor field">
		<label for="vendor_id">Vendor:&nbsp;</label><input type="text"
			name="vendor_id" value="<?=get_value($order,"vendor_id");?>" />
	</div>
	<div class="order-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="<?=get_value($order,"flat_size");?>" />
	</div>
	<div class="order-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value="<?=get_value($order,"flat_cost");?>" />
	</div>
	<div class="order-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="<?=get_value($order,"plant_cost");?>" />
	</div>
	<div class="order-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;</label> <input type="text"
			name="count_presale" value="<?=get_value($order,"count_presale");?>" />
	</div>
	<div class="order-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;</label> <input type="text"
			name="count_midsale" value="<?=get_value($order,"count_midsale");?>" />
	</div>
	<div class="order-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;</label> <input type="text"
			name="pot_size" value="<?=get_value($order,"pot_size");?>" />
	</div>
	<div class="order-price field">
		<label for="price">Price:&nbsp;</label> <input type="text" name="price"
			value="<?=number_format(get_value($order,"price"));?>" />
	</div>
	<div class="order-vendor_code field">
		<label for="vendor_code">Vendor Code:&nbsp;</label> <input type="text"
			name="vendor_code" value="<?=get_value($order,"vendor_code");?>" />
	</div>
	<div>
		<input type="submit" value="<?=ucfirst($action);?>" class="button" />
	</div>
</form>
