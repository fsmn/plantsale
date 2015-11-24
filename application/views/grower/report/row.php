<?php

defined('BASEPATH') or exit('No direct script access allowed');

// row.php Chris Dart Jan 8, 2015 2:59:57 PM chrisdart@cerebratorium.com
$email_phone = array();
if($grower->email){
    $email_phone[] = format_email($grower,"email");
}
if($grower->phone){
    $email_phone[] = $grower->phone;
}
if($grower->fax){
    $email_phone[] = $grower->fax;
}

$year = get_cookie("sale_year");

?>
<tr class="grower total">
<td class="field"><a href="<?=base_url("grower/view/$grower->id");?>" title="view and edit the grower record"><?=$grower->id;?></a></td>
	<td class="field"><a href="<?=base_url("grower/view/$grower->id");?>" title="View and edit the grower record"><?=$grower->grower_name;?></a></td>
	<td class="field">
	<?=implode("<br/>",$email_phone);?>
	</td>
	<? $address = format_address($grower); ?>
	<td class="field"><?=$address["street"];?><br/>
	<?=$address["locale"];
	echo $address["country"] != "USA"? ", " . $address["country"]:"";
	?></td>
		<td class="field" style="text-align: right;"><?=get_as_price($grower->total);?></td>
		<td class="field no-print"><a href="<?=base_url("order/search?find=true&grower_id=$grower->id&year=$year&sorting%5B%5D=genus&direction%5B%5D=ASC");?>" title="View current orders for this grower">Current Orders</a></td>
</tr>