<?php defined('BASEPATH') OR exit('No direct script access allowed');
$refine = $this->input->get("refine");
$sale_year = $this->session->userdata("sale_year");;
if(cookie("output_format")=="crop-failure" && $refine){
	$sale_year = "";
}
?>
<script type="text/javascript">
$("#year").change(function(){
$("#non-reorder-year").html(Number($("#year").val()) + 1);

});
</script>
<form name="order-search" id="order-search" method="get" action="<?php echo base_url("order/search");?>">
<input type="hidden" value="1" name="find"/>
<div class="field-set">
<label for="output_format">Output Format</label>
<?php echo form_dropdown("output_format",$output_formats,($refine ? cookie("output_format"): "catalog"),'id="output_format"');?>

</div>
<div class="field-set label-break">
<div class="column first">
		<label for="category_id">Category: </label><?=form_dropdown("category_id",$categories,($refine ? cookie("category_id"):""),'id="category_id"');?>
</div>
<div class="column last">
	<label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope"><?=form_dropdown("subcategory_id",$subcategories,($refine ? cookie("subcategory_id"):""),'id="subcategory_id"');?></span>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="name">Common Name</label><input type="text" name="name" id="name" value="<?=$refine?cookie("name"):"";?>"/>
</div>
<div class="column last">
<label for="genus">Genus</label><input type="text" name="genus" id="genus" value="<?=$refine?cookie("genus"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="variety">Variety</label><input type="text" name="variety" id="variety" value="<?=$refine?cookie("variety"):"";?>"/>
</div>
<div class="column last label-break">
<label for="species">Species</label><input type="text" name="species" id="species" value="<?=$refine?cookie("species"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="pot_size">Pot Size</label><input type="text" name="pot_size" id="pot_size" value="<?=cookie("pot_size");?>" class='pot-size-menu'/>

</div>
<div class="column last">
<label for="needs_bag">Needs Bag</label><input type="checkbox" name="needs_bag" id="needs_bag" value="1" <?=$refine?cookie("neds_bag")==1?"checked":"":"";?>/>

</div>
</div>
<div class="field-set label-break">
<div class="column triptych first">
<label for="flat_size">Flat Size</label><input type="number" name="flat_size" style="width:3em;" value="<?=$refine?cookie("flat_size"):"";?>"/>
</div>
<div class="column triptych">
<label for="flat_area">Flat Area</label><input type="number" name="flat_area" style="width:3em;" value="<?=$refine?cookie("flat_area"):"";?>"/>

</div>
<div class="column triptych last">
<label for="tiers">Tiers:</label><input type="number" name="tiers" style="width: 3em;" value="<?=$refine?cookie("tiers"):"";?>"/>

</div>
</div>
<div class="field-set" style="clear:both;">
Use numeric operators like &gt;, &lt;, =, != <a href="#" class="help" id="order_operators">Help</a>
</div>
<div class="field-set label-break">
<div class="column triptych first">
<label for="flat_cost">Flat Cost&nbsp;</label>$<input type="text" name="flat_cost" id="flat_cost" style="width:4em;" value="<?=cookie("flat_cost");?>"/>
</div>
<div class="column triptych">
<label for="plant_cost">Plant Cost&nbsp;</label>$<input type="text" name="plant_cost" id="plant_cost" style="width:4em;"value="<?=cookie("plant_cost");?>"/>
</div>
<div class="column triptych last">
<label for="price">Sale Price&nbsp;</label>$<input type="text" name="price" style="width:4em;" value="<?=$refine?cookie("price"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="year">Year</label><input type="number" id="year" name="year" style="width:4em" value="<?php echo $sale_year;?>"/>
</div>
<div class="column last">
<label for="new_year">First Year at Sale</label><input type="number" name="new_year" title="(enter current year for all new items)" style="width:4em" value="<?=$refine?cookie("new_year"):"";?>"/>
</div>
</div>
<div class="field-set label-break" >
<div class="column first"><label for="grower_id">Grower ID</label>&nbsp;<input type="text" name="grower_id" style="width:3em;" value="<?=$refine?cookie("grower_id"):"";?>"/></div>
<div class="column last"><label for="grower_code">Grower Code</label>&nbsp;<input type="text" name="grower_code" style="width:4em;" value="<?=$refine?cookie("grower_code"):"";?>">
</div>

</div>
<div class="field-set" style="clear:both;">
<label for="flag">Flag</label>
<?=form_dropdown("flag",$flags);?>
</div>
<div class="field-set" style="clear:both">
<div class="field-set"><input type="checkbox" name="received_presale" value="0.000" <?=$refine && cookie("received_presale")?"checked":"";?>/>&nbsp;<label for="received_presale">Show Only Crop Failures</label></div>

<!-- <div class="field-set">
<input type="checkbox" value="1" name="show_last_only" <?=$refine && cookie("show_last_only")?"checked":"";?>/>
<label for="show_last_only">Hide plants that already have an order for the next plant sale</label>
 </div> -->
<div class="field-set">
<input type="checkbox" value="1" name="show-non-reorders" <?=$refine && cookie("show-non-reorders")?"checked":"";?>/>
<label for="show-non-reorders">Show only plants that were not reordered for <span id='non-reorder-year'><?=$this->session->userdata("sale_year");+1;?></span></label>
</div>
</div>
<div id="sort-block">
<? $data["basic_sort"] = $refine?FALSE:TRUE; ?>
<? $this->load->view("order/sort",$data);?>
</div>
<p><input type="submit" class="button" value="Search"/></p>
</form>
