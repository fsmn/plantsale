<?
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

?>

<form id="batch-update" name="batch-update" method="post" action="<?=base_url("order/batch_update");?>">
<input type="hidden" id="ids" name="ids" value="<?=implode(",",$ids);?>"/>
<input type="hidden" id="action" name="action" value="update"/>
<h2>DANGER: Updating <?=count($ids);?> Records</h2>
<p class="notice">Changes you submit here cannot be undone!</p>

	<div class="order-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="" autocomplete="off"/>
	</div>
	<div class="order-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value=""  autocomplete="off" />
	</div>
	<div class="order-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="" autocomplete="off"  />
	</div>
	<div class="order-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;</label> <input type="text"
			name="count_presale" value="" autocomplete="off" />
	</div>
	<div class="order-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;</label> <input type="text"
			name="count_midsale" value="" autocomplete="off"/>
	</div>
		<div class="order-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;</label>
		<?=form_dropdown("pot_size",$pot_sizes);?>
	</div>
	<div class="order-price field">
		<label for="price">Price:&nbsp;</label> <input type="text" name="price"
			value="" autocomplete="off"/>
	</div>
	<input type="submit" class="button" class="button delete"/>
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