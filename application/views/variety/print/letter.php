<?php
defined('BASEPATH') or exit('No direct script access allowed');
$classes = array("document");
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
$saturday_delivery = $order->count_midsale?1:0;
?>
<div class="<?php echo implode(" ",$classes);?>">
	<div class="header">
	<div class="catalog-number"><?=$order->catalog_number;?></div>
	<div class="common-name"><?=$variety->common_name;?></div>
	</div>

<div class="subheader">
<? if($saturday_delivery):?>
<span class="saturday-delivery">
		<!-- <img src="<?=base_url("images/truck-icon.png");?>"/> -->
		<?=format_saturday("poster"); ?>
		</span>
		<?endif;?>
	<span class="latin-name<?=$saturday_delivery?' saturday':'';?>"><?=format_latin_name($variety->genus,$variety->species);?></span>
	<div class="variety-name">
	<? if($variety->new_year == get_cookie("sale_year")):?>
<span class="is-new">
		<!-- <img src="<?=base_url("images/new-icon.png");?>"/> -->
		<?=format_new("poster"); ?>
		</span>
		<?endif;?>
	<span class="variety"><a href="<?=site_url("variety/view/$variety->id");?>" target="_blank"><?=$variety->variety;?></a></span>
	</div>
	</div>
	<div class="description-group">
	<? if($has_image):?>
	<div class="image">
		<img src="<?=site_url("files/$variety->image_name");?>" class="photo" />
				<ul class="flags icons">
			<? foreach($flags as $flag){
			    echo sprintf("<li class='%s'>%s</li>",css_classify($flag->name),format_flags(array($flag),"poster"));
				//echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>
		</ul>
</div>
<? endif;?>
<div class="details">
<div class="price-group">
		<div class="pot-size"><?=get_value($order,"pot_size");?></div>
		<div class="price"><?=get_as_price(get_value($order,"price"));?></div>
	</div>
<div class="icons-dimensions">
<ul class="sunlight icons">
	<?
			$sunlight = explode(",",$variety->sunlight);
			foreach($sunlight as $light){
				echo sprintf("<li class='%s'>%s</li>",css_classify($light),format_sunlight($light,"poster"));
			}
			?>
			<? //$sunlight = explode(",",$variety->sunlight);
// 			foreach($sunlight as $light){
// 				switch($light){
// 				case "full":
// 					echo sprintf("<li><img src='%s'/></li>", base_url("images/sun-icon.png"));
// 					break;
// 				case "part":
// 					echo sprintf("<li><img src='%s'/></li>", base_url("images/part-icon.png"));
// 					break;
// 				case "shade":
// 					echo sprintf("<li><img src='%s'/></li>",base_url("images/shade-icon.png"));
// 					break;
// 				}
// 			}
// 			?>
		</ul>
<div class="dimensions">
	<?if($variety->min_width || $variety->max_width):?>
		<div class="width">
			<label>Width</label>
			<div class="text"><?=format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit));?></div>
		</div>
		<?endif;?>
		<? if($variety->min_height || $variety->max_height):?>
		<div class="height">
			<label>Height</label>
			<div class="text"><?=format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit));?></div>
		</div>
		<?endif;?>
	</div>





	</div>
	<div class="copy">
	<div class="description"><?=$variety->description;?></div>
	<div class="print_description"><?=$variety->print_description;?></div>
	</div>

</div>
</div>



	<div class="footer-group">
		<div class="grower-name"><?=get_value($order,"grower_name");?></div>
	</div>
</div>

<? $classes = array();