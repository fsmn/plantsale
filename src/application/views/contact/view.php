<?php

defined('BASEPATH') or exit('No direct script access allowed');

// view.php Chris Dart Mar 5, 2015 2:26:16 PM chrisdart@cerebratorium.com
?>
<div class="contact-info block">
	<p><?php print create_button([
		'text' => 'Edit',
		'href' => site_url('contact/edit/' . $contact->id),
		'class' => [
			'button',
			'small',
			'edit',
			'edit-contact',
		]]); ?><label>&nbsp;Name:
		</label><?php print $contact->name; ?>
	</p>
	<p><label>Type: </label><?php print ucfirst($contact->contact_type); ?></p>
	<p><label>Phone 1:
		</label><?php print ucfirst(get_value($contact, 'phone1_type', 'Main')); ?>&nbsp;<?php print $contact->phone1; ?></p>
	<p><label>Phone 2:
		</label><?php print ucfirst(get_value($contact, 'phone2_type', 'Main')); ?>&nbsp;<?php print $contact->phone2; ?></p>
	<p><label>Email: </label><?php print get_value($contact, 'email', ''); ?></p>
	<p><label>Notes: </label><?php print get_value($contact, 'notes'); ?></p>
</div>