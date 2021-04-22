<?php defined('BASEPATH') or exit('No direct script access allowed');

// inline_list.php Chris Dart April 25, 2013 11:07:53 AM chrisdart@cerebratorium.com
?>

<table id="common-name-list" class="list compressed">
	<?php if ($full_list) : ?>
		<thead>
			<tr>
				<th>Name</th>

				<th>Genus</th>

				<th>Category</th>

				<th>Sunlight</th>

				<th>Description</th>

				<th></th>
			</tr>
		</thead>
	<?php endif; ?>
	<tbody>
		<?php foreach ($names as $name) : ?>
			<tr>
				<td>
					<span class="common-name common-edit-row" id="cnid_<?php print $name->id; ?>"><?php print $name->name; ?></span>
				</td>
				<td>
					<span class="common-genus common-edit-row" id="cgid_<?php print $name->id; ?>"><?php print $name->genus; ?></span>
				</td>
				<td>
					<span class="common-category common-edit-row" id="ccid_<?php print $name->id; ?>"><?php print $name->category; ?> </span>
				</td>
				<td>
					<?php print create_button([
						'text' => 'Details',
						'class' => [
							'button',
							'details'
						],
						'href' => site_url('common/view/' . $name->id)
					]); ?>
					<a class="button" id="id_<?php print $name->id; ?>" href="<?php print site_url('common/view/' . $name->id); ?>">Details
					<?php print add_fa_icon(["details"]); ?></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>