<?php defined('BASEPATH') or exit('No direct script access allowed');

// catalog_categories.php Chris Dart Feb 18, 2015 9:42:24 AM chrisdart@cerebratorium.com
// list for updating catalog ids by category
?>
<div class="categories-list">
	<h5>Click on a category to update catalog numbers for the specific category.</h5>
	<?php print create_button([
		'text' => 'Hide',
		'class' => 'button hide-quark-export small',
		'href' => '#'
	]); ?>
	<ul class="categories list">
		<li class="category item">
			<a class="edit set-catalog-numbers" href="<?php print site_url('order/set_catalog_numbers'); ?>">All Categories</a>
		</li>
		<?php foreach ($categories as $category) : ?>
			<li class="category item">
				<a class="edit set-catalog-numbers" href="<?php print site_url("order/set_catalog_numbers?category_id=$category->id"); ?>" title="Update Catalog numbers for <?php print $category->category; ?>">
					<?php print $category->category; ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</div>