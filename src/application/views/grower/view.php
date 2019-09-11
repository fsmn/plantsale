<?php defined('BASEPATH') OR exit('No direct script access allowed');

// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com
?>
<h2>Grower: <?php echo $grower->grower_name !=""?$grower->grower_name:$grower->id;?></h2>

<div class="column left">
<?php echo edit_field("grower_name", $grower->grower_name, "Grower Name","grower",$grower->id);?>
<?php echo edit_field("street_address", $grower->street_address, "Street Address","grower",$grower->id);?>
<?php echo edit_field("po_box", $grower->po_box, "PO Box","grower",$grower->id);?>
<?php echo edit_field("city", $grower->city, "City","grower",$grower->id);?>
<?php echo edit_field("state", $grower->state, "State/Province","grower",$grower->id);?>
<?php echo edit_field("zip", $grower->zip, "Postal Code","grower",$grower->id);?>
<?php echo edit_field("country", $grower->country, "Country","grower",$grower->id);?>

<?php echo edit_field("website", $grower->website, "Website","grower",$grower->id);?>
<?php echo edit_field("email", $grower->email, "Email","grower",$grower->id,array("class"=>"email"));?>
<?php echo edit_field("phone", $grower->phone, "Phone","grower",$grower->id);?>
<?php echo edit_field("fax", $grower->fax, "Fax","grower",$grower->id);?>
<label for="user_id">Our Contact</label>

<p class="field-envelope" id="grower__user_id__<?php echo $grower->id;?>">
	<span class="user-dropdown edit-field field" menu="boolean" name="boolean"><?php printf("%s %s",$grower->first_name, $grower->last_name);?></span>
</p>
<?php echo edit_field("shipping_notes", $grower->shipping_notes, "Shipping Notes","grower",$grower->id,array("class"=>"textarea","envelope"=>"div", "field-wrapper"=>"div"));?>
</div>
<div class="column right last">
<h3>Contacts</h3>
<?php echo create_button_bar(array(array("text"=>"New Contact","href"=>site_url("contact/create/$grower->id"),"class"=>"button new create-contact mini")));?>
<?php foreach($grower->contacts as $contact): ?>
<?php $this->load->view("contact/view", array("contact"=>$contact));?>
<?php endforeach;?>
</div>