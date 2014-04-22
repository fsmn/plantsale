<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<p>
<select name="sorting[]">
<option value="catalog_number">Catalog Number</option>
<option value="genus">Genus</option>
<option value="vendor_code">Vendor Code</option>
<option value="count_presale">Presale Count</option>
<option value="count_midsale">Midsale Count</option>
</select> <?php echo create_button(array("selection"=>"any","text"=>"Add Sort Option","type"=>"span","class"=>"button add-order-sort small"));?>
</p>
<p>
