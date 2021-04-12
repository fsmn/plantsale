<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (!empty($orders)) {
	//$filename = 'order_export.csv';
	// Define the fields desired for output in this array
	$fields = [
		'grower_id' => 'Grower ID',
		'year' => 'Year',
		'catalog_number' => 'Catalog Number',
		'new_year' => 'First year at Sale',
		'name' => 'Common Name',
		'genus' => 'Genus',
		'species' => 'Species',
		'variety' => 'Variety',
		'category' => 'Category',
		'subcategory' => 'Subcategory',
		'pot_size' => 'Pot Size',
		'count_presale' => 'Presale Order',
		'count_friday' => 'Friday Order',
		'count_saturday' => 'Saturday Order',
		'count_midsale' => 'Midsale Order',
		'flat_count' => 'Total Flats',
		'received_presale' => 'Received Presale',
		'received_friday' => 'Received Friday',
		'received_saturday' => 'Received Saturday',
		'received_midsale' => 'Received Midsale',
		'sellout_friday' => 'Sellout Time Friday',
		'sellout_saturday' => 'Sellout Time Saturday',
		'remainder_friday' => 'Remainder Friday',
		'remainder_saturday' => 'Remainder Saturday',
		'remainder_sunday' => 'Remainder Sunday',
		'count_dead' => 'Count of Dead Plants',
		'flat_size' => 'Flat Size',
		'flat_cost' => 'Flat Cost',
		'plant_cost' => 'Plant Cost',
		'price' => 'Sale Price',
		'flat_area' => 'Flat Area',
		'tiers' => 'Tiers',
		'grower_code' => 'Grower Code',
		'flat_exclude' => 'Flat Exclude',
	];

	if ($export_type == 'grower') {
		$fields = [
			'name' => 'Common Name',
			'genus' => 'Genus',
			'species' => 'Species',
			'variety' => 'Variety',
			'category' => 'Category',
			'subcategory' => 'Subcategory',
			'pot_size' => 'Pot Size',
			'count_presale' => 'Presale',
			'count_friday' => 'Friday 2021',
			'count_saturday' => 'Saturday 2021',
			'count_midsale' => 'Midsale',
			'flat_count' => 'Total Flats',
			'flat_size' => 'Flat Size',
			'flat_cost' => 'Flat Cost',
			'plant_cost' => 'Plant Cost',
			'price' => 'Sale Price',
			'grower_code' => 'Grower Code',
		];
	}
	$header_values = array_keys($fields);

	$output = [
		implode(',', $header_values),
	];
	foreach ($orders as $order) {
		$current_year = $order->year;
		foreach (array_keys($fields) as $key) {
			if ($key == 'new_year') {
				if ($order->$key == $current_year) {
					$line[] = 'New';
				} else {
					$line[] = '';
				}
			} else {
				$line[] = $order->$key;
			}
		}
		$output[] = '\'' . implode('\',\'', $line) . '\'';
		$line = NULL;
	}

	$data = implode('\n', $output);
	if (empty($filename)) {
		$filename = 'order_export.csv';
	}
	force_download($filename, $data);
}
