<?php

defined('BASEPATH') or exit('No direct script access allowed');

// row.php Chris Dart Jan 8, 2015 2:59:57 PM chrisdart@cerebratorium.com

$year = get_cookie("sale_year");

?>
<tr class="row grower total">
<td class="field"><a href="<?=base_url("grower/view/$grower->id");?>" title="view and edit the grower record"><?=$grower->id;?></a></td>
	<td class="field"><a href="<?=base_url("grower/view/$grower->id");?>" title="View and edit the grower record"><?=$grower->grower_name;?></a></td>
	<? $address = format_address($grower); ?>
	<td class="field"><?=$address["street"];?></td>
	<td class="field"><?=$address["locale"];?></td>
		<td class="field"><?=get_as_price($grower->total);?></td>
		<td class="field"><a href="<?=base_url("order/search?grower_id=$grower->id&year=$year&sorting%5B%5D=genus&direction%5B%5D=ASC");?>" title="View current orders for this grower">Current Orders</a></td>
</tr>