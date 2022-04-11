<?php

defined('BASEPATH') or exit('No direct script access allowed');

$countries = ["USA" => "USA", "Canada" => "Canada"];
// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com
$fields = [
		'grower_name' => ['name' => 'grower_name', 'label' => 'Name'],
		'street_address' => [
				'name' => 'street_address',
				'label' => 'Street Address',
		],
		'po_box' => ['name' => 'po_box', 'label' => 'PO Box'],
		'city' => ['name' => 'city', 'label' => 'City'],
		'state' => ['name' => 'state', 'label' => 'State'],
		'zip' => ['name' => 'zip', 'label' => 'Zip'],
		'country' => [
				'name' => 'country',
				'label' => 'Country',
				'type' => 'dropdown',
				'options' => $countries,
		],
		'website' => ['name' => 'website', 'label' => 'Website'],
		'email' => ['name' => 'email', 'label' => 'Email'],
		'phone' => ['name' => 'phone', 'label' => 'Phone'],
		'fax' => ['name' => 'fax', 'label' => 'Fax'],
		'shipping_notes' => [
				'name' => 'shipping_notes',
				'label' => 'Shipping Notes',
				'type' => 'textarea',
		],
];
foreach ($fields as $field) {
	if (array_key_exists("type", $field) && $field["type"] == "dropdown") {
		$output[] = sprintf("<p><label for='%s'>%s:&nbsp;</label>%s</p>", $field["name"], $field["label"], form_dropdown($field["name"], $field["options"], "USA"));
	}
	elseif (array_key_exists('type', $field) && $field['type'] == 'textarea') {
		$output[] = '<p><label for="' . $field['name'] . '"</label>' . form_textarea($field['name'], get_value($grower, $field['name'])) . '</p>';
	}
	else {

		$output[] = sprintf("<p>%s</p>", create_input($grower, $field["name"], $field["label"], $field["name"]));
	}
}
?>
<form
		name="edit-grower"
		id="edit-grower"
		action="<?php echo base_url('grower/' . $action); ?>"
		method="post">
	<p>
		<label for="id">Unique Grower ID: </label>
		<?php if ($action == 'insert'): ?>
			<input
					type="text"
					size="3"
					name="id"
					id="grower-id"
					value="<?php echo get_value($grower, 'id'); ?>"/><span
					id="unique-id"></span>
		<?php else: ?>
		<input type="hidden" name="id" value="<?php print $grower->id; ?>"/>
			<span><?php print $grower->id; ?></span>
		<?php endif; ?>
	</p>
	<p><label for="user_id">Our Contact</label>
		<?php echo form_dropdown('user_id', $users, get_value($grower, 'user_id')); ?>
	</p>
	<?php echo implode("", $output); ?>
	<p>
		<input
				type="submit"
				class="button <?php print $action; ?>"
				value="<?php print ucfirst($action); ?>"/>
	</p>
</form>
