<?php
defined('BASEPATH') or exit('No direct script access allowed');

// tabloid.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com

$classes = array("document");
if(isset($row_class)){
	$classes[] = implode(" ", $row_class);
}
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
$saturday_delivery = $order->count_midsale?1:0;

$common_size = "";
$length = strlen($variety->common_name);

if($length > 25){
    $common_size = "style='font-size:20pt'";
}elseif($length > 20){
    $common_size = "style='font-size:29pt'";
}
?>
<div class="<?php echo implode(" ",$classes);?>">
	<div class="header">
	<div class="catalog-number"><?php echo $order->catalog_number;?></div>
	<div class="common-name" <?php echo $common_size;?>><?php echo $variety->common_name;?></div>
	</div>
<div class="subheader">
<?php if($saturday_delivery || $variety->new_year == $this->session->userdata("sale_year")):?>
<div class="special-icons">
	<?php if($order->count_midsale > 0): ?>

		<div class="icon saturday-delivery">
		<!-- <img src="<?php echo base_url("images/truck-icon.png");?>"/> -->
		<?php echo format_saturday("poster"); ?>
		</div>

	<?php endif;?>
	<?php if($variety->new_year == $this->session->userdata("sale_year")):?>
<div class="icon is-new">
		<!-- <img src="<?php echo base_url("images/new-icon.png");?>"/> -->
		<?php echo format_new("poster"); ?>
		</div>
		<?php endif;?>
</div>
<?php endif;?>
	<span class="variety"><a href="<?php echo site_url("variety/view/$variety->id");?>" target="_blank"><?php echo $variety->variety;?></a></span>
	<span class="latin-name"><?php echo format_latin_name($variety);?></span>
	</div>
	<div class="description-group">
	<?php if($has_image):?>
	<div class="image">
		<img src="https://nyc3.digitaloceanspaces.com/t7-live-fsmn/db.friendsschoolplantsale.com/files/<?php print $variety->id;?>.jpg" class="photo" alt="image of <?php print $variety->common_name; ?> "/>
</div>
<?php endif;?>
<div class="description-text">
<?php if($variety->print_description):?>
	<div class="print_description"><?php echo $variety->print_description;?></div>
	<?php endif;?>
	<div class="description"><?php echo $variety->description;?></div>
</div>
</div>
<div class="details-group">
	<div class="price-group">
		<div class="pot-size"><?php echo get_value($order,"pot_size");?></div>
		<div class="price"><?php echo get_as_price(get_value($order,"price"));?></div>
	</div>
	<div class="icons">
		<ul class="sunlight">
			<?php
			$sunlight = explode(",",$variety->sunlight);
foreach($sunlight as $light){
			echo sprintf("<li class='%s'>%s</li>",css_classify($light),format_sunlight($light,"poster"));
	}
			?>
		</ul>
		<ul class="flags">
			<?php foreach($flags as $flag){
			    echo sprintf("<li class='%s'>%s</li>",css_classify($flag->name),format_flags(array($flag),"poster"));
				//echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>

		</ul>
	</div>
	<div class="dimensions">
			<?php if($variety->min_height || $variety->max_height):?>
		<div class="height">
			<label>Height</label>
			<div class="text"><?php echo format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit));?></div>
		</div>
	<?php endif;?>
	<?php if($variety->min_width || $variety->max_width):?>
		<div class="width">
			<label>Width</label>
			<div class="text"><?php echo format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit));?></div>
		</div>
	<?php endif;?>
	</div>
</div>
	<div class="footer-group">
		<div class="grower-name"><?php echo get_value($order,"grower_name");?></div>
	</div>
</div>
<!-- <div id="crop-failure"> -->
 <?php if(isset($order) && get_value($order,"received_presale") == "0.000"):?>
<!-- CROP FAILURE -->
 <?php endif;?>
<!-- </div> -->
