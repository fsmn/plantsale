<?php

function mysql_timestamp() {

	return date ( 'Y-m-d H:i:s' );

}

function bake_cookie($name, $value) {

	set_cookie ( array (
			"name" => $name,
			"value" => $value,
			"expire" => 0 
	) );

}

function burn_cookie($name) {

	set_cookie ( array (
			"name" => $name,
			"value" => "",
			"expire" => NULL 
	) );

}

function create_input($object, $name, $label, $id = NULL) {

	if (! $id) {
		$id = $name;
	}
	return sprintf ( "<label for='%s'>%s: </label><input type='text' name='%s' id='%s' value='%s'/>", $name, $label, $name, $id, get_value ( $object, $name ) );

}

function get_current_year() {

	if (date ( "m" ) > 7) { // after July
		$year = date ( "Y" ) + 1;
	} else {
		$year = date ( "Y" );
	}
	return $year;

}

/*
 * @params $table varchar table name @params $data array consisting of "where" string or array, and "select" comma-delimited string @returns an array of key-value pairs reflecting a Database primary key and human-meaningful string
 */
function get_keyed_pairs($list, $pairs, $initialBlank = NULL, $other = NULL, $alternate = array()) {

	$output = false;
	if ($initialBlank) {
		$output [] = "";
	}
	if (! empty ( $alternate )) {
		$output [$alternate ['name']] = $alternate ['value'];
	}
	
	foreach ( $list as $item ) {
		$key_name = $pairs [0];
		$key_value = $pairs [1];
		$output [urlencode ( $item->$key_name )] = $item->$key_value;
	}
	if ($other) {
		$output ["other"] = "Other...";
	}
	return $output;

}

function get_value($object, $item, $default = null) {

	$output = $default;
	
	if ($default) {
		$output = $default;
	}
	if ($object) {
		
		$var_list = get_object_vars ( $object );
		$var_keys = array_keys ( $var_list );
		if (in_array ( $item, $var_keys )) {
			$output = ($object->$item);
		}
	}
	return $output;

}

function get_as_price($int) {

	$output = sprintf ( "$%s", number_format ( $int, 2 ) );
	return $output;

}

function get_user_name($user) {

	return sprintf ( "%s %s", $user->first_name, $user->last_name );

}

function format_latin_name($genus, $species = NULL) {

	$output [] = ucfirst ( $genus );
	
	if ($species) {
		$output [] = strtolower ( $species );
	}
	return implode ( " ", $output );

}

function format_catalog($order_id, $category) {

	return sprintf ( "%s%s", ucfirst ( substr ( $category, 0, 1 ) ), $order_id );

}

function abbr_unit($measure) {

	switch ($measure) {
		case "Feet" :
			$output = "&#39;";
			break;
		case "Inches" :
		default :
			$output = "&quot;";
			break;
	}
	return $output;

}

function format_dimensions($min, $max, $unit = "Inches", $direction = NULL) {

	$output = "";
	
	if ($min == $max) {
		$output = sprintf ( "%s%s", $min, ucfirst ( $unit ) );
	} else {
		$output = sprintf ( "%s-%s%s", $min, $max, ucfirst ( $unit ) );
	}
	if ($direction) {
		$output = sprintf ( "%s %s", $output, $direction );
	}
	return $output;

}
//remove underscores, capitalize words.
function decode_string($string){
	
}