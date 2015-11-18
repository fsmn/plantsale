<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$user = $this->ion_auth->user ()->row ();
// @TODO create functions for managing current year
$buttons [] = array (
		"selection" => "index",
		"text" => sprintf ( "Current Year: %s", get_cookie ( "sale_year" ) ),
		"class" => array (
				"button edit set-current-year"
		),
		"style"=>"edit",
		"title" => "Set the current working year of the plant sale"
);
$buttons [] = array (
		"selection" => "auth",
		"text" => get_user_name ( $user ),
		"class" => array (
				"edit_user",
				"button","auth"
		),
		"style"=>"auth",
		"href" => site_url ( "auth/edit_user/" . $user->id )
);
if (IS_ADMIN) {
	$buttons [] = array (
			"selection" => "auth",
			"text" => "Users",
			"class" => array (
					"button",
					"auth"
			),
			"style"=>"auth",
			"href" => site_url ( "auth" ),
			"title" => "Edit the site users"
	);
}

$buttons [] = array (
		"selection" => "index",
		"text" => "Log Out&nbsp;<i class='fa fa-sign-out'></i>",
		"class" => array (
				"button","auth"
		),
		"href" => site_url ( "auth/logout" ),
		"title" => sprintf ( "Log out %s", get_user_name ( $user ) )
);


print create_button_bar ( $buttons, array (
		"id" => "utility-buttons"
) );
