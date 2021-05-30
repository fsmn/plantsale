<?php defined('BASEPATH') or exit('No direct script access allowed');
if (IS_EDITOR) {
	$buttons['edit'] = [
		'text' => 'Edit',
		'class' => 'button edit variety-edit',
		'id' => 'edit-variety_' . $variety->id,
		'href' => site_url('variety/view/' . $variety->id),
		'selection' => 'home'
	];
}
$buttons['print-tabloid'] = [
	'text' => 'Print Tabloid',
	'class' => 'button print variety-print-tabloid-one',
	'style' => 'print',
	'id' => 'print-tabloid_' . $variety->id,
	'href' => site_url('variety/print_one/' . $variety->id . '/tabloid'),
	'target' => '_blank'
];
$buttons['print-statement'] = [
	'text' => 'Print Statement',
	'class' => 'button print variety-print-statement-one',
	'style' => 'print',
	'id' => 'print-statement_' . $variety->id,
	'href' => site_url('variety/print_one/' . $variety->id . '/statement'),
	'target' => '_blank'
];
$buttons['print-letter'] = [
	'text' => 'Print Letter',
	'class' => 'button print variety-print-letter-one',
	'style' => 'print',
	'href' => site_url('variety/print_one/' . $variety->id . '/letter'),
	'target' => '_blank'
];
$buttons['print-shovel_foot'] = [
	'text' => 'Print Shovel Foot',
	'class' => 'button print variety-print-shovel_foot-one',
	'style' => 'print',
	'href' => site_url('variety/print_one/' . $variety->id . '/shovel_foot'),
	'target' => '_blank'
];
$buttons['print-seed-packet'] = [
	'text' => 'Print Seed Packet',
	'class' => 'button print variety-print-seed_packet-one',
	'style' => 'print', 'href' => site_url('variety/print_one/' . $variety->id . '/seed_packet'),
	'target' => '_blank'
];

if (IS_EDITOR) {
	$buttons['delete'] = [
		'text' => 'Delete',
		'class' => 'button delete variety-delete',
		'style' => 'delete',
		'id' => 'delete-variety_' . $variety->id,
		'type' => 'span',
		'selection' => 'home'
	];
}

print create_button_bar($buttons);
