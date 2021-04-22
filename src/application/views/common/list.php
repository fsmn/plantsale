<?php

defined('BASEPATH') or exit('No direct script access allowed');
print $this->input->post('year');
// list.php Chris Dart Feb 27, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>
<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class="search-parameters">
		<?php
		if (!empty($params)) {
			$keys = array_keys($params);
			$values = array_values($params);
			print '<ul>';
			for ($i = 0; $i < count($params); $i++) {
				print '<li>' . ucfirst($keys[$i]) . ': <strong>';
				if (is_array($values[$i])) {
					print implode(', ', $values[$i]);
				} else {
					print $values[$i];
				}
				print '</strong></li>';
			}
			print '</ul>';
		} else {
			print '<p>Showing All Common Names</p>';
		}
		?>
		<p>
			Found Count: <strong><?php print count($names); ?> Records</strong>
		</p>
		<?php print create_button_bar([[
			'text' => 'Refine Search',
			'class' => [
				'button',
				'refine',
				'search',
				'dialog',
				'search-common-names'
			],
			'href' => site_url('common/search?refine=1')
		]]); ?>
	</div>
</fieldset>
<table id="common-name-list" class="list">
	<?php if ($full_list) : ?>
		<thead>
			<tr>
				<th></th>
				<th>Name</th>

				<th>Genus</th>

				<th>Category</th>

				<th>Subcategory</th>

				<th>Sunlight</th>

				<th>Description</th>

			</tr>
		</thead>
	<?php endif; ?>
	<tbody>
		<?php foreach ($names as $name) : ?>
			<tr>
				<td>
					<?php print create_button([
						'text' => 'Details',
						'class' => [
							'button',
							'details'
						], 'href' => site_url('common/view/' . $name->id)
					]); ?>
				</td>
				<td>
					<?php print edit_field('name', $name->name, '', 'common', $name->id, ['envelope' => 'span']); ?>
				</td>
				<td>
					<?php print edit_field('genus', $name->genus, '', 'common', $name->id, ['envelope' => 'span']); ?>
				</td>

				<td>
					<?php print edit_field('category_id', $name->category, '', 'common', $name->id, [
						'envelope' => 'span',
						'class' => 'category-dropdown'
					]); ?>
				</td>
				<td>
					<?php print edit_field('subcategory_id', $name->subcategory, '', 'common', $name->id, [
						'envelope' => 'span',
						'class' => 'subcategory-dropdown'
					]); ?>
				</td>
				<td>
					<?php print edit_field('sunlight', $name->sunlight, '', 'common', $name->id, [
						'envelope' => 'span',
						'class' => 'multiselect',
						'attributes' => 'menu="sunlight"',
						'format' => 'multiselect'
					]); ?>
				</td>
				<td>
					<?php print edit_field('description', $name->description, '', 'common', $name->id, [
						'envelope' => 'span',
						'class' => 'textarea'
					]); ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>