<?php defined('BASEPATH') OR exit('No direct script access allowed');

// list.php Chris Dart Apr 2, 2013 12:47:39 PM chrisdart@cerebratorium.com
$delete_button = "";
if(IS_EDITOR){
	$delete_button = "<span class='button delete small flag-delete' id='flag-delete_%s'>Delete</span>";
}
$output = array();
foreach($flags as $flag){
	$output[] = sprintf("<div class='flag-row field-set' id='flag_%s'><img src='/images/%s'/>&nbsp;%s&nbsp;%s</div>",  $flag->id, $flag->source, $flag->name, sprintf($delete_button,$flag->id));
}
print implode("\r",$output);