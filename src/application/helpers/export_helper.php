<?php
defined('BASEPATH') or exit('No direct script access allowed');

// quark_helper.php Chris Dart Feb 9, 2015 4:34:51 PM
// chrisdart@cerebratorium.com
function format_sunlight($sunlight, $format = 'quark') {
	$output = '';
	if ($format == 'quark' || $format == 'poster') {
		if (strstr($sunlight, 'full')) {
			$output .= 'Í';
		}
		if (strstr($sunlight, 'part')) {
			$output .= '∏';
		}
		if (strstr($sunlight, 'shade')) {
			$output .= 'Ó';
		}
	}
	else {
		if (strstr($sunlight, 'full')) {
			$output .= '+++';
		}
		if (strstr($sunlight, 'part')) {
			$output .= '%%%';
		}
		if (strstr($sunlight, 'shade')) {
			$output .= '///';
		}
	}

	if ($format == 'quark') {
		$output = sprintf('<f\'FSMPlantSaleIcons\'>%s<f$>', $output);
	}
	return $output;
}

/**
 * the rules for codes are baffling and require special knowledge,
 * but here we are with a crazy setup.
 * Someday we'll
 * clean this up.
 */
function format_flags($flags, $format = 'quark') {
	$output = FALSE;
	foreach ($flags as $flag) {
		switch ($flag->name) {
			case 'Bees':
				if ($format == 'quark' || $format == 'poster') {
					$output .= 'Ω';
					// If(flag~Bee > 'a';'Ω';'')
				}
				else {
					$output = 'Bee';
				}
				break;
			case 'Birds':
				if ($format == 'quark' || $format == 'poster') {
					$output .= 'ı';
				}
				else {
					$output = 'BirdB';
				}
				break;
			case 'Butterflies':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '∫';
				}
				else {
					$output .= 'ButterB';
				}
				break;
			case 'Cold Sensitive':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '†';
				}
				else {
					$output .= 'ColdB';
				}
				break;
			case 'Culinary':
				if ($format == 'quark' || $format == 'poster') {
					$output .= 'Ç';
				}
				else {
					$output .= 'CulinaryB';
				}
				break;
			case 'Edible Flowers':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '´';
				}
				else {
					$output .= 'EdibleB';
				}
				break;
			case 'Ground Cover':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '˝';
				}
				else {
					$output = 'GroundB';
				}
				break;
			case 'Hummingbirds':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '˙';
				}
				else {
					$output .= 'HummB';
				}
				break;
			case 'Interesting Foliage':
				if ($format == 'quark' || $format == 'poster') {
					$output .= 'ç';
				}
				else {
					$output .= 'FoliageB';
				}
				break;
			case 'Medicinal':
				if ($format == 'quark' || $format == 'poster') {
					$output .= 'Â';
				}
				else {
					$output .= 'MedicinalB';
				}
				break;
			case 'Minnesota Native':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '˜';
				}
				else {
					$output .= 'NativeB';
				}
				break;
			case 'Organic':
				if ($format == 'quark' || $format == 'poster') {
					$output .= 'Ø';
				}
				else {
					$output .= 'OrganicB';
				}
				break;
			case 'Poisonous':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '¥';
				}
				else {
					$output .= 'PoisonousB';
				}
				break;
			case 'Rock Garden':
				if ($format == 'quark' || $format == 'poster') {
					$output .= '‰';
				}
				else {
					$output .= 'RockB';
				}
				break;
			case 'Houseplant':
				if($format == 'quark' || $format == 'poster'){
					$output .= 'ƒ';
				}
				else{
					$output .= 'HouseplantB';
				}
		}
	}
	if ($format == 'quark') {
		if ($output) {
			$output = sprintf('<f\'FSMPlantSaleIcons\'>%s<f$>', $output);
		}
	}
	return $output;
}

/**
 * Assume that the determination of new year is calculated elsewhere.
 */
function format_new($format = 'quark') {
	if ($format == 'quark') {
		$output = sprintf('<f\'FSMPlantSaleIcons\'>%s<f$>', '◊');
	}
	elseif ($format == 'poster') {
		$output = '◊';
	}
	else {
		$output = 'Y';
	}

	return $output;
}

function format_saturday($format = 'quark') {
	if ($format == 'quark') {
		$output = sprintf('<f\'FSMPlantSaleIcons\'>%s<f$>', 'ß');
	}
	elseif ($format == 'poster') {
		$output = 'ß';
	}
	else {
		$output = 'qqq';
	}
	return $output;
}

/**
 * format the dimensions of the dimensions of the object
 *
 * @param $object
 *
 * @return string If a variety doesn't have a measurmement, then assume inches.
 */
function format_quark_dimensions($object) {
	$output = [];
	if (($object->min_height && $object->min_height > 0) || ($object->max_height && $object->max_height > 0)) {
		$output['height'] = format_dimensions($object->min_height, $object->max_height,
			$object->height_unit == 'Inches' || $object->height_unit == NULL ? '”' : '’', 'h');
	}
	if (($object->min_width && $object->min_height > 0) || ($object->max_width && $object->max_width > 0)) {
		$output['width'] = format_dimensions($object->min_width, $object->max_width, $object->width_unit == 'Inches' || $object->width_unit == NULL ? '”' : '’',
			'w');
	}
	return implode(' by ', $output);
}

function format_description($description, $object, $format = FALSE) {
	if ($object->print_description) {
		$output[] = trim($object->print_description);
	}
	// if ($format == 'web') {
	// if ($object->web_description) {
	// $output[] = trim($object->web_description);
	// }
	// }
	$output[] = $description;
	return implode(' ', $output);
}

function subcategory_order($categories = []) {
	if (!$categories) {
		$categories = [
			'Indoor Plants',
			'Hanging Baskets',
			'Succulents',
			'General Annuals',
			'General Perennials',
			'Water Plants',
		];
	}
	$category_order = 'CASE ';

	for ($i = 0; $i < count($categories); $i++) {
		$my_category = $categories[$i];
		$x = $i + 1;
		$category_order .= "WHEN subcategory='$my_category' THEN $x ";
	}
	$category_order .= 'END';
	return $category_order;
}

function quark_single($common) {
	$variety = $common->varieties[0];
	$output[] = sprintf('@Common Name:<@Number In-text>%s<@\$p> %s ', $variety->catalog_number, $common->name);
	$output[] = $variety->count_midsale > 0 ? format_saturday('quark') : '';
	$output[] = $variety->new_year == get_current_year() ? format_new('quark') : '';
	$output[] = sprintf('<p>@Latin Name:%s ', quark_latin_name($common->genus, $variety->species));
	$output[] = sprintf('<f\'GoudySansITCbyBT-Medium\'> %s<f$>', $variety->variety);
	$output[] = sprintf('<p>@Copy:%s ', format_description($common->description, $variety, 'quark'));
	$output[] = format_quark_dimensions($variety);
	$output[] = sprintf(' %s', format_sunlight($common->sunlight, 'quark'));
	$output[] = format_flags($variety->flags, 'quark');
	$output[] = sprintf('<p>@Pot and Price Right:%s--%s', get_as_price($variety->price), $variety->pot_size);
	return implode('', $output);
}

function quark_multiple($common) {
	$output[] = sprintf('@Common Name:%s<p>@Latin Name:%s<p>@Copy:%s %s', $common->name, $common->genus, $common->description,
		format_sunlight($common->sunlight, 'quark'));

	// set prices and pot sizes based on if they show up in the output.
	$base_price = FALSE;
	$base_size = FALSE;
	foreach ($common->varieties as $variety) {
		$price = FALSE;
		$pot_size = FALSE;
		if ($base_price != $variety->price || $base_size != $variety->pot_size) {
			$price = $variety->price;
			$pot_size = $variety->pot_size;
			$base_price = $price;
			$base_size = $pot_size;
		}
		//if either the pot size or price have changed, then print them out.
		if ($price || $pot_size) {
			$output[] = sprintf('<p>@Pot and Price:%s--%s:', get_as_price($price), $pot_size);
		}
		$output[] = sprintf('<p>@Copy After Copy:<@Number In-text>%s ', $variety->catalog_number);
		$output[] = sprintf('<@In text Goudy Sans Bold>%s<@\$p> <I>%s</I> ', $variety->variety, quark_latin_name($common->genus, $variety->species, TRUE));
		$output[] = $variety->new_year == get_current_year() ? format_new('quark') : '';
		$output[] = (get_value($variety, 'count_midsale') > 0) ? ' ' . format_saturday('quark') : '';
		$output[] = sprintf('--%s %s %s', $variety->print_description, format_quark_dimensions($variety), format_flags($variety->flags, 'quark'));
	}
	return implode('', $output);
}
