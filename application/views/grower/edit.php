<?php

defined('BASEPATH') or exit('No direct script access allowed');
$countries = array("USA"=>"USA","Canada"=>"Canada");
// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com
$fields = array(
        "grower_name" => array("label"=>"Name"),
        "street_address" => array("label"=>"Street Address"),
        "po_box" => array("label"=>"PO Box"),
        "city" => array("label"=>"City"),
        "state" => array("label"=>"State"),
        "zip" => array("label"=>"Zip"),
        "country" => array("label"=>"Country","type"=>"dropdown","options"=>$countries),
        "website" => array("label"=>"Website"),
        "email" => array("label"=>"Email"),
        "phone" => array("label"=>"Phone"),
        "fax" => array("label"=>"Fax"),
);
foreach ($fields as $field ) {
if(array_key_exists("type",$field) && $field["type"] == "dropdown"){
    $output[] = sprintf("<p><label for='%s'>%s:&nbsp;</label>%s</p>",$field, $field["label"],form_dropdown($field,$field["options"],"USA"));
}else{

    $output[] = sprintf("<p>%s</p>", create_input($grower, $field, $field["label"], $field));
}
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