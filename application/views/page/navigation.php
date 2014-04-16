<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$buttons [] = array (
		"selection" => "index",
		"text" => "Home",
		"class" => array (
				"button" 
		),
		"href" => site_url ( "" ),
		"title" => "Home" 
);




$buttons [] = array (
		"selection" => "common",
		"type" => "pass-through",
		"text" => "<input type='text' name='common-search' id='common-search-body' class='search-field common-search' value='Find Common Names'/>" 
);

$buttons [] = array (
		"selection" => "all",
		"text" => "Advanced Search",
		"class" => array (
				"button",
				"search-common-names"
		),
		"type" => "span",
		"title" => "Search among the common names"
);

$buttons [] = array (
		"selection" => "color",
		"type" => "pass-through",
		"text" => "<input type='text' name='color-search' id='color-search-body' class='search-field color-search' value='Find Colors'/>" 
);

// $buttons [] = array (
// 		"selection" => "all",
// 		"text" => "Advanced Search",
// 		"class" => array (
// 				"button",
// 				"search-colors"
// 		),
// 		"type" => "span",
// 		"title" => "Search among the colors"
// );

print create_button_bar ( $buttons, array (
		"id" => "navigation-buttons" 
) );
