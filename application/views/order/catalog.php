<?php
defined('BASEPATH') or exit('No direct script access allowed');
//$show_names = TRUE;
// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com

if ($orders) :
    ?>

    <!-- views/order/catalog.php -->
    <h5 class="column-instructions">Click on a header to hide the column [<a href="#" class=" reset-columns">Reset</a>]</h5>
<table class="list table table-bordered table-condensed catalog hideable-columns">
	<thead>

		<tr>
			<th class="hide-column"></th>
		<? if(!$show_names):?>
			<th class="hide-column">Year</th>
		<? endif;?>
			<th class="hide-column">Grower</th>
			<th  class="hide-column">Cat&#35;</th>
		<? if($show_names):?>
			<th  class="hide-column">Genus</th>
			<th  class="hide-column">Species</th>
			<th  class="hide-column">Common</th>
			<th  class="hide-column">Variety</th>
		<? endif;?>
			<th  class="hide-column">Presale Order</th>
			<th  class="hide-column">Midsale Order</th>
			<th class="hide-column" >Total</th>
			<th class="hide-column">Pot Size</th>
			<th class="hide-column">Flat Size</th>
			<th class="hide-column">Flat Cost</th>
			<th class="hide-column">Plant Cost</th>
			<th class="hide-column">Order Total</th>
			<th class="hide-column">Price</th>
			<th class="hide-column" >Grower Code</th>
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
//         if (! $order->latest_order) {
//             $row_classes[] = "disabled";
//             if($this->input->get("show_last_only"))
//             {
//                 $row_classes[] = "hidden";
//             }
//         }
if(get_value($order,"has_reorder") && $order->has_reorder){
	$row_classes[] = "hidden";
}
        if($order->crop_failure){
			$row_classes[] = "crop-failure";
		}

        $presale_total += $order->count_presale;
        $midsale_total += $order->count_midsale;
        $flat_cost_total += $order->flat_cost * ($order->count_presale + $order->count_midsale);
        $row_classes[] = has_price_discrepancy($order);
        ?>
		<tr
			class="<?=implode(" ",$row_classes);?>"
			id="order_<?=$order->id;?>">
			<td class="no-wrap">
			<? if(IS_ADMIN):?>
			<span class="omit-row omit button btn btn-xs btn-warning" id="omit-order_<?=$order->id;?>">Omit</span>
			<? endif;?>
			<? if(IS_EDITOR):?>
			<?php echo create_button(array("text"=>"Edit","href"=>site_url("order/edit/$order->id"),"class"=>array("button","edit","dialog","edit-order","btn-xs"),"id"=>sprintf("edit-order_%s",$order->id)));?>

				<? else: ?>
				<?php echo create_button(array("text"=>"Details","class"=>array("button","details","btn-sm"),"style"=>"small","href"=>site_url("order/view/$order->id")));?>

				<? endif; ?>

				</td>
			<? if(!$show_names):?>
				<td class="order-year field"><?=edit_field("year",$order->year,"","orders",$order->id,array("envelope"=>"span"));?>
				</td>
			<? endif;?>
			<td class="order-grower_id field"><?=edit_field("grower_id",$order->grower_id,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-catalog_number field">
			<!-- if there is no catalog number, show the first letter of the category -->
		<?=edit_field("catalog_number",$order->catalog_number?$order->catalog_number:ucfirst(substr($order->category,0,1)),"","orders",$order->id,array("envelope"=>"span"));?>
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
			<?=edit_field("count_presale",$order->count_presale,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php if($is_inventory):?>
			<td class="order-received_presale field">
			<?=edit_field("received_presale",$order->received_presale,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_friday field">
			<?=edit_field("remainder_friday",$order->remainder_friday,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-sellout_friday field">
			<?=edit_field("sellout_friday",$order->sellout_friday,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php endif;?>
			<td class="order-count_midsale field">
			<?=edit_field("count_midsale",$order->count_midsale,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php if($is_inventory):?>
			<td class="order-received_midsale field">
			<?=edit_field("received_midsale",$order->received_midsale,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_saturday field">
			<?=edit_field("remainder_saturday",$order->remainder_saturday,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-sellout_saturday field">
			<?=edit_field("sellout_saturday",$order->sellout_saturday,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-remainder_sunday field">
			<?=edit_field("remainder_sunday",$order->remainder_sunday,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-count_dead field">
			<?=edit_field("count_dead",$order->count_dead,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<?php endif;?>
			<td class="order-total_plants field">
			<?=$order->count_midsale + $order->count_presale;?>
			</td>
			<td class="order-pot_size field no-wrap"><?=edit_field("pot_size",$order->pot_size,"","orders",$order->id,array("envelope"=>"span","class"=>"pot-size-menu"));?>
			</td>
			<td class="order-flat_size field cost-field" id="flat_size"><span id="edit-flat-size_<?=$order->id;?>" class="edit-cost"><?=$order->flat_size;?></span>

			</td>
			<td class="order-flat_cost field cost-field no-wrap" id="flat_cost">$<span id="edit-flat-cost_<?=$order->id;?>" class="edit-cost"><?=number_format($order->flat_cost,2);?></span>
			</td>
			<td class="order-plant_cost field cost-field no-wrap" id="plant_cost">$<span id="edit-plant-cost_<?=$order->id;?>" class="edit-cost"><?=number_format($order->plant_cost,2);?></span>
			</td>
			<td class="order-order_total field order_total no-wrap">$<?=round($order->flat_cost * ($order->count_presale + $order->count_midsale),2);?>
			</td>
			<td class="order-price field price-field no-wrap">$<?=edit_field("price",$order->price,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="order-grower_code field"><?=edit_field("grower_code",$order->grower_code,"","orders",$order->id,array("envelope"=>"span"));?>
			</td>
			<td class="re-order field">
			<?php echo create_button(array("text"=>"Re-order","href"=>site_url("order/create?variety_id=$order->variety_id&reorder=1"),"id"=>"oc_$order->variety_id","class"=>array("button","new","create","dialog","order-create","btn-sm")));?>
			</td>
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
			<th></th>
			<th></th>
			<th><?php echo get_as_price($flat_cost_total);?></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	</tfoot>
</table>

<? endif; ?>
