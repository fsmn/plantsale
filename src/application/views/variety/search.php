<?php

defined('BASEPATH') or exit ('No direct script access allowed');
$refine = $this->input->get("refine");
$sunlight = create_checkbox("sunlight[]", $sunlight, $refine ? explode(",", cookie("sunlight")) : []);

$actions = [
		'full' => 'List',
		'history' => 'Variety History',
		'flags' => 'Flag Listing',
		'reorders' => 'Reorders Search',
		'edits' => 'Copy Edits',
		'printable-copy' => 'Printable Copy',
];

?>
<script>
	$(function () {
		let availableTags = [
			<?php printf("'%s'", implode("','", $pot_sizes));?>
		];
		$("#tags").autocomplete({
			source: availableTags
		});
	});
	$("span[title]").tooltip();
</script>
<div class="message standard" style="max-width: 500px;">Enter "NULL" (with no
	spaces) in any field to find records with no entry in that field. Enter
	"NOT NULL" to find items where that field is not empty.
</div>
<form name="search-variety" id="search-variety" class="search-form"
	  action="<?php print site_url('variety/search'); ?>" method="GET">
	<input type="hidden" name="find" value="1"/>
	<div class="field-set">
		<label for="action">Search Type: </label>
		<?php print form_dropdown('action', $actions, $refine ? cookie('action') : '', 'id="action"'); ?>
	</div>
	<div class="field-set block">
		<label for="year" class="reorders">Year: </label>
		<input type="number" name="year" class="reorders" style="width: 5em"
			   value="<?php print $this->session->userdata('sale_year');; ?>"/>
		&nbsp; <label for="new_year" class="standard">First Year at
			Sale:&nbsp;</label>
		<input type="number" class="standard" style="width: 5em"
			   value="<?php print get_value($variety, 'new_year', ($refine ? cookie('new_year') : '')); ?>"
			   name="new_year"
			   id="new_year"
		/>

		<label for="churn_value" class="standard">Churn Value</label>
		<?php print form_dropdown('churn_value', [
				0 => "",
				2 => 2,
				3 => 3,
		], "", 'class="standard"'); ?>

	</div>
	<div class="field-set box standard" style="font-size: .9em">
		<input type="checkbox" name="crop_failure" value="1"/>
		<label for="crop_failure">Show Only Crop Failures</label> &nbsp;
		<input type="checkbox" name="no_image"
			   id="no_image" <?php print $refine && cookie('no_image') == 1 ? 'checked' : ''; ?>
			   value="1"/>
		<label for="no_image">Missing Image</label> &nbsp;
		<input type="checkbox" name="needs_bag"
			   id="needs_bag" <?php print $refine && cookie('needs_bag') == 1 ? 'checked' : ''; ?>
			   value="1"/>
		<label for="no_image">Needs Bag</label>
	</div>
	<div class="field-set standard">
		<div class="column first">
			<?php print create_input($variety, 'name', 'Common Name', 'name', $refine); ?>
		</div>
		<div class="column last">
			<?php print create_input($variety, 'variety', 'Variety', 'variety', $refine); ?>
		</div>
	</div>
	<div class="field-set standard">
		<div class="column first">
			<?php print create_input($variety, 'genus', 'Genus', 'genus', $refine); ?>
		</div>
		<div class="column last">
			<?php print create_input($variety, 'species', 'Species', 'species', $refine); ?>
		</div>
	</div>
	<div class="field-set block standard">
		<div class="column first">
			<label for="category_id">Category: </label><?php print form_dropdown('category_id', $categories, ($refine ? cookie('category_id') : ""), 'id="category_id"'); ?>
		</div>
		<div class="column last">
			<label for="subcategory_id">Subcategory: </label>
			<span id="subcategory-envelope"><?php print form_dropdown('subcategory_id', $subcategories, ($refine ? cookie('subcategory_id') : ""), 'id="subcategory_id"'); ?></span>

		</div>
	</div>
	<div class="field-set standard">
		<div class="column first">
			<label for="flag">Flag: </label>
			<?php print form_dropdown('flag', $flags, [$refine ? cookie('flag') : ''], 'id="flag"'); ?>
			<br/>
			<input type="checkbox" name="not_flag" style="width: auto;" value=1
				   id="not_flag" <?php print cookie('not_flag') ? 'checked' : ''; ?>
				   title="Check here if you want to find everything that is not the flag value"
			>
			<label class='inline'>Negate</label>

		</div>
		<div class="column last">
			<label for="plant_color">Plant Color: </label>
			<?php print form_dropdown('plant_color', $plant_colors, [$refine ? cookie('plant_color') : ''], 'id="plant_colors"'); ?>
		</div>
	</div>
	<div class="field-set ui-widget standard">
		<div class="column first">
			<?php $pot_size = $refine ? cookie('pot_size') : ''; ?>
			<label for="pot_size">Pot Size Contains</label>
			<input type="text" name="pot_size" id="tags"
				   value="<?php print $pot_size; ?>"/>
		</div>
		<div class="column second">
			<label for="flat_size">Flat Size</label>
			<input type="text" name="flat_size" id="flat_size"
				   value="<?php print $refine ? cookie('flat_size') : ""; ?>"/>
		</div>
	</div>
	<div class="field-set block box standard">
		<label for="sunlight-boolean">Sunlight Options</label>
		&nbsp;<?php print $sunlight; ?>
		&nbsp; <?php print form_dropdown('sunlight-boolean', [
				'and' => 'and',
				'or' => 'or',
				'only' => 'only',
		], $refine ? cookie('sunlight-boolean') : 'and', 'id="sunlight-boolean"'); ?>

	</div>
	<div class="field-set block standard">
		<div class="column first">
			<label>Needs Copy</label>
			<?php print form_dropdown('needs_copy_review', [
					'0' => '',
					'no' => 'No',
					'yes' => 'Yes',
			], $refine ? cookie('needs_copy_review') : ''); ?>
		</div>
		<div class="column last">
			<?php print create_input($variety, 'descriptions', 'Search All Descriptions'); ?>
		</div>
	</div>
	<div class="field-set block standard">
		<div class="column first">
			<?php print create_input($variety, 'description', 'General Description'); ?>
		</div>
		<div class="column last">
			<?php print create_input($variety, 'print_description', 'Variety Description', 'print_description', $refine); ?>
			<?php print create_input($variety, 'web_description', 'Web Description', 'web_description', $refine); ?>
		</div>
	</div>
	<div class="field-set block standard">
		<div class="column first">
			<?php print create_input($variety, 'grower_id', 'Grower ID', 'grower_id', $refine); ?>
		</div>
		<div class="column last">
			<?php print create_input($variety, 'catalog_number', 'Catalog Number', 'catalog_number', $refine); ?>

		</div>
	</div>
	<div></div>
	<div class="field-set block box standard copy-edits" id="copy-edit-section"
		 style="display: none;">
		<div class="column first">
			<?php print create_input($variety, 'copywriter', 'Copywriter', 'copywriter', $refine); ?>
		</div>
		<div class="column last">
			<label for="copy_received">Copy Received?</label>
			<?php print form_dropdown('copy_received', [
					'0' => '',
					'no' => 'No',
					'yes' => 'Yes',
			], $refine ? cookie('copy_received') : ''); ?>
			<?php print create_input($variety, 'edit_notes', 'Notes', 'edit_notes', $refine); ?>
		</div>
	</div>
	<div id="sort-block" class="standard">
		<?php
		$data ["basic_sort"] = TRUE;
		$this->load->view('order/sort', $data);
		?>
	</div>
	<?php

	$buttons [] = [
			'type' => 'pass-through',
			'text' => '<input type="submit" value="Find" class="button"/>',
	];
	$buttons [] = [
			'type' => 'pass-through',
			'text' => '<input type="reset" value="Reset" class="button delete"/>',
	];
	print create_button_bar($buttons); ?>

</form>
<script type="text/javascript">
	$(document).on("change", "#search-variety #action", this, function (event) {
		adjust_form($(this));
	});
	adjust_form($("#search-variety #action"));

	function adjust_form(me) {
		if (me.val() == "edits") {
			$(".standard").show();
			$("#copy-edit-section").show();
		} else if ($(me).val() == "reorders") {
			$(".standard").hide();
			$("#copy-edit-section").hide();
		} else {
			$(".standard").show();
			$("#copy-edit-section").hide();
		}
	}
</script>
