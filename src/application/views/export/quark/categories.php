<?php

defined('BASEPATH') or exit('No direct script access allowed');

?>
<div class="categories-list">
	<h5>Click on a category or subcategory to download the quark export for the
		current year.</h5>
	<?php print create_button([
		'text' => 'Hide',
		'class' => 'button hide-quark-export small',
		'href' => '#',
	]); ?>

	<ul class="categories list">
		<li class="category item"><a class="export" href="<?php print site_url('index/quark'); ?>" target="_blank">All
				Categories <i class="fa fa-download"></i></a></li>
		<?php foreach ($categories as $category) : ?>
			<li class="category item"><a class="export dialog" href="<?php print site_url('index/quark?category_id=' . $category->id); ?>" title="Download all <?php print $category->category; ?>" target="_blank">
					<?php print $category->category; ?> <i class="fa fa-download"></i>
				</a></li>
			<?php if (!empty($category->subcategories)) : ?>
				<li>
					<ul class="subcategories list">
						<?php foreach ($category->subcategories as $subcategory) : ?>
							<li class="subcategory item"><a class="export dialog" href="<?php print site_url('index/quark?category_id=' . $category->id . '& subcategory_id=' . $subcategory->id); ?>" title="Download ONLY <?php print $subcategory->subcategory; ?>" target="_blank">
									<?php print $subcategory->subcategory; ?> <i class='fa fa-download'></i>
								</a></li>
						<?php endforeach; ?>
					</ul>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>