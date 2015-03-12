<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
// $show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders)
:
	?>
<!-- views/order/inventor.php -->
<h2 class="column-instructions">
	Click on a header label to hide a column [<a href="#"
		class=" reset-columns">Reset</a>]
</h2>

<table class="list inventory hideable-columns">
	<thead>
		<tr class="top-row">
			<th></th>
			<th></th>
		<? if(!$show_names):?>
			<th></th>
		<? endif;?>
			<th colspan=2></th>
		<? if($show_names):?>
			<th colspan=3></th>

		<? endif;?>
			<th colspan=4>Presale</th>

			<th colspan=4>Midsale</th>
			<th>Sunday</th>
			<th colspan=8></th>

		</tr>
		<tr>
			<th></th>
		<? if(!$show_names):?>
			<th>Year</th>
		<? endif;?>
			<th>Grower</th>
			<th>Cat&#35;</th>
		<? if($show_names):?>
			<th>Genus</th>
			<th>Species</th>
			<th>Common</th>
			<th>Variety</th>
		<? endif;?>

			<th>Ordered</th>
			<th>Rec'd</th>
			<th>Rem</th>
			<th>Sellout</th>

			<th>Ordered</th>
			<th>Rec'd</th>
			<th>Rem</th>
			<th>Sellout</th>
			<th>Rem</th>
			<th>Dead Count</th>


			<th>Total</th>
			<th>Pot Size</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Price</th>
			<th>Grower Code</th> 
			<!-- <th></th>-->
		</tr>
	</thead>
	<tbody>
		<?
	$presale_total = 0;
	$midsale_total = 0;
	$flat_cost_total = 0;
	foreach ( $orders as $order )
	:
		$flat_cost = $order->flat_cost;
		$plant_cost = $order->plant_cost;
		if ($order->flat_cost && ! $order->plant_cost)
		{
			$flat_cost = $order->flat_cost;
			$plant_cost = $order->flat_size / $order->flat_cost;
		}
		elseif ($order->plant_cost && ! $order->flat_cost)
		{
			$plant_cost = $order->plant_cost;
			$flat_cost = $order->flat_size * $order->plant_cost;
		}
		$row_classes = array (
				"grouping"
		);
		$latest_year = get_value ( $order, "latest_year", TRUE );
		if (! $order->latest_order)
		{
			$row_classes [] = "disabled";
			if ($this->input->get ( "show_last_only" ))
			{
				$row_classes [] = "hidden";
			}
		}

		if ($order->crop_failure)
		{
			$row_classes [] = "crop-failure";
		}

		$presale_total += $order->count_presale;
		$midsale_total += $order->count_midsale;
		$flat_cost_total += $order->flat_cost * ($order->count_presale + $order->count_midsale);
		$row_classes [] = has_price_discrepancy ( $order );

		?>
		<tr class="<?=implode(" ",$row_classes);?>"
			id="order_<?=$order->id;?>">


			<td class="no-wrap" >
			<? if(IS_ADMIN):?>
				<span tabindex=-1 class="omit-row omit button" id="omit-order_<?=$order->id;?>">Omit</span>

			<? endif;?>
			<? if(IS_EDITOR):?>
			<?php echo create_button(array("text"=>"Edit","class"=>array("button","edit","edit-order"),"id"=>"edit-order_$order->id","tabindex"=>"-1'"));?>

				<? else: ?>
				<?php echo create_button(array("text"=>"Details","class"=>array("button","details","view-order"),"href"=>site_url("order/view/$order->id")));?>

				<? endif; ?>
				</td>
			<? if(!$show_names):?>
				<td tabindex=-1 class="order-year field"><?=edit_field("year",$order->year,"","order",$order->id,array("envelope"=>"span"));?>
				</td>
			<? endif;?>
			<td tabindex=-1 class="order-grower_id field"><?=edit_field("grower_id",$order->grower_id,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td tabindex=-1 class="order-catalog_number field">
				<!-- if there is no catalog number, show the first letter of the category -->
			    <?=edit_field("catalog_number",$order->catalog_number?$order->catalog_number:ucfirst(substr($order->category,0,1)),"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<? if($show_names):?>
			<td><a tabindex=-1
				href="<?=site_url(sprintf("common/find?genus=%s",$order->genus));?>"
				title="View all <?=$order->genus;?>"><?=$order->genus;?></a></td>
			<td tabindex=-1><?=$order->species;?></td>
			<td><a tabindex=-1 href="<?=site_url("common/view/$order->common_id");?>"
				title="View the details for <?=$order->name;?>"><?=$order->name;?></a></td>
			<td><a tabindex=-1 style="font-weight: bold"
				href="<?=site_url("variety/view/$order->variety_id");?>"
				title="View the details for <?=$order->variety;?>"><?=$order->variety;?></a></td>
			<? endif;?>
			<td  tabindex=-1 class="order-count_presale field">
			<?=edit_field("count_presale",$order->count_presale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-received_presale field">
			<?=live_field("received_presale",$order->received_presale,"order",$order->id,array("envelope"=>"span")); ?>
			</td>
			<td class="order-remainder_friday field">
			<?=live_field("remainder_friday",$order->remainder_friday,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td  class="order-sellout_friday field">
			<?=live_field("sellout_friday",$order->sellout_friday,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td tabindex=-1 class="order-count_midsale field">
			<?=edit_field("count_midsale",$order->count_midsale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-received_midsale field">
			<?=live_field("received_midsale",$order->received_midsale,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_saturday field">
			<?=live_field("remainder_saturday",$order->remainder_saturday,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-sellout_saturday field">
			<?=live_field("sellout_saturday",$order->sellout_saturday,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_sunday field">
			<?=live_field("remainder_sunday",$order->remainder_sunday,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-count_dead field">
			<?=live_field("count_dead",$order->count_dead,"order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-total_plants field">
			<?=$order->count_midsale + $order->count_presale;?>
			</td>
			<td class="order-pot_size field no-wrap"><?=edit_field("pot_size",$order->pot_size,"","order",$order->id,array("envelope"=>"span","class"=>"pot-size-menu"));?>
			</td>
			<td class="order-flat_size field">
			<?=edit_field("flat_size",$order->flat_size,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-flat_cost field cost-field no-wrap" id="flat_cost">$<span
				id="edit-flat-cost_<?=$order->id;?>" class="edit-cost"><?=number_format($order->flat_cost,2);?></span>
			</td>
			<td tabindex=-1 class="no-wrap order-plant_cost field cost-field no-wrap" id="plant_cost">$<span
				id="edit-plant-cost_<?=$order->id;?>" class="edit-cost"><?=number_format($order->plant_cost,2);?></span>
			</td>
			<td tabindex=-1 class="no-wrap order-price field">
			$<?=edit_field("price",$order->price,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			 <td tabindex=-1 class="order-grower_code field"><?=edit_field("grower_code",$order->grower_code,"","order",$order->id,array("envelope"=>"span"));?>
			</td> 
			<!--<td tabindex=-1 class="re-order field">
				<?php echo create_button(array("text"=>"Re-order","id"=>"oc_$order->variety_id","class"=>array("button","new","reorder","order-create"),"tabindex"=>"-1"));?>
			</td>-->
		</tr>
		<? endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<td></td>
		<? if(!$show_names):?>
			<td></td>
		<? endif;?>
			<td></td>
			<td></td>
		<? if($show_names):?>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		<? endif;?>
			<td><?php echo number_format($presale_total);?></td>
			<td colspan=3></td>
			<td><?php echo number_format($midsale_total);?></td>
			<td colspan=5></td>
			<td><?php echo number_format($presale_total+ $midsale_total);?></td>
			<td></td>
			<td></td>
			<td><?php echo get_as_price($flat_cost_total);?></td>
			<td></td>
			<td></td>
			<!-- <td></td> 
			<td></td>-->
		</tr>
	</tfoot>
</table>


<? endif;
