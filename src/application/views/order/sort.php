<?php

defined('BASEPATH') or exit('No direct script access allowed');
$sorting = [
	NULL => NULL,
	'catalog_number' => 'Catalog Number',
	'category' => 'Category',
	'subcategory' => 'Subcategory',
	'name' => 'Common Name',
	'genus' => 'Genus',
	'species' => 'Species',
	'variety' => 'Variety',
	'grower_code' => 'Vendor Code',
	'count_presale' => 'Presale Count',
	'count_midsale' => 'Midsale Count',
	'pot_size' => 'Pot Size',
	'grower_id' => 'Grower ID',
	'price' => 'Sale Price',
	'year' => 'Year',
];

$direction = [
	'ASC' => 'Ascending',
	'DESC' => 'Descending',
];

$button = create_button([
	'selection' => 'any',
	'text' => 'Add Sort Option',
	'type' => 'span',
	'class' => 'button add-order-sort small',
]);
$saved_sort = cookie('sorting_fields');
if ($saved_sort && $basic_sort == FALSE) {
	$saved_sort = unserialize($saved_sort);
	$saved_direction = unserialize(cookie('sorting_direction'));
	for ($i = 0; $i < count($saved_sort); $i++) {
		$output[] = '<p>';
		$output[] = form_dropdown('sorting[]', $sorting, $saved_sort[$i]);
		$output[] = form_dropdown('direction[]', $direction, $saved_direction[$i]);
		$output[] = $button;
		$output[] = '</p>';
	}
}
else {
	$output[] = '<p>';
	$output[] = form_dropdown('sorting[]', $sorting, 'genus');
	$output[] = form_dropdown('direction[]', $direction, 'ASC');
	$output[] = $button;
	$output[] = '</p>';
}

echo implode('\r', $output);
