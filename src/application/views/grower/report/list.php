<?php defined('BASEPATH') or exit('No direct script access allowed');

// report.php Chris Dart Jan 8, 2015 2:58:21 PM chrisdart@cerebratorium.com
//$grand_total = 0;
?>
<h1>Grower Totals, <?php print $year; ?></h1>
<?php
$buttons[] = [
	'text' => 'Filter',
	'class' => ['button', 'dialog', 'search'],
	'style' => 'default',
	'title' => 'Filter by year',
	'href' => base_url('grower/filter'),
];
$buttons[] = [
	'text' => 'Export',
	'class' => ['button', 'export'],
	'style' => 'export',
	'title' => 'Export as Spreadsheet',
	'href' => $_SERVER['REQUEST_URI'] . '?export=true',
]; ?>
<?php if (isset($orphan_count) && $orphan_count > 0) {
	$verb = $orphan_count == 1 ? 'is' : 'are';
	$plural = $orphan_count > 1 ? 's' : '';
	$buttons[] = [
		'text' => "Show $orphan_count Orphan Grower$plural <span class='badge'>$orphan_count</span>",
		'title' => "There $verb $orphan_count grower$plural with no grower record. Click here to fix this.",
		'class' => ['button'],
		'style' => 'default',
		'href' => site_url('grower/show_orphans'),
	];
}

print create_button_bar($buttons);
?>
<table class="list">
	<thead>
		<tr>
			<th>
				ID
			</th>
			<th>
				Name
			</th>
			<th>
				Email/Phone
			</th>
			<th>
				Address
			</th>
			<th>
				Our Contact
			</th>
			<th>
				Totals for <?php print $year; ?>
			</th>
			<th class="no-print">
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		print implode('\r', $growers); ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="5" style="text-align: right;">
				<?php print get_as_price($grand_total); ?>
			</th>
			<th>
			</th>
		</tr>
	</tfoot>
</table>
