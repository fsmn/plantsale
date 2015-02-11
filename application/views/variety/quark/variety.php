<?php defined('BASEPATH') OR exit('No direct script access allowed');

// item.php Chris Dart Feb 6, 2015 5:15:55 PM chrisdart@cerebratorium.com

?>

@Pot and Price:$6.00<\_><?=$variety->pot_size;?>
@Copy After Copy:<@Number In-text><?=$variety->catalog_number;?><@$p>
<I><?=$variety->variety?$variety->variety:$variety->species;?><\I>
<?=$variety->note;?> <?=format_quark_dimensions($variety);?>
<?=format_flags($variety->flags,"quark");?>
"@Copy After Copy:" &
"<@Number In-text>" &
current_orders::catalog_number &
"<@$p>" & " " &
" " &
Color &
", " &
"<I>" &
Left(Common_Names::Genus;1) & "." &
" " &
Species &
"<\I>" &
" " &
flagC~New Item Icon &
flag~Saturday Yes &
"--" &
Item Notes &
" " &
catalog_export~Height_Display &
catalog_export~width_display &
" " &
catalog_export~flags