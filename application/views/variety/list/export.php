<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// $filename = "order_export.csv";
// Define the fields desired for output in this array
$fields = array (
		"year" => "Year",
		"catalog_number" => "Catalog Number",
		"new_year" => "First year at Sale",
		"name" => "Common Name",
		"genus" => "Genus",
		"species" => "Species",
		"variety" => "Variety",
		"category" => "Category",
		"subcategory" => "Subcategory",
		"description" => "Description",
		"print_description" => "Print Description",
		"web_description" => "Web Description",
		"plant_color" => "Plant Color",
		"min_height" => "Min Height",
		"max_height" => "Max Height",
		"height_unit" => "Height Unit",
		"min_width" => "Min Width",
		"max_width" => "Max Width",
		"width_unit" => "Width Unit",
		"new_year" => "New",
		"grower_id" => "Grower ID" ,
		"null1"=>"Link",
)
;

if ($export_type == "copy_edits") {
	$fields = array (
			"name" => "Common Name",
			"genus" => "Genus",
			"species" => "Species",
			"variety" => "Variety",
			"category" => "Category",
			"subcategory" => "Subcategory",
			"grower_id" => "Grower ID",
			"new_year" => "New",
			"null1" => "Writer",
			"null2" => "Coordinatory",
			"null3" => "Copy in DB",
			"null4" => "Copy Received",
			"null5" => "Notes" ,
			"null1"=>"Link",
				
	);
}

foreach ( array_values ( $fields ) as $value ) {
	$header_values [] = $value;
}

$output = array (
		implode ( ",", $header_values ) 
);
foreach ( $plants as $plant ) {
	$current_year = $plant->year;
	
	foreach ( array_keys ( $fields ) as $key ) {
		if ($key == "new_year") {
			if ($plant->$key == $current_year) {
				$line [] = "New";
			} else {
				$line [] = "";
			}
		} elseif (strpos ( $key, "null" )) {
			$line [] = "";
		} else {
			$line [] = $plant->$key;
		}
	}
	$line[] = sprintf("http://db.friendsschoolplantsale.com/variety/view/%s",$plant->id);
	
	$output [] = "\"" . implode ( "\",\"", $line ) . "\"";
	$line = NULL;
}

$data = implode ( "\n", $output );
force_download ( $filename, $data );