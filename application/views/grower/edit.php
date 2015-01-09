<?php

defined('BASEPATH') or exit('No direct script access allowed');

// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com
$fields = array(
        "grower_name" => "Name",
        "street_address" => "Street Address",
        "po_box" => "PO Box",
        "city" => "City",
        "state" => "State",
        "zip" => "Zip",
        "country" => "Country",
        "website" => "Website",
        "email" => "Email",
        "phone" => "Phone",
        "fax" => "Fax"
);
foreach ($fields as $field => $key) {
    $output[] = sprintf("<p>%s</p>", create_input($grower, $field, $key, $field, NULL, FALSE));
}
?>
<form
	name="edit-grower"
	id="edit-grower"
	action="<?=base_url("grower/$action");?>"
	method="post">
	<p>
		<label for="id">Unique Grower ID: </label><input
			type="text"
			size="3"
			name="id"
			id="grower-id"
			value="<?=get_value($grower,"id");?>" /><span id="unique-id"></span>
	</p>
<? echo implode("\r",$output);?>
<p>
		<input
			type="submit"
			class="button add"
			value="<?=ucfirst($action);?>" />
	</p>
</form>
<p class="highlight">More features to come!</p>