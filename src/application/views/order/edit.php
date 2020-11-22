<?php defined('BASEPATH') OR exit('No direct script access allowed');
// row.php Chris Dart Mar 4, 2013 9:25:12 PM chrisdart@cerebratorium.com
$crop_failure = FALSE;
if(empty($order)) {
	return FALSE;
}
$days =['presale','midsale'];
if(get_value($order,'year') == 2021){
	$days = [
			'presale','thursday','friday','saturday',
	];
}
?>
<h4><?php echo get_value($order,"variety","New Variety");?></h4>

<form name="order-edit" id="order-edit" action="<?php echo site_url("order/$action");?>"
	method="post">
	<?php if(get_value($order,"received_presale")== "0.000"):?>
	<?php $crop_failure = TRUE;?>
<div class='message alert'>CROP FAILURE</div>
<?php endif;?>
	<input type="hidden" name="id" value="<?php echo get_value($order,"id");?>"/>
	<input type="hidden" name="variety_id" value="<?php echo $variety_id;?>" />
	<?php if($action == "update"):?>
<!-- 	<div class="field-set"> -->
	<h3>Order details</h3>
	<div class="column first">
	<?php endif;?>
	<div class="order-year field">
		<label for="year">Year:&nbsp;</label><input type="text" name="year" value="<?php echo get_value($order,"year");?>" required />
	</div>

	<div class="order-grower field">
		<label for="grower_id">Grower:&nbsp;</label><input type="text"
			name="grower_id" value="<?php echo get_value($order,"grower_id");?>" />
	</div>

	<div class="order-catalog_number field">
	<label for="catalog_number">Catalog Number</label>
	<input type="text" name="catalog_number" value="<?php echo get_value($order,"catalog_number");?>"/>
	</div>
	<div class="order-flat_size field">
		<label for="flat_size">Flat Size:&nbsp;</label> <input type="text"
			name="flat_size" value="<?php echo get_value($order,"flat_size");?>" required autocomplete="off"/>
	</div>
	<div class="order-flat_cost field">
		<label for="flat_cost">Flat Cost:&nbsp;</label> <input type="text"
			name="flat_cost" value="<?php echo get_value($order,"flat_cost");?>" required autocomplete="off" />
	</div>
	<div class="order-plant_cost field">
		<label for="plant_cost">Plant Cost:&nbsp;</label> <input type="text"
			name="plant_cost" value="<?php echo get_value($order,"plant_cost");?>" autocomplete="off" required />
	</div>
		<div class="order-price field">
			<label for="price">Price:&nbsp;</label> <input type="text" name="price"
														   value="<?php echo get_value($order,"price");?>" required autocomplete="off"/>
		</div>
	</div>
	<div class="column last">
		<div class="order-pot_size field">
			<label for="pot_size">Pot Size:&nbsp;</label>
			<?php echo form_dropdown("pot_size",$pot_sizes, urlencode(get_value($order, "pot_size")),"id='pot-size-menu'");?>
		</div>

		<div class="order-grower_code field">
			<label for="grower_code">Grower Code:&nbsp;</label> <input type="text"
																	   name="grower_code" value="<?php echo get_value($order,"grower_code");?>" />
		</div>
		<div class="order-flat_area field">
			<label for="flat_area">Flat Area (Sq Ft):&nbsp;</label> <input type="text"
																		   name="flat_area" value="<?php echo get_value($order,"flat_area",2);?>" size="10"  />
		</div>
		<div class="order-tiers field">
			<label for="tiers">Tiers:&nbsp;</label> <input type="text"
														   name="tiers" value="<?php echo get_value($order,"tiers",3);?>" size="10"  />
		</div>
	</div>
	<div class="group">
		<h3>Inventory Details</h3>
	<div class="column first">
		<?php foreach($days as $day):?>
	<div class="order-count_presale field">
		<label for="count_<?php print $day; ?>"><?php print ucfirst($day);?> Count:&nbsp;</label>
		<input type="text"
			name="count_<?php print $day; ?>" value="<?php echo get_value($order,'count_' . $day);?>" autocomplete="off" />
	</div>
		<?php endforeach; ?>


	</div>
	<div class="column last">
	<?php if($action == "update"):?>
		<?php foreach($days as $day): ?>
		<?php $field_name = 'received_' . $day; ?>
		<div class="order-<?php print $field_name;?> field">
		<label for="<?php print $field_name;?>"><?php print ucfirst($day);?> Received:&nbsp;</label> <input type="text" style="<?php echo $crop_failure?"background-color:#FFB3B3":"";?>"
			name="<?php print $field_name;?>" value="<?php echo get_value($order,$field_name);?>" autocomplete="off" />
	</div>
		<?php endforeach; ?>
<?php if(get_value($order,'year') != 2020):?>
		<div class="order-sellout_friday field">
		<label for="sellout_friday">Sellout Friday:&nbsp;</label> <input type="text"
			name="sellout_friday" value="<?php echo get_value($order,"sellout_friday");?>" size="6"/>
	</div>
			<div class="order-remainder_friday field">
		<label for="remainder_friday">Remainder Friday:&nbsp;</label> <input type="text"
			name="remainder_friday" value="<?php echo get_value($order,"remainder_friday");?>" size="3"/>
	</div>
	<div class="order-sellout_saturday field">
		<label for="sellout_saturday">Sellout Saturday:&nbsp;</label> <input type="text"
			name="sellout_saturday" value="<?php echo get_value($order,"sellout_saturday");?>"size="6" />
	</div>
		<div class="order-remainder_saturday field">
		<label for="remainder_saturday">Remainder Saturday:&nbsp;</label> <input type="text"
			name="remainder_saturday" value="<?php echo get_value($order,"remainder_saturday");?>" size="3"/>
	</div>
	<div class="order-remainder_sunday field">
		<label for="remainder_sunday">Remainder Sunday:&nbsp;</label> <input type="text"
			name="remainder_sunday" value="<?php echo get_value($order,"remainder_sunday");?>" size="3" />
	</div>
	<div class="order-count_dead field">
		<label for="count_dead">Dead Count:&nbsp;</label> <input type="text"
			name="count_dead" value="<?php echo get_value($order,"count_dead");?>" size="3"  />

	</div>
		<?php endif; ?>
	</div>
		<?php endif;?>
	</div>
	<input type="hidden" name="redirect_url" id="redirect_url"/>
	<div style="clear:both">
		<input type="submit" value="<?php echo ucfirst($action);?>" class="button <?php echo $action;?>" />
		<?php if($action == "update"): ?>
		<?php echo create_button(array("text"=>"Delete","class"=>array("button","delete","delete-order"),"id"=>"delete-order_$order->id"));?>
		<?php endif;?>
	</div>
</form>
<script type="text/javascript">
$("#redirect_url").val($(location).attr("pathname") + $(location).attr("search"));

// $("#order-edit").on("change","#crop_failure",function(){
// 	if($("#crop_failure").prop("checked")){
// 	    $("#order-edit .alert").fadeIn().html("CROP FAILURE");
// 	}else{
// 		$("#order-edit .alert").fadeOut().html("");
// 	}
// });
</script>
