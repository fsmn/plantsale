<?php defined('BASEPATH') or exit('No direct script access allowed');

// list.php Chris Dart Apr 2, 2013 12:47:39 PM chrisdart@cerebratorium.com
$delete_button = '';
if (IS_EDITOR) {
	$delete_button = '<span class="button delete small flag-delete" id="flag-delete_%s">Delete</span>';
}
$output = [];
foreach ($flags as $flag) {
	$output[] = format_string('<div class="flag-row field-set" id="flag_@id"><img src="/images/@source"/>&nbsp;@name&nbsp;@delete</div>', [
		'@id' => $flag->id,
		'@source' => $flag->source,
		'@name' => $flag->name,
		'@delete' => sprintf($delete_button, $flag->id),
	]);
}
print implode("\r", $output);
