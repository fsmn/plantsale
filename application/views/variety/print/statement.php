<?php
defined('BASEPATH') or exit('No direct script access allowed');

// statement.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com
$classes = array("document");
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
$saturday_delivery = $order->count_midsale?1:0;
?>
<div class="<? echo implode(" ",$classes);?>">
	<div class="header">
	<div class="catalog-number"><?=$order->catalog_number;?></div>
	<div class="common-name"><?=$variety->common_name;?></div>
	</div>
<div class="subheader">
<? if($saturday_delivery || $variety->new_year == get_cookie("sale_year")):?>
<div class="special-icons">
	<? if($order->count_midsale > 0): ?>

		<span class="icon saturday-delivery">
		<img src="<?=base_url("images/truck-icon.png");?>"/>
		</span>

	<? endif;?>
	<? if($variety->new_year == get_cookie("sale_year")):?>
<span class="icon is-new">
		<img src="<?=base_url("images/new-icon.png");?>"/>
		</span>
		<?endif;?>
</div>
<? endif;?>
<div class="latin-name"><?=format_latin_name($variety->genus,$variety->species);?></div>
	</div>
	<div class="description-group">
	<? if($has_image):?>
	<div class="image">
		<img src="<?=site_url("files/$variety->image_name");?>" class="photo" />

</div>
<? endif;?>
<div class="description-text">
<div class="variety"><?=$variety->variety;?></div>
	<div class="description"><?=$variety->description;?></div>
	<div class="print_description"><?=$variety->print_description;?></div>
</div>
</div>
<div class="details-group">

<div class="dimensions">
	<?if($variety->min_width):?>
		<div class="width">
			<label>Width</label>
			<div class="text"><?=format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit));?></div>
		</div>
		<?endif;?>
		<? if($variety->min_height):?>
		<div class="height">
			<label>Height</label>
			<div class="text"><?=format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit));?></div>
		</div>
		<?endif;?>
	</div>
	<div class="price-group">
		<div class="pot-size"><?=get_value($order,"pot_size");?></div>
		<div class="price"><?=get_as_price(get_value($order,"price"));?></div>
	</div>
	<div class="icons">
		<ul class="sunlight">
			<? $sunlight = explode(",",$variety->sunlight);
			foreach($sunlight as $light){
				switch($light){
				case "full":
					echo sprintf("<li><img src='%s'/></li>", base_url("images/sun-icon.png"));
					break;
				case "part":
					echo sprintf("<li><img src='%s'/></li>", base_url("images/part-icon.png"));
					break;
				case "shade":
					echo sprintf("<li><img src='%s'/></li>",base_url("images/shade-icon.png"));
					break;
				}
			}
			?>
		</ul>
		<ul class="flags">
			<? foreach($flags as $flag){
			    if($flag->name == "Poisonous"){
echo sprintf("<li style='background-color:yellow'><img src='%s'/></li>",base_url("images/$flag->thumbnail"));

}else{
				echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
				}
			}?>

		</ul>
	</div>

</div>
	<div class="footer-group">
		<div class="grower-name"><?=get_value($order,"grower_name");?></div>
	</div>
</div>
<div id="crop-failure">
<? if(isset($order) && get_value($order,"crop_failure") == 1):?>
CROP FAILURE
<? endif;?>
</div>