<?php
	$buttons[] = [
		'text' => 'New Category',
		'class' => [
			'new',
			'button',
			'dialog',
			'create'
		], 'style' => 'new',
		'href' => site_url('category/create')
	];
	print create_button_bar($buttons);
?>

<ul class="field-list list">
	<?php foreach ($categories as $category) : ?>
		<li class="list-item">
			<?php print live_field('category', $category->category, 'category', $category->id, [
				'size' => '200',
				'envelope' => 'span'
			]); ?>
			<?php print create_button([
				'text' => 'Add Subcategory',
				'class' => 'new button dialog create small',
				'href' => site_url('subcategory/create/' . $category->id)
			]); ?>
			<?php if (!empty($category->subcategories)) : ?>
				<ul class="field-list list child">
					<?php foreach ($category->subcategories as $subcategory) : ?>
						<li class="list-item">
							<?php print live_field('subcategory', $subcategory->subcategory, 'subcategory', $subcategory->id, [
								'size' => "auto",
								'envelope' => 'span'
							]); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>