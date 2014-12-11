<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!-- views/order/edit_cost -->
<form name="order-edit" id="order-edit" action="<?=site_url("order/update_cost");?>" method="post">
<input type="hidden" name="id" id="id" value="<?=get_value($order,"id");?>"/>
<input type="hidden" name="variety_id" id="variety_id" value="<?=get_value($order,"variety_id");?>"/>

<input type="hidden" name="redirect_url" id="redirect_url" value=""/>
<span class="order-flat_size">
		<input type="text"
			name="flat_size" value="<?=get_value($order,"flat_size");?>" style="width:3ex" required autocomplete="off"/>
	</span>
	<span class="order-flat_cost">
		<input type="text"
			name="flat_cost" value="<?=get_value($order,"flat_cost");?>" style="width:7ex" required autocomplete="off" />
	</span>
	<span class="order-plant_cost">
		<input type="text"
			name="plant_cost" value="<?=get_value($order,"plant_cost");?>" style="width:7ex"  autocomplete="off" required />
	</span>
	<span>
<input value="Save" type="submit" class="button small save"/>
<a href="#" class="hide">Cancel</a>
	</span>

</form>
<script type"text/javascript">
$("#redirect_url").val($(location).attr("pathname") + $(location).attr("search"));
</script>