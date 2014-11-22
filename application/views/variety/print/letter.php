<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tabloid.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com

?>
<div class="document">
	<div class="header">
	<div class="catalog-number"><?=$order->catalog_number;?></div>
	<div class="common-name"><?=$variety->common_name;?></div>
	</div>
<div class="subheader">
	<div class="latin-name"><?=format_latin_name($variety->genus,$variety->species);?></div>
	<div class="variety"><?=$variety->variety;?></div>
	</div>
	<div class="description-group">
	<div class="image">
		<img src="<?=site_url("files/$variety->image_name");?>" class="photo" />
				<? if($order->count_midsale > 0): ?>
		<div class="saturday-delivery">
		<img src="<?=base_url("images/truck-icon.png");?>"/>
		</div>
	<? endif;?>
</div>
<div class="description-text">
	<div class="description"><?=$variety->description;?></div>
	<div class="note"><?=$variety->note;?></div>
</div>
</div>
<div class="details-group">
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
				echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>
		</ul>
	</div>
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
</div>
	<div class="footer-group">
		<div class="grower-name"><?=get_value($order,"grower_name");?></div>
	</div>
</div>