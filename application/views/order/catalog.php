<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders) :
    ?>
    <!-- views/order/catalog.php -->
<table class="list">
	<thead>
	<?php if($is_inventory): ?>
	<tr>
		<th></th>
		<? if(!$show_names):?>
			<th></th>
		<? endif;?>
			<th colspan=2></th>
		<? if($show_names):?>
			<th colspan=4></th>

		<? endif;?>
			<th colspan=4>Presale</th>

			<th colspan=4>Midsale</th>
			<th>Sunday</th>
			<th colspan=8></th>

	</tr>
	<?php endif;?>
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
		<?php if($is_inventory):?>
			<th>Ordered</th>
			<th>Rec'd</th>
			<th>Rem</th>
			<th>Sellout</th>
			<?php else: ?>
			<th>Presale Order</th>
			<?php endif;?>
			<?php if($is_inventory):?>

			<th>Ordered</th>
			<th>Rec'd</th>
			<th>Rem</th>
			<th>Sellout</th>
			<th>Rem</th>
			<th>Dead Count</th>

			<?php else: ?>
			<th>Midsale Order</th>
			<?php endif;?>
			<th>Total</th>
			<th>Pot Size</th>
			<th>Flat Size</th>
			<th>Flat Cost</th>
			<th>Plant Cost</th>
			<th>Price</th>
			<th>Grower Code</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?
		$presale_total = 0;
		$midsale_total = 0;
		$flat_cost_total = 0;
    foreach ($orders as $order) :
        $flat_cost = $order->flat_cost;
        $plant_cost = $order->plant_cost;
        if ($order->flat_cost && ! $order->plant_cost) {
            $flat_cost = $order->flat_cost;
            $plant_cost = $order->flat_size / $order->flat_cost;
        } elseif ($order->plant_cost && ! $order->flat_cost) {
            $plant_cost = $order->plant_cost;
            $flat_cost = $order->flat_size * $order->plant_cost;
        }
        $row_classes = array(
                "grouping"
        );
        $latest_year = get_value($order, "latest_year", TRUE);
        if (! $order->latest_order) {
            $row_classes[] = "disabled";
            if($this->input->get("show_last_only"))
            {
                $row_classes[] = "hidden";
            }
        }

        if($order->crop_failure){
			$row_classes[] = "crop-failure";
		}

        $presale_total += $order->count_presale;
        $midsale_total += $order->count_midsale;
        $flat_cost_total += $order->flat_cost;
        $row_classes[] = has_price_discrepancy($order);
        ?>
		<tr
			class="<?=implode(" ",$row_classes);?>"
			id="order_<?=$order->id;?>">
			<td>
			<? if(IS_EDITOR):?>
			<span
				class="button edit edit-order"
				id="<? printf("edit-order_%s",$order->id);?>">Edit</span>
				<? else: ?>
				 <a
				href="<?=site_url("order/view/$order->id");?>"
				class="button">View</a>
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
			<td><a
				href="<?=site_url("common/view/$order->common_id");?>"
				title="View the details for <?=$order->name;?>"><?=$order->name;?></a></td>
			<td><a style="font-weight: bold"
				href="<?=site_url("variety/view/$order->variety_id");?>"
				title="View the details for <?=$order->variety;?>"><?=$order->variety;?></a></td>
			<? endif;?>
			<td class="order-count_presale field">
			<?=edit_field("count_presale",$order->count_presale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php if($is_inventory):?>
			<td class="order-received_presale field">
			<?=edit_field("received_presale",$order->received_presale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_friday field">
			<?=edit_field("remainder_friday",$order->remainder_friday,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-sellout_friday field">
			<?=edit_field("sellout_friday",$order->sellout_friday,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php endif;?>
			<td class="order-count_midsale field">
			<?=edit_field("count_midsale",$order->count_midsale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php if($is_inventory):?>
			<td class="order-received_midsale field">
			<?=edit_field("received_midsale",$order->received_midsale,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_saturday field">
			<?=edit_field("remainder_saturday",$order->remainder_saturday,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-sellout_saturday field">
			<?=edit_field("sellout_saturday",$order->sellout_saturday,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_sunday field">
			<?=edit_field("remainder_sunday",$order->remainder_sunday,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-count_dead field">
			<?=edit_field("count_dead",$order->count_dead,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php endif;?>
			<td class="order-total_plants field">
			<?=$order->count_midsale + $order->count_presale;?>
			</td>
			<td class="order-pot_size field no-wrap"><?=edit_field("pot_size",$order->pot_size,"","order",$order->id,array("envelope"=>"span","class"=>"pot-size-menu"));?>
			</td>
			<td class="order-flat_size field" id="flat_size"><span id="edit-flat-size_<?=$order->id;?>" class="edit-cost"><?=$order->flat_size;?></span>

			</td>
			<td class="order-flat_cost field no-wrap" id="flat_cost">$<span id="edit-flat-cost_<?=$order->id;?>" class="edit-cost"><?=$order->flat_cost;?></span>
			</td>
			<td class="order-plant_cost field no-wrap" id="plant_cost">$<span id="edit-plant-cost_<?=$order->id;?>" class="edit-cost"><?=$order->plant_cost;?></span>
			</td>
			<td class="order-price field no-wrap">$<?=edit_field("price",$order->price,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-grower_code field"><?=edit_field("grower_code",$order->grower_code,"","order",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="re-order field"><span
				id="oc_<?=$order->variety_id;?>"
				class="button new order-create">Re-order</span></td>
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
			<th><?php echo number_format($presale_total);?></th>
			<th><?php echo number_format($midsale_total);?></th>
			<th><?php echo number_format($presale_total+ $midsale_total);?></th>
			<th></th>
			<th></th>
			<th><?php echo get_as_price($flat_cost_total);?></th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>

<? endif;
