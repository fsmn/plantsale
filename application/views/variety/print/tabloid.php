<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tabloid.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com

?>
<div class="document" style="page-break-inside: avoid;page-brea-after: always;">
	<div class="catalog-number"><?=format_catalog($variety->id,$variety->category);?></div>
	<div class="common-name"><?=$variety->common_name;?></div>
	<div class="latin-name"><?=format_latin_name($variety->genus,$variety->species);?></div>
	<div class="variety"><?=$variety->variety;?></div>
	<div class="image">
		<img src="<?=site_url("files/$variety->image_name");?>" />
	</div>
	<div class="description"><?=$variety->description;?></div>
	<div class="note"><?=$variety->note;?></div>
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
				case "full_sun":
					echo sprintf("<li><img src='%s'/></li>", base_url("images/sun-icon.png"));
					break;
				case "part_sun":
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
				<div class="text"><?=format_dimensions($variety->min_width, $variety->max_width, $variety->width_unit);?></div>
			</div>
			<?endif;?>
			<? if($variety->min_height):?>
			<div class="height">
				<label>Height</label>
				<div class="text"><?=format_dimensions($variety->min_height, $variety->max_height, $variety->height_unit);?></div>
			</div>
			<?endif;?>
		</div>
		<div class="grower-name"><?=get_value($order,"grower_name");?></div>
	</div>
	<div class="internals">
		<div class="year">Year: <?=get_value($order,"year");?></div>
		<div class="grower"><?=get_value($order,"grower_id");?></div>
	</div>
</div>