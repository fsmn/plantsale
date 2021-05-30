<?php
defined('BASEPATH') or exit ('No direct script access allowed');

// tabloid.php Chris Dart May 20, 2014 7:58:21 PM chrisdart@cerebratorium.com
$classes = [
		'document'
];
$has_image = TRUE;
if (!$variety->image_name) {
	$classes [] = 'no-image';
	$has_image = FALSE;
}
if (isset ($row_class)) {
	$classes [] = implode(' ', $row_class);
}
$saturday_delivery = $order->count_midsale ? 1 : 0;
?>
<div class="<?php print implode(' ', $classes); ?>">
	<div class="header">
		<div class="catalog-number"><?php print $order->catalog_number; ?></div>
		<div class="common-name"><?php print $variety->common_name; ?></div>
	</div>
	<div class="subheader">
		<?php if ($saturday_delivery || $variety->new_year == $this->session->userdata('sale_year')): ?>
			<div class="special-icons">
				<?php if ($order->count_midsale > 0): ?>

					<div class="icon saturday-delivery">
						<!-- <img src="<?php print base_url('images/truck-icon.png'); ?>"/> -->
						<?php print format_saturday('poster'); ?>
					</div>

				<?php endif; ?>
				<?php if ($variety->new_year == $this->session->userdata('sale_year')): ?>
					<div class="icon is-new">
						<!-- <img src="<?php print base_url('images/new-icon.png'); ?>"/> -->
						<?php print format_new('poster'); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<span class="variety">
			<a href="<?php print site_url('variety/view/' . $variety->id); ?>"
			   target="_blank"><?php print $variety->variety; ?></a>
		</span>
		<span class="latin-name"><?php print format_latin_name($variety); ?></span>
	</div>
	<div class="description-group">
	<?php if($has_image):?>
	<div class="image">
		<img src="/files/<?php print $variety->id;?>.jpg<?php print '?cache='. date('U');?>" class="photo" alt="image of <?php print $variety->common_name; ?> "/>
		</div>
	<?php endif;?>
	<div class="description-text">
	<?php if($variety->print_description):?>
	<div class="print_description"><?php print $variety->print_description;?></div>
	<?php endif;?>
	<div class="description"><?php print $variety->description;?></div>
		</div>
	</div>
	<div class="details-group">
		<div class="price-group">
			<div class="pot-size"><?php print get_value($order, 'pot_size'); ?></div>
			<div class="price"><?php print get_as_price(get_value($order, 'price')); ?></div>

		</div>
		<div class="icons">
			<ul class="sunlight">
				<?php
				$sunlight = explode(',', $variety->sunlight);
				foreach ($sunlight as $light) {
					print format_string('<li class="@class">@sunlight</li>', [
							'@class' => css_classify($light),
							'@sunlight' => format_sunlight($light, 'poster'),
					]);
				}
				?>
			</ul>
			<ul class="flags">
				<?php

				foreach ($flags as $flag) {
					print format_string('<li class="@class">@flag</li>', [
							'@class' => css_classify($flag->name),
							'@flag' => format_flags([$flag], 'poster'),
					]);
					// print sprintf("<li><img src='%s'/></li>",base_url("images/$flag->thumbnail"));
				}
				?>

			</ul>
		</div>
		<div class="dimensions">
			<?php if ($variety->min_height || $variety->max_height): ?>
				<div class="height">
					<label>Height</label>
					<div class="text">
						<?php print format_dimensions($variety->min_height, $variety->max_height, abbr_unit($variety->height_unit)); ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($variety->min_width || $variety->max_width): ?>
				<div class="width">
					<label>Width</label>
					<div class="text">
						<?php print format_dimensions($variety->min_width, $variety->max_width, abbr_unit($variety->width_unit)); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="footer-group">
		<div class="grower-name"><?php print get_value($order, 'grower_name'); ?></div>
	</div>
</div>

