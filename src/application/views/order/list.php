<?php
defined('BASEPATH') or exit('No direct script access allowed');

// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders) :

	$top_row = [
			NULL,
			NULL,
			NULL,
			NULL,
			NULL,
			[
					'colspan' => 3,
					'label' => 'Sizes',
			],
			[
					'colspan' => 2,
					'label' => 'Prices',
			],
			[
					'colspan' => 2,
					'label' => 'Presale',
			],
			[
					'colspan' => 2,
					'label' => 'Friday',
			],
			[
					'colspan' => 2,
					'label' => 'Saturday',
			],
			[
					'colspan' => 2,
					'label' => 'Midsale',
			],
			[
					'colspan' => 2,
					'label' => 'Sellout',
			],
			[
					'colspan' => 4,
					'label' => 'Remainder',
			],
			NULL,
	];
	$main_row = [
			NULL,
			'Year',
			'Grower',
			'Cat#',
			'Pot Size',
			'Flat Size',
			'Flat Cost',
			'Flat Area<br/>(Sq Ft)',
			'Plant Cost',
			'Price',
			'Ord&rsquo;d',
			'Rec&rsquo;d',
			'Ord&rsquo;d',
			'Rec&rsquo;d',
			'Ord&rsquo;d',
			'Rec&rsquo;d',
			'Ord&rsquo;d',
			'Rec&rsquo;d',
			'Fri',
			'Sat',
			'Fri',
			'Sat',
			'Sun',
			'Dead',
			NULL,
	];
	?>
	<!-- order/list -->
	<table class='list compressed'>
		<thead>
		<tr class='top-row'>
			<?php foreach ($top_row as $top_label): ?>
				<?php if ($top_label == NULL): ?>
					<th></th>
				<?php else: ?>
					<th colspan=<?php echo $top_label['colspan']; ?>><?php echo $top_label['label']; ?></th>
				<?php endif; ?>
			<?php endforeach; ?>
		</tr>
		<tr>
			<?php foreach ($main_row as $label): ?>
				<th><?php echo $label; ?></th>

			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($orders as $order) :
			$this->load->view('order/row', [
					'order' => $order,
			]);
		endforeach;
		?>
		</tbody>
	</table>

<?php endif;
