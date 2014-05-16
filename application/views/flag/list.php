<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Apr 2, 2013 12:47:39 PM chrisdart@cerebratorium.com
$delete_button = "";
if(DB_ROLE == 1){
	$delete_button = "<span class='button delete small flag-delete'>Delete</span>";
}
$output = array();
foreach($flags as $flag){
	$output[] = sprintf("<div class='flag-row field-set' id='flag_%s'><img src='/images/%s'/>&nbsp;%s&nbsp;%s</div>",  $flag->id, $flag->source, $flag->name, $delete_button);
}
print implode("\r",$output);