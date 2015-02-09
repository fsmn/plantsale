<?php defined('BASEPATH') OR exit('No direct script access allowed');

// common.php Chris Dart Feb 6, 2015 5:16:53 PM chrisdart@cerebratorium.com
?>
<!-- where a common name has only one variety -->

catalog_number
common.name
latin name
variety
is_new
Description
<?=format_quark_dimensions($common);?>

<?=format_sunlight($common->sunlight,"quark");?>
<?=format_flags($flags,"quark");?>
<? if($common->count_midsale > 0):?>
<?=format_saturday("quark");?>
<? endif;?>
<? if($common->new_year == get_current_year()):?>
<?=format_new("quark");?>
<? endif;?>
<?=get_as_price($common->price);?>--<?=$common->pot_size;?>

<!-- where a common name has more than one variety -->

catalog_number
common_name
genus
description