<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<p>
<select name="sorting[]">
<option value=""></option>
<option value="catalog_number">Catalog Number</option>
<option vallue="category">Category</option>
<option value="subcategory">Subcategory</option>
<option value="genus" selected>Genus</option>
<option value="species" >Species</option>
<option value="variety">Variety</option>
<option value="grower_code">Vendor Code</option>
<option value="count_presale">Presale Count</option>
<option value="count_midsale">Midsale Count</option>
<option value="pot_size">Pot Size</option>
<option value="common.name">Common Name</option>
</select>
<select name="direction[]">
<option value="ASC">Ascending</option>
<option value="DESC">Descending</option>
</select>

<?php echo create_button(array("selection"=>"any","text"=>"Add Sort Option","type"=>"span","class"=>"button add-order-sort small"));?>
</p>
<p>
