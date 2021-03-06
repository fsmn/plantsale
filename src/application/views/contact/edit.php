<?php
defined('BASEPATH') or exit('No direct script access allowed');

// edit.php Chris Dart Mar 5, 2015 2:26:07 PM chrisdart@cerebratorium.com
$phone_types = array(
        "" => "",
        "main" => "Main",
        "mobile" => "Mobile",
        "fax" => "Fax",
        "work" => "Work",
        "home" => "Home"
);

$contact_types = array(
        ""=>"",
        "shipping" => "Shipping",
        "ordering" => "Ordering"
);

?>
<form
	name="contact-editor"
	id="contact-editor"
	method="post"
	action="<?php echo site_url("contact/$action");?>">
	<input
		type="hidden"
		name="id"
		id="id"
		value="<?php echo get_value($contact,"id","");?>" /> <input
		type="hidden"
		name="grower_id"
		id="grower_id"
		value="<?php echo $action=="update"?$contact->grower_id:$grower_id;?>" />
		<p><label for="contact_type">Contact Type: </label><?php echo form_dropdown("contact_type",$contact_types,get_value($contact,"contact_type"));?></p>
	<p>
		<label for="name">Name: </label><input
			type="text"
			name="name"
			id="name"
			value="<?php echo get_value($contact,"name");?>" />
	</p>
	<p>
		<label for="phone1">Phone 1: </label><input
			type="text"
			name="phone1"
			id="phone1"
			value="<?php echo get_value($contact,"phone1");?>" />
<?php echo form_dropdown("phone1_type",$phone_types,get_value($contact,"phone1_type",""));?>
</p>
	<p>
		<label for="phone2">Phone 1: </label><input
			type="text"
			name="phone2"
			id="phone2"
			value="<?php echo get_value($contact,"phone2");?>" />
<?php echo form_dropdown("phone2_type",$phone_types,get_value($contact,"phone2_type",""));?>
</p>
	<p>
		<label for="email">Email: </label> <input
			name="email"
			type="email"
			id="email"
			value="<?php echo get_value($contact,"email");?>" />
	</p>
	<p><label for="notes">Notes:</label><br/>
	<textarea name="notes" id="notes">
	<?php echo get_value($contact,"notes");?>
	</textarea>
	<p>
		<input
			type="submit"
			class="button <?php echo $action=='update'?"edit":"new"?>"
			value="<?php echo ucfirst($action);?>" />
			<?php if($action == "update"):?>
			<?php echo create_button(array("text"=>"Delete","class"=>"button delete delete-contact","id"=>sprintf("delete-contact_%s",$contact->id)));?>
			<?php endif;?>

</form>