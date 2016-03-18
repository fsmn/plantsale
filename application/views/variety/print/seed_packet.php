<?php
defined('BASEPATH') or exit('No direct script access allowed');
$classes = array("document");
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
if(isset($row_class)){
	$classes[] = $row_class;
}
?>
<div class="<?php echo implode(" ",$classes);?>">
<div id="header">
	<div class="header left">
	<div class="catalog-number"><?=$order->catalog_number;?></div>
	</div>
	<div class="header right">
	<div class="common-name"><?=$variety->common_name;?></div>
	<div class="latin-name<?=format_latin_name($variety);?></div>
	<div class="variety-name">
	<? if($variety->new_year == get_cookie("sale_year")):?>
		<span class="is-new">
		<!-- <img src="<?=base_url("images/new-icon.png");?>"/> -->
		<?=format_new("poster"); ?>
		</span>
		<?endif;?>
	<span class="variety"><a href="<?=site_url("variety/view/$variety->id");?>" target="_blank"><?=$variety->variety;?></a></span>
	</div>
	
	<ul class="flags icons">
			<? foreach($flags as $flag){
			    echo sprintf("<li class='%s'>%s</li>",css_classify($flag->name),format_flags(array($flag),"poster"));
				//echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>
			
			<?
			if(get_value($variety,"sunlight")){
			$sunlight = explode(",",$variety->sunlight);
			foreach($sunlight as $light){
				echo sprintf("<li class='%s'>%s</li>",css_classify($light),format_sunlight($light,"poster"));
			}
			}
			?>
		</ul>
		<div class="dimensions">
	<?if($variety->min_width || $variety->max_width):?>
		<div class="width">
			<div class="text"><?=format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit, TRUE));?>w</div>
		</div>
		<?endif;?>
		<? if($variety->min_height || $variety->max_height):?>
		<div class="height">
			<div class="text"><?=format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit, TRUE));?>h</div>
		</div>
		<?endif;?>
	</div>
		
	</div>
</div>	
		<div class="copy">
	<div class="description"><?=$variety->description;?></div>
	<div class="print_description"><?=$variety->print_description;?></div>
	</div>

	<? if($has_image):?>
	<div class="image">
		<img src="<?=site_url("files/$variety->image_name");?>" class="photo" />
				
</div>
<? endif;?>
<div class="details">
		<div class="grower-name"><?=get_value($order,"grower_name");?></div>
		<div class="price-group">
		
		<span class="pot-size"><?=get_value($order,"pot_size");?></span> 
		<span class="price"><?=get_as_price(get_value($order,"price"));?></span>
	</div>
</div>
</div>


<? $classes = array();