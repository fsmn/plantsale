<?php

defined('BASEPATH') or exit('No direct script access allowed');
$countries = array("USA"=>"USA","Canada"=>"Canada");
// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com
$fields = array(
        "grower_name" => array("name"=>"grower_name","label"=>"Name"),
        "street_address" => array("name"=>"street_address","label"=>"Street Address"),
        "po_box" => array("name"=>"po_box","label"=>"PO Box"),
        "city" => array("name"=>"city","label"=>"City"),
        "state" => array("name"=>"state","label"=>"State"),
        "zip" => array("name"=>"zip","label"=>"Zip"),
        "country" => array("name"=>"country","label"=>"Country","type"=>"dropdown","options"=>$countries),
        "website" => array("name"=>"website","label"=>"Website"),
        "email" => array("name"=>"email","label"=>"Email"),
        "phone" => array("name"=>"phone","label"=>"Phone"),
        "fax" => array("name"=>"fax","label"=>"Fax"),
);
foreach ($fields as $field ) {
if(array_key_exists("type",$field) && $field["type"] == "dropdown"){
    $output[] = sprintf("<p><label for='%s'>%s:&nbsp;</label>%s</p>",$field["name"], $field["label"],form_dropdown($field["name"],$field["options"],"USA"));
}else{

    $output[] = sprintf("<p>%s</p>", create_input($grower, $field["name"], $field["label"], $field["name"]));
}
}
?>
<form
	name="edit-grower"
	id="edit-grower"
	action="<?php echo base_url("grower/$action");?>"
	method="post">
	<p>
		<label for="id">Unique Grower ID: </label><input
			type="text"
			size="3"
			name="id"
			id="grower-id"
			value="<?php echo get_value($grower,"id");?>" /><span id="unique-id"></span>
	</p>
	<p><label for="user_id">Our Contact</label>
	<?php echo form_dropdown("user_id",$users);?>
	</p>
<?php echo implode("\r",$output);?>
<p>
		<input
			type="submit"
			class="button <?php echo $action;?>"
			value="<?php echo ucfirst($action);?>" />
	</p>
</form>
<p class="highlight">More features to come!</p>