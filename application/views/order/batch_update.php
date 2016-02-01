<?
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

?>

<form id="batch-update" name="batch-update" method="post" action="<?=base_url("order/batch_update");?>">
<input type="hidden" id="ids" name="ids" value="<?=implode(",",$ids);?>"/>
<input type="hidden" id="action" name="action" value="update"/>
<h2>DANGER: Updating <?=count($ids);?> Records</h2>
<p class="notice">Changes you submit here cannot be undone!</p>

	<div class="orders-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="" autocomplete="off"/>
	</div>
	<div class="orders-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value=""  autocomplete="off" />
	</div>
	<div class="orders-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="" autocomplete="off"  />
	</div>
	<div class="orders-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;</label> <input type="number"
			name="count_presale" value="" autocomplete="off" />
	</div>
	<div class="orders-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;</label> <input type="number"
			name="count_midsale" value="" autocomplete="off"/>
	</div>
		<div class="orders-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;</label>
		<?=form_dropdown("pot_size",$pot_sizes);?>
	</div>
	<div class="orders-price field">
		<label for="price">Price:&nbsp;</label> <input type="text" name="price"
			value="" autocomplete="off"/>
	</div>
		<div class="orders-flat_area field">
		<label for="flat_area">Flat Area:&nbsp;</label> <input type="text" name="flat_area"
			value="" autocomplete="off"/>
	</div>
			<div class="orders-tiers field">
		<label for="tiers">Tiers:&nbsp;</label> <input type="text" name="tiers"
			value="" autocomplete="off"/>
	</div>
				<div class="grower-code field">
		<label for="grower_code">Grower Code:&nbsp;</label> <input type="text" name="grower_code"
			value="" autocomplete="off"/>
	</div>
	<input type="submit" class="button" class="button warning"/>
</form>

<script type="text/javascript">
$("#batch-update").submit(function(){
	is_sure = confirm("Are you absolutely sure you want to do this? It cannot be undone!");
	if(is_sure){
	}else{
	return false;
	}
});
</script>