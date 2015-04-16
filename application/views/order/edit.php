<?php defined('BASEPATH') OR exit('No direct script access allowed');
// row.php Chris Dart Mar 4, 2013 9:25:12 PM chrisdart@cerebratorium.com
?>
<h4><?=get_value($order,"variety","New Variety");?></h4>

<form name="order-edit" id="order-edit" action="<?=site_url("order/$action");?>"
	method="post">
	<?php if(get_value($order,"crop_failure",0)== 1):?>
<div class='alert'>CROP FAILURE</div>
<?php endif;?>
	<input type="hidden" name="id" value="<?=get_value($order,"id");?>"/>
	<input type="hidden" name="variety_id" value="<?=$variety_id;?>" />
	<? if($action == "update"):?>
	<div class="field-set">
	<div class="column first">
	<? endif;?>
	<div class="order-year field">
		<label for="year">Year:&nbsp;</label><input type="text" name="year" value="<?=get_value($order,"year",get_cookie("sale_year"));?>" required />
	</div>

	<div class="order-grower field">
		<label for="grower_id">Grower:&nbsp;</label><input type="text"
			name="grower_id" value="<?=get_value($order,"grower_id");?>" />
	</div>
	<div class="order-catalog_number field">
	<label for="catalog_number">Catalog Number</label>
	<input type="text" name="catalog_number" value="<?=get_value($order,"catalog_number");?>"/>
	</div>
	<div class="order-crop_failure field">
	<label for="crop_failure">Crop Failure:</label>
	<input type="checkbox" name="crop_failure" id="crop_failure" value=1 <?php if(get_value($order,"crop_failure",0) == 1){ echo "checked";}?>/>
	</div>
	<div class="order-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="<?=get_value($order,"flat_size");?>" required autocomplete="off"/>
	</div>
	<div class="order-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value="<?=get_value($order,"flat_cost");?>" required autocomplete="off" />
	</div>
	<div class="order-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="<?=get_value($order,"plant_cost");?>" autocomplete="off" required />
	</div>
	<div class="order-count_presale field">
		<label for="count_presale">Presale Count:&nbsp;</label> <input type="text"
			name="count_presale" value="<?=get_value($order,"count_presale");?>" autocomplete="off" />
	</div>
	<div class="order-count_midsale field">
		<label for="count_midsale">Midsale Count:&nbsp;</label> <input type="text"
			name="count_midsale" value="<?=get_value($order,"count_midsale");?>" autocomplete="off"/>
	</div>
		<div class="order-pot_size field">
		<label for="pot_size">Pot Size:&nbsp;</label>
		<?=form_dropdown("pot_size",$pot_sizes, urlencode(get_value($order, "pot_size")),"id='pot-size-menu'");?>
	</div>
	<div class="order-price field">
		<label for="price">Price:&nbsp;</label> <input type="text" name="price"
			value="<?=get_value($order,"price");?>" required autocomplete="off"/>
	</div>
	<div class="order-grower_code field">
		<label for="grower_code">Grower Code:&nbsp;</label> <input type="text"
			name="grower_code" value="<?=get_value($order,"grower_code");?>" />
	</div>
	</div>
	<div class="column last">
	<?php if($action == "update"):?>
		<div class="order-received_presale field">
		<label for="received_presale">Presale Received:&nbsp;</label> <input type="text"
			name="received_presale" value="<?=get_value($order,"received_presale");?>" autocomplete="off" />
	</div>
	<div class="order-received_midsale field">
		<label for="received_midsale">Midsale Received:&nbsp;</label> <input type="text"
			name="received_midsale" value="<?=get_value($order,"received_midsale");?>" autocomplete="off" />
	</div>
		<div class="order-sellout_friday field">
		<label for="sellout_friday">Sellout Friday:&nbsp;</label> <input type="text"
			name="sellout_friday" value="<?=get_value($order,"sellout_friday");?>" size="6"/>
	</div>
	<div class="order-sellout_saturday field">
		<label for="sellout_saturday">Sellout Saturday:&nbsp;</label> <input type="text"
			name="sellout_saturday" value="<?=get_value($order,"sellout_saturday");?>"size="6" />
	</div>
		<div class="order-remainder_saturday field">
		<label for="remainder_saturday">Remainder Saturday:&nbsp;</label> <input type="text"
			name="remainder_saturday" value="<?=get_value($order,"remainder_saturday");?>" size="3"/>
	</div>
		<div class="order-remainder_saturday field">
		<label for="remainder_saturday">Remainder Saturday:&nbsp;</label> <input type="text"
			name="remainder_saturday" value="<?=get_value($order,"remainder_saturday");?>"  size="3" />
	</div>
	<div class="order-remainder_sunday field">
		<label for="remainder_sunday">Remainder Sunday:&nbsp;</label> <input type="text"
			name="remainder_sunday" value="<?=get_value($order,"remainder_sunday");?>" size="3" />
	</div>
	<div class="order-count_dead field">
		<label for="count_dead">Dead Count:&nbsp;</label> <input type="text"
			name="count_dead" value="<?=get_value($order,"count_dead");?>" size="3"  />
	</div>
	</div>
	</div>
		<?php endif;?>

	<input type="hidden" name="redirect_url" id="redirect_url"/>
	<div style="clear:both">
		<input type="submit" value="<?=ucfirst($action);?>" class="button <?php echo $action;?>" />
		<? if($action == "update"): ?>
		<?php echo create_button(array("text"=>"Delete","class"=>array("button","delete","delete-order"),"id"=>"delete-order_$order->id"));?>
		<? endif;?>
	</div>
</form>
<script type"text/javascript">
$("#redirect_url").val($(location).attr("pathname") + $(location).attr("search"));

$("#order-edit").on("change","#crop_failure",function(){
	if($("#crop_failure").prop("checked")){
	    $("#order-edit .alert").fadeIn().html("CROP FAILURE");
	}else{
		$("#order-edit .alert").fadeOut().html("");
	}
});
</script>