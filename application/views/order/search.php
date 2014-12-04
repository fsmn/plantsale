<?php defined('BASEPATH') OR exit('No direct script access allowed');
$refine = $this->input->get("refine");
?>
<form name="order-search" id="order-search" method="get" action="<?php echo base_url("order/search");?>">
<div class="field-set label-break">
<div class="column first">
<label for="category">Category</label><input type="text" class="autocomplete-live" category="common_category" name="category" id="category" value="<?=$refine?get_cookie("category"):"";?>"/>
</div>
<div class="column last">
<label for="subcategory">Subcategory</label><input type="text" class="autocomplete-live" category="common_subcategory" name="subcategory" id="subcategory" value="<?=$refine?get_cookie("subcategory"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="name">Common Name</label><input type="text" name="name" id="name" value="<?=$refine?get_cookie("name"):"";?>"/>
</div>
<div class="column last">
<label for="genus">Genus</label><input type="text" name="genus" id="genus" value="<?=$refine?get_cookie("genus"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="variety">Variety</label><input type="text" name="variety" id="variety" value="<?=$refine?get_cookie("variety"):"";?>"/>
</div>
<div class="column last label-break">
<label for="species">Species</label><input type="text" name="species" id="species" value="<?=$refine?get_cookie("species"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="pot_size">Pot Size</label><input type="text" name="pot_size" id="pot_size" value="<?=get_cookie("pot_size");?>" class='pot-size-menu'/>
</div>
<div class="column last">
<label for="flat_size">Flat Size</label><input type="number" name="flat_size" style="width:3em;" value="<?=$refine?get_cookie("flat_size"):"";?>"/>
</div>
</div>
<div class="field-set label-break">
<div class="column first">
<label for="year">Year</label><input type="number" name="year" style="width:4em" value="<?php echo get_cookie("sale_year");?>"/>
</div>
<div class="column last">
<label for="new_year">First Year at Sale</label><input type="number" name="new_year" title "(enter current year for all new items)" style="width:4em" value="<?=$refine?get_cookie("new_year"):"";?>"/>
</div>
</div>
<div class="field-set">
<p><label for="grower_id">grower ID</label>&nbsp;<input type="text" name="grower_id" style="width:3em;" value="<?=$refine?get_cookie("grower_id"):"";?>"/></p>
<p><input type="checkbox" name="crop_failure" value="1" <?=$refine && get_cookie("crop_failure")?"checked":"";?>/>&nbsp;<label for="crop_failure">Show Only Crop Failures</label></p>
<p>
<input type="checkbox" name="is_inventory" id="is_inventory" value=1 <?=$refine && get_cookie("is_inventory")?"checked":"";?> />
<label for="show_fields">Show Inventory Fields</label>
</p>
<p>
<input type="checkbox" value="1" name="show_last_only" <?=$refine && get_cookie("show_last_only")?"checked":"";?>/>
<label for="show_last_only">Hide plants that already have an order for the next plant sale</label>
</p>
</div>
<div id="sort-block">
<? $this->load->view("order/sort");?>
</div>
<p><input type="submit" value="Search"/></p>
</form>