<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!empty($plants)) {
	if (empty($filename)) {
		$filename = 'varieties.csv';
	}
	if (empty($export_type)) {
		$export_type = 'standard';
	}
	$handle = fopen('php://output', 'w');
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename=' . $filename);
	header('Pragma: no-cache');
	header('Expires: 0'); // Define the fields desired for output in this array
	$fields = [
		'year' => 'Year',
		'catalog_number' => 'Catalog Number',
		'new_year' => 'First year at Sale',
		'name' => 'Common Name',
		'genus' => 'Genus',
		'species' => 'Species',
		'variety' => 'Variety',
		'category' => 'Category',
		'subcategory' => 'Subcategory',
		'description' => 'Description',
		'print_description' => 'Print Description',
		'web_description' => 'Web Description',
		'plant_color' => 'Plant Color',
		'min_height' => 'Min Height',
		'max_height' => 'Max Height',
		'height_unit' => 'Height Unit',
		'min_width' => 'Min Width',
		'max_width' => 'Max Width',
		'width_unit' => 'Width Unit',
		'grower_id' => 'Grower ID',
		'null_link' => 'Link',
	];

	if ($export_type == 'copy_edits') {
		$fields = [
			'name' => 'Common Name',
			'genus' => 'Genus',
			'species' => 'Species',
			'variety' => 'Variety',
			'category' => 'Category',
			'subcategory' => 'Subcategory',
			'grower_id' => 'Grower ID',
			'new_year' => 'New',
			'null_writer' => 'Writer',
			'null_coordinator' => 'Coordinator',
			'null_copy_in' => 'Copy in DB',
			'null_copy_recd' => 'Copy Received',
			'null_notes' => 'Notes',
			'description' => 'Description',
			'print_description' => 'Print Description',
			'web_description' => 'Web Description',
			'null_link' => 'Link',
		];
	}

	$header_values = array_values($fields);

	fputcsv($handle, $header_values);
	foreach ($plants as $plant) {
		$current_year = $plant->year;
		$line = [];
		foreach (array_keys($fields) as $key) {
			if ($key == 'new_year') {
				if ($plant->$key == $current_year) {
					$line[] = 'New';
				} else {
					$line[] = '';
				}
			} elseif (stristr($key, 'null_')) {
				$line[] = '';
			} else {
				$line[] = $plant->$key;
			}
		}
		$line[] = format_string('http://db.friendsschoolplantsale.com/variety/view/@id', [
			'@id' => $plant->id
		]);

		fputcsv($handle, $line);
	}

	fclose($handle);
	force_download($filename);
}
