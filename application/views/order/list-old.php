<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM chrisdart@cerebratorium.com
if ($orders) :
	?>

<table class="list">
	<thead>
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
			<th>Presale</th>
			<th>Midsale</th>
			<th>Total</th>
			<th>Pot Size</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Price</th>
			<th>Grower Code</th>
		</tr>
	</thead>
	<tbody>
		<?
	foreach ( $orders as $order ) :
		$flat_cost = $order->flat_cost;
		$plant_cost = $order->plant_cost;
		if ($order->flat_cost && ! $order->plant_cost) {
			$flat_cost = $order->flat_cost;
			$plant_cost = $order->flat_size / $order->flat_cost;
		} elseif ($order->plant_cost && ! $order->flat_cost) {
			$plant_cost = $order->plant_cost;
			$flat_cost = $order->flat_size * $order->plant_cost;
		}
		?>
		<tr class="grouping" id="order_<?=$order->id;?>">
			<td>
			<? if(DB_ROLE == 1):?>
			<span class="button edit edit-order"
				id="<? printf("edit-order_%s",$order->id);?>">Edit</span>
				<? else: ?>
				 <a href="<?=site_url("order/view/$order->id");?>" class="button">View</a>
				<? endif; ?>

				</td>
			<? if(!$show_names):?>
				<td class="order-year field"><?=edit_field("year",$order->year,"","order",$order->id,array("envelope"=>"span"));?>
				</td>
			<? endif;?>
			<td class="order-grower_id field"><?=edit_field("grower_id",$order->grower_id,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-catalog_number field">
		<?=edit_field("catalog_number",$order->catalog_number,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<? if($show_names):?>
			<td><a
				href="<?=site_url(sprintf("common/find?genus=%s",$order->genus));?>"
				title="View all <?=$order->genus;?>"><?=$order->genus;?></a></td>
			<td><?=$order->species;?></td>
			<td><a href="<?=site_url("common/view/$order->common_id");?>"
				title="View the details for <?=$order->name;?>"><?=$order->name;?></a></td>
			<td><a href="<?=site_url("variety/view/$order->variety_id");?>"
				title="View the details for <?=$order->variety;?>"><?=$order->variety;?></a></td>
			<? endif;?>
			<td class="order-count_presale field">
			<?=edit_field("count_presale",$order->count_presale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-count_midsale field">
			<?=edit_field("count_midsale",$order->count_midsale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-total_plants field">
				<?=$order->count_midsale + $order->count_presale;?>
			</td>
			<td class="order-pot_size field no-wrap"><?=edit_field("pot_size",$order->pot_size,"","order",$order->id,array("envelope"=>"span","class"=>"pot-size-menu"));?>
			</td>
			<td class="order-flat_size field"><?=edit_field("flat_size",$order->flat_size,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-flat_cost field no-wrap">$<?=edit_field("flat_cost",$order->flat_cost,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-plant_cost field no-wrap">$<?=edit_field("plant_cost",$order->plant_cost,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-price field no-wrap">$<?=edit_field("price",$order->price,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-grower_code field"><?=edit_field("grower_code",$order->grower_code,"","order",$order->id,array("envelope"=>"span"));?>
			</td>

		</tr>
		<? endforeach;?>
	</tbody>
</table>
<? endif;
