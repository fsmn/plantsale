<?php
defined('BASEPATH') or exit('No direct script access allowed');
$classes = array("document");
$has_image = TRUE;
if(!$variety->image_name){
    $classes[] = "no-image";
    $has_image = FALSE;
}
if(isset($row_class)){
	$classes[] = implode(" ", $row_class);
}
?>
<div class="<?php echo implode(" ",$classes);?>">
<div id="header">
	<div class="header left">
	<div class="catalog-number"><?php echo $order->catalog_number;?></div>
	</div>
	<div class="header right">
	<div class="common-name"><?php echo $variety->common_name;?></div>
	<div class="latin-name"><?php echo format_latin_name($variety);?></div>
	<div class="variety-name">

	<span class="variety"><a href="<?php echo site_url("variety/view/$variety->id");?>" target="_blank"><?php echo $variety->variety;?></a></span>
		<?php if($variety->new_year == $this->session->userdata("sale_year")):?>
		<span class="is-new">
		<!-- <img src="<?php echo base_url("images/new-icon.png");?>"/> -->
		<?php echo format_new("poster"); ?>
		</span>
		<?php endif;?>
	</div>
	
	<ul class="flags icons">
			<?php foreach($flags as $flag){
			    echo sprintf("<li class='%s'>%s</li>",css_classify($flag->name),format_flags(array($flag),"poster"));
				//echo sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
			}?>
			
			<?php
			if(get_value($variety,"sunlight")){
			$sunlight = explode(",",$variety->sunlight);
			foreach($sunlight as $light){
				echo sprintf("<li class='%s'>%s</li>",css_classify($light),format_sunlight($light,"poster"));
			}
			}
			?>
		</ul>
		<div class="dimensions">
	<?php if($variety->min_width || $variety->max_width):?>
		<div class="width">
			<div class="text"><?php echo format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit, TRUE));?>w</div>
		</div>
		<?php endif;?>
		<?php if($variety->min_height || $variety->max_height):?>
		<div class="height">
			<div class="text"><?php echo format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit, TRUE));?>h</div>
		</div>
		<?php endif;?>
	</div>
		
	</div>
</div>	
		<div class="copy">
	<div class="description"><?php echo $variety->description;?></div>
	<div class="print_description"><?php echo $variety->print_description;?></div>
	</div>

	<?php if($has_image):?>
	<div class="image">
		<img src="https://nyc3.digitaloceanspaces.com/t7-live-fsmn/db.friendsschoolplantsale.com/files/<?php print $variety->id;?>.jpg" class="photo" alt="image of <?php print $variety->common_name; ?> "/>
				
</div>
<?php endif;?>
<div class="details">
		<div class="grower-name"><?php echo get_value($order,"grower_name");?></div>
		<div class="price-group">
		
		<span class="pot-size"><?php echo get_value($order,"pot_size");?></span> 
		<span class="price"><?php echo get_as_price(get_value($order,"price"));?></span>
	</div>
</div>
</div>


<?php $classes = array();
