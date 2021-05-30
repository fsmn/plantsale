<?php defined('BASEPATH') or exit('No direct script access allowed');
$sale_year = $this->session->userdata("sale_year");;
// totals.php Chris Dart Apr 21, 2014 2:06:25 PM chrisdart@cerebratorium.com
?>
<table class="chart">
	<thead>
	<tr>
		<td>
		</td>
		<td>
			<?php print $sale_year; ?>
		</td>
		<td>
			<?php print $sale_year - 1; ?>
		</td>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($categories['current'] as $category) : ?>
		<tr>
			<td>
				<a href="<?php print site_url('order/search?find=1&category_id=' . $category->id . '&sorting%5B%5D=genus&direction%5B%5D=ASC&year=' . $sale_year); ?>"><?php print $category->category; ?></a>
			</td>
			<td>
				<?php print number_format($category->count, 0); ?>
			</td>
			<td>
				<?php //it's clumsy, but it works ?>
				<?php foreach ($categories['previous'] as $old_category): ?>
					<?php if ($old_category->category == $category->category): ?>
						<?php print number_format($old_category->count, 0); ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
