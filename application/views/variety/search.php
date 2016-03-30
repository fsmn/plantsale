<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
$refine = $this->input->get ( "refine" );
$sunlight = create_checkbox ( "sunlight[]", $sunlight, $refine ? explode ( ",", cookie ( "sunlight" ) ) : array () );
?>
<script>
  $(function() {
    var availableTags = [
     <?php printf("'%s'", implode("','",$pot_sizes));?>
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
  </script>

<div class="message" style="max-width: 500px;">Enter "NULL" (with no spaces) in any field to find records with no entry in that field. Enter
	"NOT NULL" to find items where that field is not empty.</div>
<form name="search-variety" id="search-variety" class="search-form" action="<?=site_url("variety/search"); ?>" method="GET">
	<input type="hidden" name="find" value="1" />
	<div class="field-set">
		<label for="action[]">List </label>
		<input type="radio" name="action[]" value="full" checked />
		&nbsp; <label for="action[]">Variety History</label>
		<input type="radio" name="action[]" value="history" />
		&nbsp; <label for="action[]">Flag Listing</label>
		<input type="radio" name="action[]" value="flags" />
	</div>
	<div class="field-set block">
		<label for="year">Year: </label>
		<input type="number" name="year" style="width: 5em" value="<?=$this->session->userdata("sale_year");;?>" />
		&nbsp; <label for="new_year">First Year at Sale:&nbsp;</label>
		<input type="number" style="width: 5em" value="<?=get_value($variety,"new_year",($refine ? cookie("new_year"):''));?>" name="new_year"
			id="new_year"
		/>
	</div>
	<div class="field-set box" style="font-size: .9em">
		<input type="checkbox" name="crop_failure" value="1" />
		<label for="crop_failure">Show Only Crop Failures</label> &nbsp;
		<input type="checkbox" name="no_image" id="no_image" <?= $refine && cookie("needs_bag")== 1?"checked":"";?> value="1" />
		<label for="no_image">Missing Image</label> &nbsp;
		<input type="checkbox" name="needs_bag" id="needs_bag" <?=$refine && cookie("needs_bag") == 1 ?"checked":"";?> value="1" />
		<label for="no_image">Needs Bag</label>
	</div>
	<div class="field-set">
		<div class="column first">
		<?=create_input($variety,"name","Common Name","name", $refine);?>
	</div>
		<div class="column last">
		<?=create_input($variety,"variety","Variety","variety",$refine);?>
	</div>
	</div>
	<div class="field-set">
		<div class="column first">
		<?=create_input($variety,"genus","Genus","genus",$refine);?>
	</div>
		<div class="column last">
		<?=create_input($variety, "species","Species","species",$refine);?>
	</div>
	</div>
	<div class="field-set block">
		<div class="column first">
			<label for="category_id">Category: </label><?=form_dropdown("category_id",$categories,($refine ? cookie("category_id"):""),'id="category_id"');?>
		</div>
		<div class="column last">
			<label for="subcategory_id">Subcategory: </label>
			<span id="subcategory-envelope"><?=form_dropdown("subcategory_id",$subcategories,($refine ? cookie("subcategory_id"):""),'id="subcategory_id"');?></span>

		</div>
	</div>
	<div class="field-set">
		<div class="column first">
			<label for="flag">Flag: </label>
		<?=form_dropdown("flag",$flags,array($refine ? cookie("flag"):''),"id='flag'");?>
		<br />
			<input type="checkbox" name="not_flag" style="width: auto;" value=1 id="not_flag" <?=cookie("not_flag") ? "checked":"";?>
				title="Check here if you want to find everything that is not the flag value"
			>
			<strong>Negate</strong>

		</div>
		<div class="column last">
			<label for="plant_color">Plant Color: </label>
		<?=form_dropdown("plant_color",$plant_colors,array($refine ? cookie("plant_color") : ""),"id='plant_colors'");?>
	</div>
	</div>
	<div class="field-set ui-widget">
	<?php $pot_size = $refine ? cookie("pot_size"):"";?>
	<label for="pot_size">Pot Size Contains</label>
	<input type="text" name="pot_size" id="tags" value="<?php echo $pot_size;?>" />
	</div>
	<div class="field-set block box">
		<label for="sunlight-boolean">Sunlight Options</label>
&nbsp;<?=$sunlight;?>	&nbsp;	<?=form_dropdown("sunlight-boolean",array("and"=>"and","or"=>"or","only"=>"only"),$refine ? cookie("sunlight-boolean"):"and","id='sunlight-boolean'");?>

	</div>
	<div class="field-set block">
		<div class="column first">
			<label>Needs Copy</label>
<?php echo form_dropdown("needs_copy_review",array("0"=>"","no"=>"No","yes"=>"Yes"),$refine ? cookie("needs_copy_review"):"");?>
</div>
		<div class="column last">
			<?=create_input($variety, "descriptions","Search All Descriptions");?>
			</div>
	</div>
	<div class="field-set block">
		<div class="column first">
		<?=create_input($variety, "description","General Description");?>
	</div>
		<div class="column last">
		<?=create_input($variety, "print_description","Variety Description","print_description",$refine);?>
		<?=create_input($variety, "web_description","Web Description","web_description",$refine);?>
	</div>
	</div>
	<div class="field-set block">
		<div class="column first">
	<?=create_input($variety,"grower_id","Grower ID","grower_id",$refine);?>
	</div>
		<div class="column last">
		<?=create_input($variety,"catalog_number","Catalog Number","catalog_number",$refine);?>

	</div>
	</div>
	<div></div>
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
