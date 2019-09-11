<?php
defined('BASEPATH') or exit('No direct script access allowed');
$main_row = array(

        "year",
        "grower_id",
        "catalog_number",
        "pot_size",
        "flat_size",
        "flat_cost",
        "plant_cost",
        "price",
        "count_presale",
        "received_presale",
        "count_midsale",
        "received_midsale",
        "sellout_friday",
        "sellout_saturday",
        "remainder_friday",
        "remainder_saturday",
        "remainder_sunday",
        "count_dead"
);
?>

    <tr>
    <td></td>
    <?php foreach($main_row as $item): ?>
<td><?php echo $order->$item;?></td>

    <?php endforeach;?>
    </tr>