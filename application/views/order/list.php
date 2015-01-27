<?php
defined('BASEPATH') or exit('No direct script access allowed');

// variety_order.php Chris Dart Mar 4, 2013 8:44:25 PM
// chrisdart@cerebratorium.com
if ($orders) :

    $top_row = array(
            NULL,
            NULL,
            NULL,
            NULL,
            array(
                    "colspan" => 2,
                    "label" => "Sizes"
            ),
            array(
                    "colspan" => 3,
                    "label" => "Prices"
            ),
            array(
                    "colspan" => 2,
                    "label" => "Presale/Friday"
            ),
            array(
                    "colspan" => 2,
                    "label" => "Midsale"
            ),
            array(
                    "colspan" => 2,
                    "label" => "Sellout"
            ),
            array(
                    "colspan" => 3,
                    "label" => "Remainder"
            ),
            NULL
    );
    $main_row = array(
            NULL,
            "Year",
            "Grower",
            "Cat#",
            "Pot Size",
            "Flat Size",
            "Flat Cost",
            "Plant Cost",
            "Price",
            "Ordered",
            "Rec&rsquo;d",
            "Ordered",
            "Rec&rsquo;d",
            "Fri",
            "Sat",
            "Fri",
            "Sat",
            "Sun",
            "Dead"
    );
    ?>
<table class="list compressed">
	<thead>
		<tr class="top-row">
		<? foreach($top_row as $top_label): ?>
		<? if($top_label == NULL):?>
		<th></th>
		<? else:?>
		<th colspan=<?= $top_label["colspan"];?>><?=$top_label["label"];?></th>
		<? endif;?>
		<? endforeach;?>
		</tr>
		<tr>
		<? foreach($main_row as $label):?>
		<th><?=$label;?></th>

			<? endforeach;?>
		</tr>
	</thead>
	<tbody>
		<?
    foreach ($orders as $order) :
        $this->load->view("order/row", array(
                "order" => $order
        ));
    endforeach
    ;
    ?>
	</tbody>
</table>

<? endif;
