<?php defined('BASEPATH') OR exit('No direct script access allowed');

// common.php Chris Dart Feb 6, 2015 5:16:53 PM chrisdart@cerebratorium.com

$variety = $common->varieties[0];
?>
@Common Name:<@Number In-text> 
<?=$variety->catalog_number; ?> <@$p>
<?=$common->name;?>
<?=$variety->count_midsale?format_saturday("quark"):""; ?>
<?=$variety->new_year == get_current_year()?format_new("quark"):"";?>
<p>@Latin Name:<?=format_latin_name($common->genus,$variety->species); ?>
<$>'<?=$variety->variety; ?>'<$>
<p>@Copy: <?=format_description($common->description,$variety,"quark");?>
<?=format_quark_dimensions($variety); ?>
<? echo " "; ?>
<?=format_sunlight($common->sunlight,"quark");?> 
<?=format_flags($variety->flags,"quark");?><p>
<p>@Pot and Price Right:<?=get_as_price($variety->price);?>--<?=$variety->pot_size;?>