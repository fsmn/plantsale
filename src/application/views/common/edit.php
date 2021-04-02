<?php defined('BASEPATH') or exit('No direct script access allowed');
$lights = [];

if (get_value($common, 'sunlight', FALSE)) {
	$lights = explode(',', get_value($common, 'sunlight'));
}

$sunlight = create_checkbox('sunlight[]', $sunlight, $lights);
?>

<form name="edit-common" id="edit-common" action="<?php print site_url('common/' . $action); ?>" method="POST">
	<input type="hidden" name="id" id="common_id" value="<?php print get_value($common, 'id'); ?>" />
	<p><?php print create_input($common, 'name', 'Name', 'name', NULL, TRUE); ?></p>

	<p><?php print create_input($common, 'genus', 'Genus', NULL, NULL, TRUE); ?></p>
	<p>
		<label for="category_id">Category: </label>
		<?php print form_dropdown('category_id', $categories, $common->category_id, 'id="category_id" required'); ?>
	</p>
	<p><label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope">
		<?php print form_dropdown('subcategory_id', $subcategories, $common->subcategory_id, 'id="subcategory_id"'); ?></span>
	</p>
	<p>
		<?php print $sunlight; ?>
	</p>
	<p><label for="description">Description:</label><br />
		<textarea name="description" id="description"><?php print get_value($common, 'description'); ?></textarea>
	</p>
	<p><input type="submit" value="<?php print ucfirst($action); ?>" class="button <?php print $action; ?>" /></p>
</form>