<?php
$this->load->view("variety/list/header");
$buttons[] = [
		"text" => "Printable Copy for " . get_current_year(),
		"class" => ["button"],
		"href" => site_url("variety/show_copy_text"),
];
$buttons[] = [
		"text" => "Export Copy Edit List",
		"title" => "Export selected records for copy editing workflow",
		"class" => ["button", "export", "export-copy-edit-list"],
		"href" => htmlspecialchars($_SERVER['REQUEST_URI']) . "&export=true&export_type=copy_edits&action=full",
];
print create_button_bar($buttons);
?>
<table class="table list">
	<thead>
	<tr>
		<th>Year</th>
		<th>Common</th>
		<th>Variety</th>
		<th>Latin Name</th>
		<th>Category</th>
		<th>Subcategory</th>
		<th>Grower</th>
		<th>Is New</th>
		<th>Copywriter</th>
		<th>Copy Received</th>
		<th>Needs Copy</th>
		<th>Notes</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($plants as $plant): ?>
		<tr>
			<td>
				<?php echo $plant->year; ?>
			</td>
			<td>
				<?php echo $plant->name; ?>
			</td>
			<td>
				<a href="<?php echo base_url("variety/view/$plant->id"); ?>"><?php echo $plant->variety; ?></a>
			</td>
			<td>
				<?php echo format_latin_name($plant); ?>
			</td>
			<td>
				<?php echo $plant->category; ?>
			</td>
			<td>
				<?php echo $plant->subcategory; ?>
			</td>
			<td>
				<?php echo $plant->grower_id; ?>
			</td>
			<td>
				<?php echo $plant->year == $plant->new_year ? "New" : ""; ?>
			</td>
			<td>
				<?php echo live_field('copywriter', $plant->copywriter, 'variety', $plant->id, [
						'type' => 'text',
						'envelope' => 'span',
						'size' => '35',
				]); ?>
			</td>
			<td>
				<?php print live_field('copy_received', $plant->copy_received, 'variety', $plant->id, [
						'type' => 'boolean-dropdown',
						'envelope' => 'span',
				]); ?>
			</td>
			<td>
				<?php print live_field('needs_copy_review', $plant->needs_copy_review, 'variety', $plant->id, [
						'type' => 'boolean-dropdown',
						'envelope' => 'span',
				]); ?>
			</td>
			<td>
				<div class='field-set'>
					<?php echo edit_field("edit_notes", $plant->edit_notes, "", "variety", $plant->id, [
							"envelope" => "div",
							"size" => "180",
					]); ?>
				</div>

			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
