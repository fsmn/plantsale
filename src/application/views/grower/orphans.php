<?php
defined('BASEPATH') or exit('No direct script access allowed');

// orphans.php Chris Dart Jan 12, 2015 3:47:05 PM chrisdart@cerebratorium.com
$sale_year = $this->session->userdata("sale_year");
?>
<h3><?php print $title; ?></h3>
<p><?php print $message; ?></p>
<?php if ($orphans) : ?>
	<table class="list">
		<thead>
			<tr>
				<th>Grower ID</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($orphans as $orphan) : ?>
				<tr>
					<td>
						<?php print $orphan->grower_id; ?>
					</td>
					<td>
						<?php print create_button(['text' => 'Add Grower', 'class' => ['button', 'new'], 'href' => site_url('grower/create/' . $orphan->grower_id), 'title' => 'Create a new record for this grower']); ?>
					</td>
					<td>
						<?php print create_button(['text' => 'Show Orders', 'class' => ['button', 'details'], 'href' => site_url('order/search?grower_id=' . $orphan->grower_id . '&year=' . $sale_year . '&sorting%5B%5D=genus&direction%5B%5D=ASC'), 'title' => 'Show orders for this orphan grower']); ?>
					</td>
				</tr>

			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
