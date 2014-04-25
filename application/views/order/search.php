<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form name="order-search" id="order-search" method="get" action="<?php echo base_url("order/totals");?>">
<p><label for="category">Category</label>&nbsp;<?php echo form_dropdown("category", $categories, get_cookie("category"));?></p>
<p><label for="pot_size">Pot Size</label>&nbsp;<?php echo form_dropdown("pot_size",$pot_sizes, urldecode(get_cookie("pot_size")));?></p>
<p><label for="grower_id">grower ID</label>&nbsp;<input type="text" name="grower_id" style="width:3em;" value="<?php echo get_cookie("grower_id"); ?>"/></p>
<p><label for="flat_size">Flat Size</label>&nbsp;<input type="number" name="flat_size" style="width:3em;" value="<?php echo get_cookie("flat_size"); ?>"/></p>
<div id="sort-block">
<? $this->load->view("order/sort");?>
</div>
<p><input type="submit" value="Search"/></p>

</form>