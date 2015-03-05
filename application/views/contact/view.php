<?php

defined('BASEPATH') or exit('No direct script access allowed');

// view.php Chris Dart Mar 5, 2015 2:26:16 PM chrisdart@cerebratorium.com
?>
<div class="contact-info block">
	<p><?=create_button(array("text"=>"Edit","href"=>site_url("contact/edit/$contact->id"),"class"=>array("button","small","edit","edit-contact")));?><label>&nbsp;Name: </label><?=$contact->name;?>
	</p>
	<p><label>Type: </label><?=ucfirst($contact->contact_type);?></p>
	<p><label>Phone 1: </label><?=ucfirst(get_value($contact,"phone1_type","Main"));?>&nbsp;<?=$contact->phone1;?></p>
	<p><label>Phone 2: </label><?=ucfirst(get_value($contact,"phone2_type","Main"));?>&nbsp;<?=$contact->phone2;?></p>
	<p><label>Email: </label><?=get_value($contact,"email","");?></p>
	<p><label>Notes: </label><?=get_value($contact,"notes");?></p>

</div>