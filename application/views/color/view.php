<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<input
	type="hidden" id="id" name="id" value="<?=$color->id;?>" />

<input type="hidden"
	id="order_id" name="order_id" value="<?=get_value($current_order,"id");?>" />
<h2>
	<?="$color->common_name: $color->color";?>
</h2>
<div class="grouping block color-info" id="color">
	<div class='column column-odd'>

	<?=create_edit_field("color", $color->color, "Color");?>

	<?=create_edit_field("species", $color->species, "Species");?>
	
	<?=create_edit_field("note", $color->note, "Note", array("class"=>"textarea"));?>
	<? if($color->species && $color->genus): ?>
	<p class="latin-name">
		<label>Latin Name: </label><span class="field"><em> <?=ucfirst(substr($color->genus, 0, 1));?>.
				<?=strtolower($color->species);?>
		</em> </span>
	</p>
	<? endif;?>
	</div>
<div class='common-info column column-even'>
	<p>
		<label>Common Name:</label> <span class="field"><?=$color->common_name;?>
		</span> <a href="<?=site_url("common/view/$color->common_id");?>"
			title="View details for <?=$color->common_name;?>" class="button">Details</a>
	</p>
	<p class="category">
		<label>Category: </label> <span class="field"><?=$color->category; ?>
		</span>
	</p>
	<p class="description">
		<label>Description: </label> <span class="field"><?=$color->description; ?>
		</span>
	</p>
	</div>
</div>


<div class="all-orders block">
<h3>Orders</h3>
<? $this->load->view("order/list");?>

</div>
<?
$buttons[] = array("selection"=>"order","text"=>"New Order","type"=>"span","class"=>"button new order-create", "id" => "oc_$color->id");
echo create_button_bar($buttons);