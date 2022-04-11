<?php defined('BASEPATH') or exit('No direct script access allowed');
if (empty($grower)) {
	$this->session->set_flashdata('warning', 'No grower was provided.');
}
$buttons = [
		'edit' => [
				'text' => 'Edit',
				'href' => base_url('grower/edit/' . $grower->id),
				'class' => ['button', 'edit', 'dialog'],
		],
];

?>
<h2>
	Grower: <?php echo $grower->grower_name != "" ? $grower->grower_name : $grower->id; ?></h2>
<?php print create_button_bar($buttons); ?>
<div class="column left">
	<?php foreach ($fields as $field): ?>
		<?php $this->load->view('fields/field_template', [
				'name' => $field,
				'value' => get_value($grower, $field),
				'wrapper' => 'p',
		]); ?>
	<?php endforeach; ?>
	<?php $this->load->view('fields/field_template', [
			'name' => 'our_contact',
			'value' => $grower->our_contact->first_name . ' ' . $grower->our_contact->last_name,
	]); ?>
</div>
<div class="column right last">
	<h3>Contacts</h3>
	<?php echo create_button_bar([
			[
					'text' => 'New Contact',
					'href' => site_url('contact/create/' . $grower->id),
					'class' => 'button new create-contact mini',
			],
	]); ?>
	<?php foreach ($grower->contacts as $contact): ?>
		<?php $this->load->view("contact/view", ['contact' => $contact]); ?>
	<?php endforeach; ?>
</div>
