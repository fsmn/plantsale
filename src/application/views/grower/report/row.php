<?php

defined('BASEPATH') or exit('No direct script access allowed');

// row.php Chris Dart Jan 8, 2015 2:59:57 PM chrisdart@cerebratorium.com
$email_phone = [];
if ($grower->email) {
	$email_phone[] = format_email($grower, 'email');
}
if ($grower->phone) {
	$email_phone[] = $grower->phone;
}
if ($grower->fax) {
	$email_phone[] = $grower->fax;
}


?>
<tr class="row grower total">
	<td class="field"><a
				href="<?php echo base_url('grower/view/' . $grower->id); ?>"
				title="view and edit the grower record"><?php echo $grower->id; ?></a>
	</td>
	<td class="field"><a
				href="<?php echo base_url('grower/view/' . $grower->id); ?>" title="
				View and edit the grower
				record"><?php echo $grower->grower_name; ?></a></td>
	<td class="field">
		<?php echo implode("<br/>", $email_phone); ?>
	</td>
	<?php $address = format_address($grower); ?>
	<td class="field"><?php echo $address['street']; ?><br/>
		<?php echo $address['locale'];
		echo $address['country'] != 'USA' ? ', ' . $address['country'] : '';
		?></td>
	<td>
		<?php if (!empty($grower->our_contact)): ?>
			<?php print $grower->our_contact->first_name . ' ' . $grower->our_contact->last_name; ?>
		<?php endif; ?>
	<td class="field"
		style="text-align: right;"><?php echo get_as_price($grower->total); ?></td>
	<td class="field no-print"><a
				href="<?php echo base_url('order/search?find=true&grower_id=' . $grower->id . '&year=' . $year . '&sorting%5B%5D=genus&direction%5B%5D=ASC'); ?>"
				title="View current orders for this grower"><?php echo $year; ?>
			Orders</a></td>
</tr>
