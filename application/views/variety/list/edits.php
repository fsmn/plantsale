<?php
$this->load->view("variety/list/header");
?>
<table class="table list">
	<thead>
		<tr>
			<th>Year</th>
			<th>Common</th>
			<th>Variety</th>
			<th>Latin Name</th>
			<th>Category</th>
			<th>Subcategory</th>
			<th>Grower</th>
			<th>Is New</th>
			<th>Coordinator</th>
			<th>Copywriter</th>
			<th>Copy Received</th>
			<th>News Copy Review</th>
			<th>Notes</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($plants as $plant):?>
<tr>
			<td>
<?php echo $plant->year;?>
</td>
			<td>
<?php echo $plant->name;?>
</td>
			<td>
			<a href="<?php echo base_url("variety/view/$plant->id");?>"/>
<?php echo $plant->variety;?>
</a>
</td>
			<td>
<?php echo format_latin_name($plant->genus, $plant->species);?>
</td>
<td>
<?php echo $plant->category; ?>
</td>
<td>
<?php echo $plant->subcategory;?>
</td>
<td>
<?php echo $plant->grower_id;?>
</td>
<td>
<?php echo $plant->year == $plant->new_year?"New":"";?>
</td>
<td>
<div class="field-envelope" id="variety__editor__<?php echo $plant->id;?>">
		<span class="user-dropdown live-field text" menu="boolean" name="boolean">
<?php echo form_dropdown("editor",$users,get_value($plant,"editor"),"class='live-field'");?>
</span>
	</div>
</td>
<td>
<?php echo live_field("copywriter",$plant->copywriter,"variety",$plant->id,array("envelope"=>"span","size"=>"63"));?>

</td>
<td>
<div class="field-envelope" id="variety__copy_received__<?php echo $plant->id;?>">
		<span class="dropdown live-field text" menu="boolean" name="boolean">
<?php echo form_dropdown("copy_received",array("0"=>"","no"=>"No","yes"=>"Yes"),get_value($plant,"copy_received"),"class='live-field'");?>
</span>
	</div>
</td>
<td>
<div class="field-envelope" id="variety__needs_copy_review__<?php echo $plant->id;?>">
		<span class="dropdown live-field text" menu="boolean" name="boolean">
<?php echo form_dropdown("needs_copy_review",array("0"=>"","no"=>"No","yes"=>"Yes"),get_value($plant,"needs_copy_review"),"class='live-field'");?>
</span>
	</div>
</td>
<td>
<div class='field-set'>
			<?=edit_field("edit_notes", $plant->edit_notes, "","variety",$plant->id, array("envelope"=>"div","size"=>"180"));?>
		</div>

</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>