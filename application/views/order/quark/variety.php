<?php defined('BASEPATH') OR exit('No direct script access allowed');

// item.php Chris Dart Feb 6, 2015 5:15:55 PM chrisdart@cerebratorium.com

?>

@Pot and Price:$6.00<\_><?=$order->pot_size;?>
@Copy After Copy:<@Number In-text><?=$order->catalog_number;?><@$p> <@In text Goudy Sans Bold><?=$order->variety?$order->variety:$order->species;?><@$p><\_>
<?=$order->note;?> <?=$order->min_height?format_dimensions($order->min_height,$order->max_height,abbr_unit($order->height_measure),"h"):"";?>
<?=$order->min_width?format_dimensions($order->min_width,$order->max_width,abbr_unit($order->width_measure),"w"):"";?>
foreach flag.