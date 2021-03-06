<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders)
:
	?>
<!-- order/shelfchecking -->

<table class="list shelf-checking small">
	<thead>
		<tr>
			<th>Grw</th>
			<th>Yr</th>
			<th>Cat&#35;</th>
			<th class="text-cell">Common</th>
			<th class="no-wrap">Pot-Size</th>
			<th class="text-cell">Variety</th>
			<th>Weds<br/>Ordered</th>
			<th>Not<br/>There</th>
			<th>Very<br/> Short</th>
			<th>Needs<br/>Sign</th>
			<th>Needs<br/>Tags</th>
			<th>Comments</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($orders as $order):?>
		<tr id="order_<?php echo $order->id;?>">
		<td><?php echo $order->grower_id;?></td>
		<td><?php echo $order->year;?></td>	
		<td><?php echo $order->catalog_number;?></td>
		<td><?php echo $order->name;?></td>
		<td class="no-wrap"><?php echo $order->pot_size;?></td>
		<td><?php echo $order->variety;?></td>
		<td><?php echo $order->count_presale;?></td>
		<td class="checkbox">&nbsp;</td>
		<td class="checkbox">&nbsp;</td>
		<td class="checkbox">&nbsp;</td>
		<td class="checkbox">&nbsp;</td>
		<td class="comment">&nbsp;</td>
		
</tr>
		<?php endforeach;?>
	</tbody>
</table>


<?php endif;
