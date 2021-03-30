<?php
defined('BASEPATH') or exit('No direct script access allowed');

$sale_year = $this->session->userdata("sale_year");;

?>
<!-- order/totals -->
<table class="chart">
	<thead>
		<tr>
			<td></td>
			<td>
				<?php print $sale_year; ?>
			</td>
			<td>
				<?php print $sale_year - 1; ?>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Total Plants</td>
			<td>
				<?php print number_format($totals->total['current']); ?>
			</td>
			<td>
				<?php print number_format($totals->total['previous']); ?>
			</td>
		</tr>
		<tr>
			<td>New varieties</td>
			<td>
				<a href="<?php print site_url('variety/search?find=1&action=full&year=' . $sale_year . '&new_year=' . $sale_year . '&sorting[]=genus&direction[]=ASC'); ?>" title="Show a list of all varieties ordered new this year (or after a long hiatus)"><?php print $totals->new_varieties['current']; ?></a>
			</td>
			<td>
				<?php print number_format($totals->new_varieties['previous']); ?>
			</td>
		</tr>
		<tr>
			<td>Reordered Plants</td>
			<td><a href="<?php print site_url('variety/show_reorders/' . $this->session->userdata('sale_year')); ?>" title="Show all reodrered plants (no new plants)"><?php print number_format(count($totals->varieties['current']) - $totals->new_varieties['current']); ?></a>
			</td>
			<td>
				<?php print number_format(count($totals->varieties['previous']) - $totals->new_varieties['previous']); ?>
			</td>
		</tr>
		<tr>
			<td>Total varieties</td>
			<td>
				<?php print number_format(count($totals->varieties['current'])); ?>
			</td>
			<td>
				<?php print number_format(count($totals->varieties['previous'])); ?>
			</td>
		</tr>
	</tbody>
</table>