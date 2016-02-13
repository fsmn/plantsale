<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

?>
<table class="list">
	<thead>
		<tr>
			<th class="cell">Variety</th>
			<th class="cell">Common Name</th>
			<th class="cell">Latin Name</th>
			<th class="cell">Year</th>
			<th class="cell">Ordered</th>
			<th class="cell">Pot Size</th>
			<th class="cell">Flat Cost</th>
			<th class="cell">Category</th>
			<th class="cell">Subcategory</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($orders as $order):?>
	<tr class="table-row">
			<td class="cell"><a href="<?php echo site_url("variety/view/$order->id");?>" target="_blank" title="View variety details"><?php echo $order->variety;?></a></td>
			<td class="cell"><a href="<?php echo site_url("common/view/$order->common_id");?>" target="_blank" title="View common details"><?php echo $order->name;?></a></td>
			<td class="cell"><?php echo format_latin_name($order->genus);?></td>
			<td class="cell"><?php echo $order->year;?></td>
			<td class="cell"><?php echo $order->count_presale;?></td>
			<td class="cell"><?php echo $order->flat_size;?></td>
			<td class="cell"><?php echo get_as_price($order->flat_cost);?></td>
			<td class="cell"><?php echo $order->category;?></td>
			<td class="cell"><?php echo $order->subcategory;?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
