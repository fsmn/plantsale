<?php

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

?>
<div class="categories-list">
<h5>Click on a category or subcategory to download the quark export for the current year.</h5>
	<ul class="categories list">
<? foreach($categories as $category): ?>
<li class="category item"><a class="export"
			href="<?=site_url("index/quark?category_id=$category->id");?>"
			title="Download all <?=$category->category;?>">
<?=$category->category;?> <i class='fa fa-cloud-download'></i>
</a></li>
<? if(!empty($category->subcategories)): ?>
<ul class="subcategories list">
<? foreach($category->subcategories as $subcategory): ?>
<li class="subcategory item"><a class="export"
				href="<?=site_url("index/quark?category_id=$category->id&subcategory_id=$subcategory->id");?>"
				title="Download ONLY <?=$subcategory->subcategory;?>">
<?=$subcategory->subcategory;?> <i class='fa fa-cloud-download'></i>
</a></li>
<? endforeach; ?>
</ul>
<? endif; ?>
<?endforeach; ?>
</ul>
</div>
