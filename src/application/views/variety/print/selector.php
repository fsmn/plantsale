<?php

defined('BASEPATH') or exit('No direct script access allowed');

// selector.php Chris Dart Mar 16, 2015 2:21:28 PM chrisdart@cerebratorium.com


$formats = array(
        "tabloid" => "Tabloid (12 x 18)",
        "statement" => "Statement (5.5 x 8.5)",
        "letter" => "Letter (8.5 x 11)",
        "shovel_foot" => "Shovel Foot (7 x 11)",
		"seed_packet" => "Seed Packet (6.5 x 4.5)",
)
;
?>
<form
	id="print_posters"
	name="print_posters"
	action="<?php echo site_url("variety/print_result");?>"
	method="post">
	<input
		type="hidden"
		name="ids"
		id="ids"
		value="<?php echo $ids;?>" />
<p>
		<label for="format">Format</label>
		<?php echo form_dropdown("format",$formats);?>
		</p>
		<p>
		<input type="submit" class="button" value="Create"/>
		</p>

</form>