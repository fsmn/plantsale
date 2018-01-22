<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$refine = $this->input->get ( "refine" );
?>
<form name="search-variety" id="search-variety" class="search-form" action="<?php echo site_url("variety/search?action=edits"); ?>" method="GET">
	<input type="hidden" name="find" value="1" />
	<input type="hidden" name="action" value="edits"/>
	<input type="hidden" name="type" value="edits"/>
	<div class="field-set block">
		<label for="year">Year: </label>
		<input type="number" name="year" style="width: 5em" value="<?php echo $this->session->userdata("sale_year");;?>" />
		&nbsp; <label for="new_year">First Year at Sale:&nbsp;</label>
		<input type="number" style="width: 5em" value="<?php echo get_value($variety,"new_year",($refine ? cookie("new_year"):''));?>" name="new_year"
			id="new_year"
		/>
	</div>
	<div class="field-set block">
		<div class="column first">
			<label for="name">Common Name</label>
			<input type="text" name="name" id="common_name" value ="<?php echo $refine ? cookie("name"):"";?>"/>
		</div>
	<div class="column last">
		<?php echo create_input($variety,"genus","Genus","genus",$refine);?>
	</div>
</div>
	<div class="field-set" style="font-size: .9em">
		<input type="checkbox" name="no_image" id="no_image" <?php echo  $refine && cookie("needs_bag")== 1?"checked":"";?> value="1" />
		<label for="no_image">Missing Image</label> &nbsp;
	</div>

	<div class="field-set block">
		<div class="column first">
			<label for="category_id">Category: </label><?php echo form_dropdown("category_id",$categories,($refine ? cookie("category_id"):""),'id="category_id"');?>
		</div>
		<div class="column last">
			<label for="subcategory_id">Subcategory: </label>
			<span id="subcategory-envelope"><?php echo form_dropdown("subcategory_id",$subcategories,($refine ? cookie("subcategory_id"):""),'id="subcategory_id"');?></span>

		</div>
	</div>
	<div class="field-set block">
		<div class="column first">
						<?php echo create_input($variety, "descriptions","Search All Descriptions");?>
					<?php echo create_input($variety, "description","General Description");?>

</div>
		<div class="column last">
		<?php echo create_input($variety, "print_description","Variety Description","print_description",$refine);?>
		<?php echo create_input($variety, "web_description","Web Description","web_description",$refine);?>
	</div>
	</div>
	<div class="field-set ui-widget">
	<?php $pot_size = $refine ? cookie("pot_size"):"";?>
	<label for="pot_size">Pot Size Contains</label>
	<input type="text" name="pot_size" id="tags" value="<?php echo $pot_size;?>" />
	</div>
	<div class="field-set block">
		<div class="column first">
		<label>Needs Copy</label>
<?php echo form_dropdown("needs_copy_review",array("0"=>"","no"=>"No","yes"=>"Yes"),$refine ? cookie("needs_copy_review"):"");?>
		<label for="editor">Coordinator</label>
		<?php echo form_dropdown("editor",$users,$refine? cookie("editor"):"");?>
		<?php echo create_input($variety,"copywriter","Copywriter","copywriter",$refine);?>
	</div>
		<div class="column last">
		<label for="copy_received">Copy Received?</label>
<?php echo form_dropdown("copy_received",array("0"=>"","no"=>"No","yes"=>"Yes"),$refine ? cookie("copy_received"):"");?>
		<?php echo create_input($variety, "edit_notes","Notes","edit_notes",$refine);?>
	</div>
	</div>
	<div id="sort-block">
<?php
$data ["basic_sort"] = TRUE;
$this->load->view ( "order/sort", $data );
?>
</div>
<?php

$buttons [] = array (
		"type" => "pass-through",
		"text" => "<input type='submit' value='Find' class='button'/>"
);
$buttons [] = array (
		"type" => "pass-through",
		"text" => "<input type='reset' value='Reset' class='button delete'/>");
 print create_button_bar($buttons); ?>

</form>
