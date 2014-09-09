<?php defined('BASEPATH') OR exit('No direct script access allowed');
// row.php Chris Dart Mar 4, 2013 9:25:12 PM chrisdart@cerebratorium.com
?>
<h4><?=$order->variety;?></h4>

<form name="order-edit" id="order-edit" action="<?=site_url("order/$action");?>"
	method="post">
	<input type="hidden" name="id" value="<?=get_value($order,"id");?>"/>
	<input type="hidden" name="variety_id" value="<?=$variety_id;?>" />
	<div class="order-year field">
		<label for="year">Year:&nbsp;</label><input type="text" name="year" value="<?=get_cookie("sale_year");?>" />
	</div>

	<div class="order-grower field">
		<label for="grower_id">grower:&nbsp;</label><input type="text"
			name="grower_id" value="<?=get_value($order,"grower_id");?>" />
	</div>
	<div class="order-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="<?=get_value($order,"flat_size");?>" autocomplete="off"/>
	</div>
	<div class="order-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value="<?=get_value($order,"flat_cost");?>" autocomplete="off" />
	</div>
	<div class="order-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="<?=get_value($order,"plant_cost");?>" autocomplete="off" />
	</div>
	<div class="order-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;</label> <input type="text"
			name="count_presale" value="<?=get_value($order,"count_presale");?>" autocomplete="off" />
	</div>
	<div class="order-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;</label> <input type="text"
			name="count_midsale" value="<?=get_value($order,"count_midsale");?>" autocomplete="off"/>
	</div>
	<?php if($action == "update"):?>
		<div class="order-received_presale field">
		<label for="received_presale">Presale Received:&nbsp;</label> <input type="text"
			name="received_presale" value="<?=get_value($order,"received_presale");?>" autocomplete="off" />
	</div>
	<div class="order-received_midsale field">
		<label for="received_midsale">Midsale Received:&nbsp;</label> <input type="text"
			name="received_midsale" value="<?=get_value($order,"received_midsale");?>" autocomplete="off" />
	</div>
	<?php endif;?>
	<div class="order-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;</label>
		<?=form_dropdown("pot_size",$pot_sizes, urlencode(get_value($order, "pot_size")));?>
		<!-- <input type="text"
			name="pot_size" value="<?=get_value($order,"pot_size");?>" class='autocomplete-live' category='pot_size' /> -->
	</div>
	<div class="order-price field">
		<label for="price">Price:&nbsp;</label> <input type="text" name="price"
			value="<?=number_format(get_value($order,"price"));?>" autocomplete="off"/>
	</div>
	<div class="order-grower_code field">
		<label for="grower_code">grower Code:&nbsp;</label> <input type="text"
			name="grower_code" value="<?=get_value($order,"grower_code");?>" />
	</div>
	<input type="hidden" name="redirect_url" id="redirect_url"/>

	<div>
		<input type="submit" value="<?=ucfirst($action);?>" class="button" />
		<? if($action == "update"): ?>
		<span class="button delete delete-order" id="<? printf("delete-order_%s",$order->id);?>">Delete</span>
		<? endif;?>
	</div>
</form>
<script type"text/javascript">$("#redirect_url").val($(location).attr("pathname") + $(location).attr("search"));</script>