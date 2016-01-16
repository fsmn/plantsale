<?php defined('BASEPATH') OR exit('No direct script access allowed');

// view.php Chris Dart Jan 8, 2015 5:30:58 PM chrisdart@cerebratorium.com
?>
<h2>Grower: <?=$grower->grower_name !=""?$grower->grower_name:$grower->id;?></h2>

<div class="column left">
<?=edit_field("grower_name", $grower->grower_name, "Grower Name","grower",$grower->id);?>
<?=edit_field("street_address", $grower->street_address, "Street Address","grower",$grower->id);?>
<?=edit_field("po_box", $grower->po_box, "PO Box","grower",$grower->id);?>
<?=edit_field("city", $grower->city, "City","grower",$grower->id);?>
<?=edit_field("state", $grower->state, "State/Province","grower",$grower->id);?>
<?=edit_field("zip", $grower->zip, "Postal Code","grower",$grower->id);?>
<?=edit_field("country", $grower->country, "Country","grower",$grower->id);?>

<?=edit_field("website", $grower->website, "Website","grower",$grower->id);?>
<?=edit_field("email", $grower->email, "Email","grower",$grower->id,array("class"=>"email"));?>
<?=edit_field("phone", $grower->phone, "Phone","grower",$grower->id);?>
<?=edit_field("fax", $grower->fax, "Fax","grower",$grower->id);?>
<label for="user_id">Our Contact</label>

<p class="field-envelope" id="grower__user_id__<?php echo $grower->id;?>">
	<span class="user-dropdown edit-field field" menu="boolean" name="boolean"><?php printf("%s %s",$grower->first_name, $grower->last_name);?></span>
</p>
<?=edit_field("shipping_notes", $grower->shipping_notes, "Shipping Notes","grower",$grower->id,array("class"=>"textarea","envelope"=>"div", "field-wrapper"=>"div"));?>
</div>
<div class="column right last">
<h3>Contacts</h3>
<?=create_button_bar(array(array("text"=>"New Contact","href"=>site_url("contact/create/$grower->id"),"class"=>"button new create-contact mini")));?>
<? foreach($grower->contacts as $contact): ?>
<? $this->load->view("contact/view", array("contact"=>$contact));?>
<? endforeach;?>
</div>