<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$refine = $this->input->get ( "refine" );
?>
<form name="search-variety" id="search-variety" class="search-form" action="<?=site_url("variety/search?action=edits"); ?>" method="GET">
	<input type="hidden" name="find" value="1" />
	<input type="hidden" name="action" value="edits"/>
	<input type="hidden" name="type" value="edits"/>
	<div class="field-set block">
		<label for="year">Year: </label>
		<input type="number" name="year" style="width: 5em" value="<?=get_cookie("sale_year");?>" />
		&nbsp; <label for="new_year">First Year at Sale:&nbsp;</label>
		<input type="number" style="width: 5em" value="<?=get_value($variety,"new_year",($refine ? get_cookie("new_year"):''));?>" name="new_year"
			id="new_year"
		/>
	</div>
	<div class="field-set" style="font-size: .9em">
		<input type="checkbox" name="no_image" id="no_image" <?= $refine && get_cookie("needs_bag")== 1?"checked":"";?> value="1" />
		<label for="no_image">Missing Image</label> &nbsp;
	</div>
	
	<div class="field-set block">
		<div class="column first">
			<label for="category_id">Category: </label><?=form_dropdown("category_id",$categories,($refine ? get_cookie("category_id"):""),'id="category_id"');?>
		</div>
		<div class="column last">
			<label for="subcategory_id">Subcategory: </label>
			<span id="subcategory-envelope"><?=form_dropdown("subcategory_id",$subcategories,($refine ? get_cookie("subcategory_id"):""),'id="subcategory_id"');?></span>

		</div>
	</div>
	<div class="field-set block">
		<div class="column first">
						<?=create_input($variety, "descriptions","Search All Descriptions");?>
					<?=create_input($variety, "description","General Description");?>
			
</div>
		<div class="column last">
		<?=create_input($variety, "print_description","Variety Description","print_description",$refine);?>
		<?=create_input($variety, "web_description","Web Description","web_description",$refine);?>
	</div>
	</div>
	<div class="field-set block">
		<div class="column first">
		<label>Needs Copy Review</label>
<?php echo form_dropdown("needs_copy_review",array("0"=>"","no"=>"No","yes"=>"Yes"),$refine ? get_cookie("needs_copy_review"):"");?>
		<label for="editor">Coordinator</label>
		<?php echo form_dropdown("editor",$users,$refine? get_cookie("editor"):"");?>
		<?php echo create_input($variety,"copywriter","Copywriter","copywriter",$refine);?>
	</div>
		<div class="column last">
		<label for="copy_received">Copy Received?</label>
<?php echo form_dropdown("copy_received",array("0"=>"","no"=>"No","yes"=>"Yes"),$refine ? get_cookie("copy_received"):"");?>
		<?=create_input($variety, "edit_notes","Notes","edit_notes",$refine);?>
	</div>
	</div>
	<div id="sort-block">
<?
$data ["basic_sort"] = TRUE;
$this->load->view ( "order/sort", $data );
?>
</div>
<?

$buttons [] = array (
		"type" => "pass-through",
		"text" => "<input type='submit' value='Find' class='button'/>" 
);
$buttons [] = array (
		"type" => "pass-through",
		"text" => "<input type='reset' value='Reset' class='button delete'/>");
 print create_button_bar($buttons); ?>

</form>
