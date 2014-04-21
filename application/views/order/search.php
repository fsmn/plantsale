<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<form name="order-search" id="order-search" method="get" action="<?php echo base_url("order/totals");?>">
<p><label for="category">Category</label><?php echo form_dropdown("category", $categories, get_cookie("category"));?></p>
<p><label for="vendor_id">Vendor ID</label><input type="text" name="vendor_id" style="width:3em;" value="<?php echo get_cookie("vendor_id"); ?>"/></p>
<p><input type="submit" value="Search"/></p>
</form>