<?php defined('BASEPATH') OR exit('No direct script access allowed');

// catalog_categories.php Chris Dart Feb 18, 2015 9:42:24 AM chrisdart@cerebratorium.com
// list for updating catalog ids by category
?>
<div class="categories-list">
<h5>Click on a category to update catalog numbers for the specific category.</h5>
<?=create_button(array("text"=>"Hide","class"=>"button hide-quark-export small","href"=>"#"));?>

	<ul class="categories list">
	<li class="category item"><a class="edit set-catalog-numbers" href="<?=site_url("order/set_catalog_numbers");?>">All Categories</a></li>
<? foreach($categories as $category): ?>
<li class="category item"><a class="edit set-catalog-numbers"
			href="<?=site_url("order/set_catalog_numbers?category_id=$category->id");?>"
			title="Update Catalog numbers for <?=$category->category;?>">
<?=$category->category;?>
</a></li>
<?endforeach; ?>
</ul>
</div>
