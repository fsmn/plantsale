<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM chrisdart@cerebratorium.com
if ($orders) :
	?>

<table class="list compressed">
<thead>
<tr class="top-row">
<th></th>
<th></th>
<th></th>
<th></th>
<th colspan=2>Sizes</th>
<th></th>
<th></th>
<th colspan=2>Presale</th>
<th colspan=2>Midsale</th>
<th colspan=2>Sellout</th>
<th colspan=3>Remainder</th>
<th></th>
</tr>
<tr>
<th></th>
<th>Year</th>
<th>Grower</th>
<th>Cat#</th>
<th>Pot Size</th>
<th>Flat Size</th>
<th>Plant Cost</th>
<th>Price</th>
<th>Ordered</th>
<th>Rec&rsquo;d</th>
<th>Ordered</th>
<th>Rec&rsquo;d</th>
<th>Fri</th>
<th>Sat</th>
<th>Fri</th>
<th>Sat</th>
<th>Sun</th>
<th>Dead</th>
</tr>
</thead>
<tbody>
		<?
	foreach ( $orders as $order ) :
	$this->load->view("order/row",array("order"=>$order));
		endforeach;?>
	</tbody>
</table>
<? endif;
