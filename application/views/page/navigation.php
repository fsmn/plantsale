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
		"selection" => "color",
		"type" => "pass-through",
		"text" => "<input type='text' name='color-search' id='color-search-body' class='search-field color-search' value='Find Plants'/>" 
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

// $buttons [] = array (
// "selection" => "all",
// "text" => "Advanced Search",
// "class" => array (
// "button",
// "search-colors"
// ),
// "type" => "span",
// "title" => "Search among the colors"
// );

$buttons [] = array (
		"selection" => "order",
		"text" => "Ordering",
		"class" => array (
				"button",
				"show-ordering" 
		),
		"href" => "#",
		"title" => "View the Ordering Control Panel" 
)
;

print create_button_bar ( $buttons, array (
		"id" => "navigation-buttons" 
) );
