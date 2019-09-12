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
    		NULL,
            array(
                    "colspan" => 3,
                    "label" => "Sizes"
            ),
            array(
                    "colspan" => 2,
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
                    "colspan" => 4,
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
    		"Flat Area<br/>(Sq Ft)",
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
            "Dead",
    		NULL
    );
    ?>
    <!-- order/list -->
<table class="list compressed">
	<thead>
		<tr class="top-row">
		<?php foreach($top_row as $top_label): ?>
		<?php if($top_label == NULL):?>
		<th></th>
		<?php else:?>
		<th colspan=<?php echo  $top_label["colspan"];?>><?php echo $top_label["label"];?></th>
		<?php endif;?>
		<?php endforeach;?>
		</tr>
		<tr>
		<?php foreach($main_row as $label):?>
		<th><?php echo $label;?></th>

			<?php endforeach;?>
		</tr>
	</thead>
	<tbody>
		<?php
    foreach ($orders as $order) :
        $this->load->view("order/row", array(
                "order" => $order
        ));
    endforeach
    ;
    ?>
	</tbody>
</table>

<?php endif;