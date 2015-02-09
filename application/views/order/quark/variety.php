<?php defined('BASEPATH') OR exit('No direct script access allowed');

// item.php Chris Dart Feb 6, 2015 5:15:55 PM chrisdart@cerebratorium.com

?>

@Pot and Price:$6.00<\_><?=$order->pot_size;?>
@Copy After Copy:<@Number In-text><?=$variety->catalog_number;?><@$p> <@In text Goudy Sans Bold><?=$variety->variety?$variety->variety:$variety->species;?><@$p><\_>
<?=$variety->note;?> <?=$variety->min_height?format_dimensions($variety->min_height,$variety->max_height,abbr_unit($variety->height_measure),"h"):"";?>
<?=$variety->min_width?format_dimensions($variety->min_width,$variety->max_width,abbr_unit($variety->width_measure),"w"):"";?>
foreach flag.