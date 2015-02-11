<?php defined('BASEPATH') OR exit('No direct script access allowed');

// item.php Chris Dart Feb 6, 2015 5:15:55 PM chrisdart@cerebratorium.com

?>
@Common Name:<?=$common->name; ?><p>@Latin Name:<?=$common->genus; ?><p>@Copy:<?=$common->description; ?> <?=format_sunlight($common->sunlight,"quark"); ?>

<?foreach($common->varieties as $variety): ?>
	@Pot and Price:<?=get_as_price($variety->price); ?>[\_]<?=$variety->pot_size; ?>:
	@Copy After Copy:<@Number In-text><?=$variety->catalog_number;?><@$p>
	<?=$variety->variety;?> @Latin Name:<?=format_latin_name($common->genus,$variety->species);?>
	<?=$variety->new_year == get_current_year()?format_new("quark"):"";?>
	<?=($variety->count_midsale && $variety->count_midsale > 0)?format_saturday("quark"):"";?>
	--<?=$variety->print_description;?> <?=format_quark_dimensions($variety);?> <?=format_flags($variety->flags,"quark");?>
<?endforeach;