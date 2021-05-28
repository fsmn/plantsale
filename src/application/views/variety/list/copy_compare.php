<?php
$fields = [
		'Common',
		'Latin',
		'Variety',
		'Description',
		'ARCHIVED Description',
		'Web Description',
		'ARCHIVED Variety Description',
		'Variety Description',
		'ARCHIVED Extended Description'
];

?>
<h1>Total Count: <?php print count($plants); ?></h1>
<table class="list table">
	<thead>
	<tr>
		<?php foreach ($fields as $field): ?>
		<th><?php print $field; ?>
			<?php endforeach; ?>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($plants as $plant): ?>
		<tr>
			<td><a href="<?php print base_url('common/view/' . $plant->common_id); ?>"><?php print $plant->name; ?></a></td>
			<td><?php print format_latin_name($plant); ?></td>
			<td><a href="<?php print base_url('variety/view/' . $plant->variety_id); ?>"><?php print $plant->variety; ?></a>
			</td>
			<td>
				<span class="field-envelope" id="common__description__<?php print $plant->common_id; ?>">
				<span class="textarea live-field text" name="description">
					<textarea name="description" cols="40" rows="10" id="description_<?php print $plant->common_id; ?>"
							  size="127" type="textarea"
							  category=""><?php print get_value($plant, 'description'); ?></textarea>
				</span>
				</span>
			</td>
			<td>
				<?php print $plant->old_description; ?>
			</td>
			<td><span class="field-envelope" id="variety__web_description__<?php print $plant->variety_id ?>">
				<span class="textarea live-field text" name="web_description">
					<textarea name="web_description" cols="40" rows="10"
							  id="web-description_<?php print $plant->variety_id; ?>" size="5" type="textarea"
							  category=""><?php print get_value($plant, 'web_description'); ?></textarea>
				</span>
			</span>
			</td>
			<td>
				<?php print $plant->old_print_description; ?>
			</td>
			<td>
				<span class="field-envelope" id="variety__print_description__<?php print $plant->variety_id ?>">
				<span class="textarea live-field text" name="print_description">
					<textarea name="print_description" cols="40" rows="10"
							  id="print-description_<?php print $plant->variety_id; ?>" size="5" type="textarea"
							  category=""><?php print get_value($plant, 'print_description'); ?></textarea>
				</span>
			</span>
			</td>
			<td>
				<?php print $plant->extended_description; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
