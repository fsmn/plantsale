<?php

defined('BASEPATH') or exit('No direct script access allowed');

// row.php Chris Dart Jan 8, 2015 2:59:57 PM chrisdart@cerebratorium.com

/*
 * INSERT INTO `grower` (`id`, `grower_name`, `street_address`, `po_box`,
 * `city`, `state`, `zip`, `website`, `email`, `phone`, `fax`, `shipping_notes`)
 * VALUES ('AA', 'Arrowhead Alpines', '1310 N Gregory Rd', 'PO Box 857',
 * 'Fowlerville', 'MI', '48836', '', '', '517-223-3581', '', '1769');
 */


?>
<tr class="row grower total">
	<td class="field"><?=$grower->grower_name;?></td>
	<? $address = format_address($grower); ?>
	<td class="field"><?=$address["street"];?></td>
	<td class="field"><?=$address["locale"];?></td>
		<td class="field"><?=get_as_price($grower->total);?></td>
</tr>