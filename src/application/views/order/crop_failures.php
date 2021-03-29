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
				<td class="cell"><a href="<?php print site_url('variety/view/' . $order->id);?>" target="_blank"
					title="View variety details"><?php print $order->variety;?></a></td>
				<td class="cell"><a href="<?php print site_url('common/view/' . $order->common_id);?>" target="_blank"
					title="View common details"><?php print $order->name;?></a></td>
				<td class="cell"><?php print format_latin_name($order);?></td>
				<td class="cell"><?php print $order->year;?></td>
				<td class="cell"><?php print $order->count_presale;?></td>
				<td class="cell"><?php print $order->flat_size;?></td>
				<td class="cell"><?php print get_as_price($order->flat_cost);?></td>
				<td class="cell"><?php print $order->category;?></td>
				<td class="cell"><?php print $order->subcategory;?></td>
			</tr>
        <?php endforeach;?>
    </tbody>
</table>