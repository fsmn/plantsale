<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<h4><?php echo $variety->common_name; ?><?php echo $variety->variety; ?></h4>
<?php if ($is_new): ?>
	<div id="is_new">
	<span class="is_new">
		<img src="<?php echo site_url("images/new.gif"); ?>"/>
		Is New
	</span>
	</div>
<?php endif; ?>
<div class="variety-mini-view">
	<div class="grouping block variety-info" id="variety">
		<div class="block" id="image">
			<?php $this->load->view("image/view"); ?>

		</div>
		<p tabindex=1>
			<?php echo edit_field("variety", $variety->variety, "Variety", "variety", $variety->id, ["envelope" => "span"]); ?>
			<?php echo create_button([
					"text" => "Edit",
					"class" => "button edit small variety-edit",
					"id" => "edit-variety_$variety->id",
					"href" => site_url("variety/view/$variety->id"),
					"selection" => "home",
			]); ?>
		</p>
		<p>
			<?php echo edit_field("new_year", $variety->new_year, "First Year at Sale", "variety", $variety->id, ["envelope" => "span"]); ?>
			<?php if ($is_new): ?>
				<span class="is-new">
				<img src="<?php echo site_url("images/new.gif"); ?>"/>
			</span>
			<?php endif; ?>
		</p>
		<p>
			<span class='field-set'>
				<label for="genus">Genus:&nbsp;</label>
				<span class='field'><?php echo $variety->genus; ?></span>
			</span>
		</p>
		<p>
			<span class='field-set'>
			<?php echo edit_field("species", $variety->species, "Species", "variety", $variety->id, ["envelope" => "span"]); ?>
		</span>
		</p>
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Height</strong>
			</legend>

			<div class="field-set">
				<div class="field-envelope"
					 id="variety__min_height__<?php echo $variety->id; ?>">
					<label>Min:&nbsp;</label>
					<span class="live-field text" name="min_height">
						<input type="text" name="min_height"
							   value="<?php echo clean_decimal($variety->min_height); ?>"
							   id="min-height_<?php echo $variety->id; ?>"
							   size="6" category="">
					</span>
				</div>
			</div>
			<div class="field-set">
				<div class="field-envelope"
					 id="variety__max_height__<?php echo $variety->id; ?>">
					<label>Max:&nbsp;</label>
					<span class="live-field text" name="max_height">
						<input type="text" name="max_height"
							   value="<?php echo clean_decimal($variety->max_height); ?>"
							   id="max-height_<?php echo $variety->id; ?>"
							   size="5" category="">
					</span>
				</div>
			</div>
			<div class="field-set">
				<div class="field-envelope"
					 id="variety__height_unit__<?php echo $variety->id; ?>">
					<label>Measure:&nbsp;</label>
					<span class="dropdown live-field text" menu="measure_unit"
						  name="height_unit">
<?php echo form_dropdown("height_unit", [
		"0" => "",
		"Feet" => "Feet",
		"Inches" => "Inches",
], get_value($variety, "height_unit"), "class='live-field'"); ?>
</span>
				</div>
			</div>
		</fieldset>
		<fieldset class="field-group inline-box">
			<legend class="label">
				<strong>Width</strong>
			</legend>

			<div class="field-set">
				<div class="field-envelope"
					 id="variety__min_width__<?php echo $variety->id; ?>">
					<label>Min:&nbsp;</label>
					<span class="live-field text" name="min_width">
						<input type="text" name="min_width"
							   value="<?php echo clean_decimal($variety->min_width); ?>"
							   id="min-width_<?php echo $variety->id; ?>"
							   size="5">
					</span>
				</div>
			</div>
			<div class="field-set">
				<div class="field-envelope"
					 id="variety__max_width__<?php echo $variety->id; ?>">
					<label>Max:&nbsp;</label>
					<span class="live-field text" name="max_width">
						<input type="text" name="max_width"
							   value="<?php echo clean_decimal($variety->max_width); ?>"
							   id="max-width_<?php echo $variety->id; ?>"
							   size="5">
					</span>
				</div>
			</div>
			<div class="field-set">

				<div class="field-envelope"
					 id="variety__width_unit__<?php echo $variety->id; ?>">
					<label>Measure:&nbsp;</label>
					<span class="dropdown live-field text" menu="measure_unit"
						  name="width_unit">
<?php echo form_dropdown("width_unit", [
		"0" => "",
		"Feet" => "Feet",
		"Inches" => "Inches",
], get_value($variety, "width_unit"), "class='live-field'"); ?>

</span>
				</div>
			</div>

		</fieldset>
		<div>
			<?php echo edit_field("churn_value", clean_decimal($variety->churn_value), "Churn Value", "variety", $variety->id, [
					"class" => "dropdown",
					"attributes" => "menu='churn_value'",
			]); ?>
		</div>
		<div><?php echo edit_field("plant_color", $variety->plant_color, "Plant Color(s)", "variety", $variety->id, [
					"class" => "multiselect",
					"attributes" => "menu='plant_color'",
					"class" => "multiselect",
					"format" => "multiselect",
			]); ?></div>
		<p>
			<span>
				<label>Common Name:</label>
				<span class="field">
					<a href="<?php echo site_url("common/view/$variety->common_id"); ?>"><?php echo $variety->common_name; ?></a>
				</span>
			</span>
			<span>
				<label>Other Names:</label>
				<span class="field">
		<?php echo $variety->other_names; ?></span>
			</span>
		</p>
		<p class="category">
			<label>Category: </label>
			<span class="field"><?php echo $variety->category; ?>
			</span>
		</p>
		<p class="subcategory">
			<label>Subcategory: </label>
			<span class="field"><?php echo $variety->subcategory; ?>
			</span>
		</p>
		<p class="sunlight">
			<label>Sunlight: </label>
			<span class="field"><?php echo $variety->sunlight; ?></span>
		</p>
		<div class="flag-list" id="flag-list_<?php echo $variety->id; ?>">
			<?php $this->load->view("flag/list"); ?>
		</div>
		<?php if (IS_EDITOR): ?>
			<?php $flag_buttons[] = [
					"selection" => "flag",
					"text" => "New Flag",
					"type" => "span",
					"class" => "button new small flag-add",
					"id" => "fa_$variety->id",
			]; ?>
			<?php echo create_button_bar($flag_buttons); ?>
		<?php endif; ?>
		<div class="field-envelope"
			 id="variety__needs_copy_review__<?php echo $variety->id; ?>">
			<label>Needs Review:</label>
			<span class="dropdown live-field text" menu="boolean"
				  name="boolean">
<?php echo form_dropdown("needs_copy_review", [
		"0" => "",
		"no" => "No",
		"yes" => "Yes",
], get_value($variety, "needs_copy_review"), "class='live-field'"); ?>

</span>

		</div>
		<p class="description">
			<?php echo live_field('description', $variety->description, 'common', $variety->common_id, [
					'class' => 'textarea',
					'label' => 'Common Description',
					'envelope' => 'span',
					'type' => 'textarea',
			]); ?>

		</p>
		<p class="print_description">

			<?php echo live_field('print_description', $variety->print_description, 'variety', $variety->id, [
					'class' => 'textarea',
					'label' => 'Description',
					'envelope' => 'span',
					'type' => 'textarea',
			]); ?>
		</p>
		<p class="web_description">

			<?php echo live_field('web_description', $variety->web_description, 'variety', $variety->id, [
					'type' => 'textarea',
					'class' => 'textarea',
					'label' => 'Web Description',
					'envelope' => 'span',
			]); ?>
		</p>
	</div>
</div>
