<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

?>
<div class="categories-list">
<h5>Click on a category or subcategory to download the quark export for the current year.</h5>
<?=create_button(array("text"=>"Hide","class"=>"button hide-quark-export small","href"=>"#"));?>

	<ul class="categories list">
	<li class="category item"><a class="export" href="<?=site_url("index/quark");?>">All Categories <i class='fa fa-download'></i></a></li>
<? foreach($categories as $category): ?>
<li class="category item"><a class="export"
			href="<?=site_url("index/quark?category_id=$category->id");?>"
			title="Download all <?=$category->category;?>">
<?=$category->category;?> <i class='fa fa-download'></i>
</a></li>
<? if(!empty($category->subcategories)): ?>
<li>
<ul class="subcategories list">
<? foreach($category->subcategories as $subcategory): ?>
<li class="subcategory item"><a class="export"
				href="<?=site_url("index/quark?category_id=$category->id&subcategory_id=$subcategory->id");?>"
				title="Download ONLY <?=$subcategory->subcategory;?>">
<?=$subcategory->subcategory;?> <i class='fa fa-download'></i>
</a></li>
<? endforeach; ?>
</ul>
</li>
<? endif; ?>
<?endforeach; ?>
</ul>
</div>
