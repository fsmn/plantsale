<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form name="order-search" id="order-search" method="get" action="<?php echo base_url("order/search");?>">
<p><label for="category">Category: </label><input type="text" class="autocomplete-live" category="common_category" name="category" id="category" value=""/></p>
<p><label for="subcategory">Subcategory: </label><input type="text" class="autocomplete-live" category="common_subcategory" name="subcategory" id="subcategory" value=""/></p>

<p><label for="genus">Genus</label>&nbsp;<input type="text" name="genus" id="genus" value=""/></p>
<!-- <p><label for="pot_size">Pot Size</label>&nbsp;<?php echo form_dropdown("pot_size",$pot_sizes, urldecode(get_cookie("pot_size")));?></p> -->
<p><label for="pot_size">Pot Size</label>&nbsp;<input type="text" name="pot_size" id="pot_size" value="<?=get_cookie("pot_size");?>" class='pot-size-menu'/></p>

<p><label for="grower_id">grower ID</label>&nbsp;<input type="text" name="grower_id" style="width:3em;" value="<?php echo get_cookie("grower_id"); ?>"/></p>
<p><label for="flat_size">Flat Size</label>&nbsp;<input type="number" name="flat_size" style="width:3em;" value="<?php echo get_cookie("flat_size"); ?>"/></p>
<p><label for="year">Year</label>&nbsp;<input type="number" name="year" style="width:4em" value="<?php echo get_cookie("sale_year");?>"/></p>
<p>
<input type="checkbox" name="is_inventory" id="is_inventory" value=1/>
<label for="show_fields">Show Inventory Fields</label>
</p>
<p>
<input type="checkbox" value="1" name="show_last_only"/>
<label for="show_last_only">Hide plants that already have an order for the next plant sale</label>
</p>
<div id="sort-block">
<? $this->load->view("order/sort");?>
</div>
<p><input type="submit" value="Search"/></p>
</form>