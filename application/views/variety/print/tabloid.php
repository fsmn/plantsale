<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tabloid.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com
$classes = array("document");
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
if(isset($row_class)){
	$classes[] = implode(" ", $row_class);
}
$saturday_delivery = $order->count_midsale?1:0;
?>
<div class="<?=implode(" ",$classes);?>">
	<div class="header">
	<div class="catalog-number"><?=$order->catalog_number;?></div>
	<div class="common-name"><?=$variety->common_name;?></div>
	</div>
<div class="subheader">
<? if($saturday_delivery || $variety->new_year == $this->session->userdata("sale_year")):?>
<div class="special-icons">
	<? if($order->count_midsale > 0): ?>

		<div class="icon saturday-delivery">
		<!-- <img src="<?=base_url("images/truck-icon.png");?>"/> -->
		<?=format_saturday("poster"); ?>
		</div>

	<? endif;?>
	<? if($variety->new_year == $this->session->userdata("sale_year")):?>
<div class="icon is-new">
		<!-- <img src="<?=base_url("images/new-icon.png");?>"/> -->
		<?=format_new("poster"); ?>
		</div>
		<?endif;?>
</div>
<? endif;?>
	<span class="variety"><a href="<?=site_url("variety/view/$variety->id");?>" target="_blank"><?=$variety->variety;?></a></span>
	<span class="latin-name"><?=format_latin_name($variety);?></span>
	</div>
	<div class="description-group">
	<? if($has_image):?>
	<div class="image">
		<img src="<?=site_url("files/$variety->image_name");?>" class="photo" />

</div>
<? endif;?>
<div class="description-text">
	<div class="description"><?=$variety->description;?></div>
	<div class="print_description"><?=$variety->print_description;?></div>
</div>
</div>
<div class="details-group">
	<div class="price-group">
		<div class="pot-size"><?=get_value($order,"pot_size");?></div>
		<div class="price"><?=get_as_price(get_value($order,"price"));?></div>

	</div>
	<div class="icons">
		<ul class="sunlight">
			<?
			$sunlight = explode(",",$variety->sunlight);
foreach($sunlight as $light){
			echo sprintf("<li class='%s'>%s</li>",css_classify($light),format_sunlight($light,"poster"));
	}
			?>
		</ul>
		<ul class="flags">
			<? foreach($flags as $flag){
			    echo sprintf("<li class='%s'>%s</li>",css_classify($flag->name),format_flags(array($flag),"poster"));
				//echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>

		</ul>
	</div>
	<div class="dimensions">
	<? if($variety->min_height || $variety->max_height):?>
		<div class="height">
			<label>Height</label>
			<div class="text"><?=format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit));?></div>
		</div>
	<?endif;?>
	<?if($variety->min_width || $variety->max_width):?>
		<div class="width">
			<label>Width</label>
			<div class="text"><?=format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit));?></div>
		</div>
	<?endif;?>
	</div>
</div>
	<div class="footer-group">
		<div class="grower-name"><?=get_value($order,"grower_name");?></div>
	</div>
</div>
<!--  <div id="crop-failure">
<? if(isset($order) && get_value($order,"received_presale") == "0.000"):?>
<!-- CROP FAILURE -->
<? endif;?>
</div>-->
