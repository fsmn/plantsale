<?php defined('BASEPATH') or exit('No direct script access allowed');

$this->load->view("variety/list/header");
$i = 1;
$buttons[] = [
		"text" => "Print Posters",
		"class" => ["button", "print", "print-poster-batch"],
		"style" => "print",
];
if (IS_ADMIN) {
	$buttons[] = [
			'text' => 'Batch Flag Update',
			'title' => 'Batch update flags for the listed items',
			'class' => ['button', 'batch-update-variety', 'edit'],
			'style' => 'print',
			'data_values' => [
					'field' => 'flag',
			],
			'href' => $_SERVER['HTTP_REFERER'],
	];
}
/*$buttons[] = [
		'text' => 'Export Copy Edit List',
		'title' => 'Export selected records for copy editing workflow',
		'class' => ['button', 'export', 'export-copy-edit-list'],
		'href' => htmlspecialchars($_SERVER['HTTP_REFERER']) . '&export=true&export_type=copy_edits',
];*/
if (!empty($plants)):
	print create_button_bar($buttons);
	?>

	<h4>Click on a plant to view details. Press "tab" or "shift-tab" to move up
		and
		down the list. Check items you do NOT want to print.</h4>

	<div id="plant-box" class="column">
		<table class="list">
			<thead>
			<tr>
				<th></th>
				<th>Year</th>
				<th>Cat Num</th>
				<th>Latin Name</th>
				<th>Commmon Name</th>
				<th>Variety</th>
				<!-- <th>Pot Size</th>  -->
			</tr>
			</thead>
			<tbody>
			<?php foreach ($plants as $plant): ?>
				<?php $checked = ""; ?>
				<?php $class = "print"; ?>
				<?php if ($plant->omit == 1): ?>
					<?php $checked = "checked"; ?>
					<?php $class = "omitted"; ?>
				<?php endif; ?>
				<tr class="plant-row plant-info inline-list <?php echo $class; ?>"
					tabindex=<?php echo $i; ?> id="plant-info_<?php echo $plant->id; ?>">
					<td class="field omit-plant">
						<?php echo form_checkbox([
								"name" => "omit",
								"value" => 1,
								"title" => "Omit this plant from printing",
								"id" => "omit-plant_$plant->id",
								"checked" => $checked,
								"class" => "omit-row omit plant-info",
						]); ?></td>
					<td class="field year"><?php echo $plant->year; ?></td>
					<td><?php echo get_value($plant, "catalog_number"); ?></td>
					<td class="field latin-name"><?php echo format_latin_name($plant); ?></td>
					<td class="field common-name"><?php echo $plant->name; ?></td>
					<td class="field variety"><?php echo $plant->variety; ?></td>
					<!-- <td class="field pot-size"><?php echo $plant->pot_size; ?></td> -->
				</tr>
				<?php $i++; ?>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div id="plant-details" class="column float">
	</div>

<?php else: ?>
	<p>No plants matched your search parameters.</p>
<?php endif;
