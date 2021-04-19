<?php defined('BASEPATH') or exit('No direct script access allowed');
$refine = $this->input->get('refine');
$sunlight = create_checkbox('sunlight[]', $sunlight, []);

?>
<form name="search-common" id="search-common" action="<?php print site_url('common/search'); ?>" method="GET">
	<input type="hidden" name="find" value="1" />
	<p>
		<label for="name">Name: </label><input type="text" name="name" id="name" value="<?php print $refine ? cookie('name') : ''; ?>" class="">
	</p>
	<p>
		<label for="genus">Genus: </label><input type="text" name="genus" id="genus" value="<?php print $refine ? cookie('genus') : ''; ?>" class="">
	</p>
	<p>
		<label for="category_id">Category:
		</label><?php print form_dropdown('category_id', $categories, $refine ? cookie('category_id') : '', 'id="category_id"'); ?>
	</p>
	<p>
		<label for="subcategory_id">Subcategory: </label><span id="subcategory-envelope"><?php print form_dropdown('subcategory_id', $subcategories, $refine ? cookie('subcategory_id') : '', 'id="subcategory_id"'); ?></span>
	</p>

	<p>
		<?php print $sunlight; ?>
		<br />
		<?php print form_dropdown('sunlight-boolean', [
			'and' => 'and',
			'or' => 'or',
			'only' => 'only'
		], 'and', "id='sunlight-boolean'"); ?>
	</p>
	<p>
		<label for="description">Description:</label><br />
		<textarea name="description" id="description"><?php print $refine ? cookie('description') : ''; ?></textarea>
	</p>
	<p>
		<label for="year">Year: </label><input type="text" name="year" value="<?php print $refine ? cookie('year') : ''; ?>" />
	</p>
	<p>
		<input type="submit" value="Find" class="button" />
	</p>
</form>