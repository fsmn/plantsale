<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Apr 2, 2013 12:47:39 PM chrisdart@cerebratorium.com
$output = array();
foreach($flags as $flag){
	$output[] = sprintf("<div class='flag-row field-set' id='flag_%s'>%s <span class='button delete small flag-delete'>Delete</span></div>",$flag->id, $flag->name);
}
print implode("\r",$output);