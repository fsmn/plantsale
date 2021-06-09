<?php
defined('BASEPATH') or exit('No direct script access allowed');
$classes = array("document");
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
$saturday_delivery = $order->count_midsale?1:0;
if(isset($row_class)){
	$classes[] = implode(" ", $row_class);
}
?>
<div class="<?php echo implode(" ",$classes);?>">
	<div class="header">
	<div class="catalog-number"><?php echo $order->catalog_number;?></div>
	<div class="common-name"><?php echo $variety->common_name;?></div>
	</div>

<div class="subheader">
<?php if($saturday_delivery):?>
<span class="saturday-delivery">
		<!-- <img src="<?php echo base_url("images/truck-icon.png");?>"/> -->
		<?php echo format_saturday("poster"); ?>
		</span>
		<?php endif;?>
	<span class="latin-name<?php echo $saturday_delivery?' saturday':'';?>"><?php echo format_latin_name($variety);?></span>
	<div class="variety-name">
	<?php if($variety->new_year == $this->session->userdata("sale_year")):?>
<span class="is-new">
		<!-- <img src="<?php echo base_url("images/new-icon.png");?>"/> -->
		<?php echo format_new("poster"); ?>
		</span>
		<?php endif;?>
	<span class="variety"><a href="<?php echo site_url("variety/view/$variety->id");?>" target="_blank"><?php echo $variety->variety;?></a></span>
	</div>
	</div>
	<div class="description-group">
	<?php if($has_image):?>
	<div class="image">
		<img src="/files/<?php print $variety->id;?>.jpg<?php print '?cache='. date('U');?>" class="photo" alt="image of <?php print $variety->common_name; ?> "/>				<ul class="flags icons">
			<?php foreach($flags as $flag){
			    echo sprintf("<li class='%s'>%s</li>",css_classify($flag->name),format_flags(array($flag),"poster"));
				//echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>
		</ul>
</div>
<?php endif;?>
<div class="details">
<div class="price-group">
		<div class="pot-size"><?php echo get_value($order,"pot_size");?></div>
		<div class="price"><?php echo get_as_price(get_value($order,"price"));?></div>
	</div>
<div class="icons-dimensions">
<ul class="sunlight icons">
	<?php
			$sunlight = explode(",",$variety->sunlight);
			foreach($sunlight as $light){
				echo sprintf("<li class='%s'>%s</li>",css_classify($light),format_sunlight($light,"poster"));
			}
			?>
		</ul>
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
	<div class="copy">
	<?php if($variety->print_description):?>
	<div class="print_description"><?php echo $variety->print_description;?></div>
	<?php endif;?>
	<div class="description"><?php echo $variety->description;?></div>
	</div>

</div>
</div>



	<div class="footer-group">
		<div class="grower-name"><?php echo get_value($order,"grower_name");?></div>
	</div>
</div>

<?php $classes = array();
