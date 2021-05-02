<?php

defined('BASEPATH') or exit ('No direct script access allowed');

$user = $this->ion_auth->user()->row();
// @TODO create functions for managing current year
/*
$buttons [] = [
	'selection' => 'index',
	'text' => sprintf('Current Year: %s', $this->session->userdata('sale_year')),
	'class' => [
		'button edit dialog',
	],
	'href' => base_url('index/show_set_year'),
	'style' => 'edit',
	'title' => 'Set the current working year of the plant sale',
];*/

$buttons [] = [
	'selection' => 'auth',
	'text' => get_user_name($user),
	'class' => [
		'edit_user',
		'button',
		'auth',
	],
	'style' => 'auth',
	'href' => site_url('auth/edit_user/' . $user->id),
];
if (IS_ADMIN) {
	$buttons [] = [
		'selection' => 'auth',
		'text' => 'Users',
		'class' => [
			'button',
			'auth',
		],
		'style' => 'auth',
		'href' => site_url('auth'),
		'title' => 'Edit the site users',
	];
	$buttons[] = [
		'selection'=>'auth',
		'text'=>'Menus',
		'title' => 'Edit Menu Items',
		'style'=>'auth',
		'class'=> [
			'button',
			'auth',
		],
		'href'=>site_url('menu/show_all'),
	];

}
if (IS_ADMIN || $this->ion_auth->in_group([
		5,
	])) {
	$buttons [] = [
		'selection' => 'auth',
		'text' => 'Download DB <i class="fa fa-download"></i>',
		'title' => 'Download a copy of the database',
		'style' => 'auth',
		'href' => site_url('backup'),
		'class' => ['button', 'auth'],
	];
}
$buttons [] = [
	'selection' => 'index',
	'text' => 'Log Out&nbsp;<i class="fa fa-sign-out"></i>',
	'class' => [
		'button',
		'auth',
	],
	'href' => site_url('auth/logout'),
	'title' => sprintf('Log out %s', get_user_name($user)),
];


print create_button_bar($buttons, [
	'id' => 'utility-buttons',
]);
