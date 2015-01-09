<?php defined('BASEPATH') OR exit('No direct script access allowed');

// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com

?>

<h2><?=$title;?></h2>
<?=edit_field("grower_name", $grower->grower_name, "Grower Name","grower",$grower->id);?>
<?=edit_field("street_address", $grower->street_address, "Street Address","grower",$grower->id);?>
<?=edit_field("po_box", $grower->po_box, "PO Box","grower",$grower->id);?>
<?=edit_field("city", $grower->city, "City","grower",$grower->id);?>
<?=edit_field("state", $grower->state, "State/Province","grower",$grower->id);?>
<?=edit_field("zip", $grower->zip, "Postal Code","grower",$grower->id);?>
<?=edit_field("website", $grower->website, "Website","grower",$grower->id);?>
<?=edit_field("email", $grower->email, "Email","grower",$grower->id,array("class"=>"email"));?>
<?=edit_field("phone", $grower->phone, "Phone","grower",$grower->id);?>
<?=edit_field("fax", $grower->fax, "Fax","grower",$grower->id);?>
<?=edit_field("shipping_notes", $grower->shipping_notes, "Shipping Notes","grower",$grower->id,array("class"=>"textarea","envelope"=>"div", "field-wrapper"=>"div"));?>



<p class="highlight">More features to come!</p>