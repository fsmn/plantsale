<?php defined('BASEPATH') OR exit('No direct script access allowed');

// item.php Chris Dart Feb 6, 2015 5:15:55 PM chrisdart@cerebratorium.com

?>
@Copy After Copy:<@Number In-text><?=$variety->catalog_number;?><@$p>
<?=$variety->variety;?>&nbsp;
<I><?=format_latin_name($variety->genus,$variety->species);?><\I>
<? if($variety->new_year == get_current_year()){
echo format_new("quark");
}
if($variety->count_midsale && $variety->count_midsale > 0){
echo format_saturday("quark");
}?>
--<?=$variety->print_description;?>&nbsp;
<?=format_quark_dimensions($variety);?>

<?=format_flags($variety->flags,"quark");?>