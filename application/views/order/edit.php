<?php defined('BASEPATH') OR exit('No direct script access allowed');

// row.php Chris Dart Mar 4, 2013 9:25:12 PM chrisdart@cerebratorium.com
?>
<form name="order-edit" action="<?=site_url("order/$action");?>"
	method="post">
	<input type="hidden" name="color_id" value="<?=$color_id;?>" />
	<div class="order-year field">
		<label for="year">Year:&nbsp;</label><input type="text" name="year" value="" />
	</div>

	<div class="order-vendor field">
		<label for="vendor_id">Vendor:&nbsp;</label><input type="text"
			name="vendor_id" value="" />
	</div>
	<div class="order-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="" />
	</div>
	<div class="order-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value="" />
	</div>
	<div class="order-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="" />
	</div>
	<div class="order-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;</label> <input type="text"
			name="count_presale" value="" />
	</div>
	<div class="order-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;</label> <input type="text"
			name="count_midsale" value="" />
	</div>
	<div class="order-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;</label> <input type="text"
			name="pot_size" value="" />
	</div>
	<div class="order-price field">
		<label for="price">Price:&nbsp;</label> <input type="text" name="price"
			value="" />
	</div>
	<div class="order-vendor_code field">
		<label for="vendor_code">Vendor Code:&nbsp;</label> <input type="text"
			name="vendor_code" value="" />
	</div>
	<div>
		<input type="submit" value="<?=ucfirst($action);?>" class="button" />
	</div>
</form>
