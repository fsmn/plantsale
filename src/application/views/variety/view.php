<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (isset($variety)): ?>
	<input type="hidden" id="id" name="id" value="<?php print $variety->id; ?>"/>
	<input type="hidden" id="order_id" name="order_id"
		   value="<?php print get_value($current_order, 'id'); ?>"/>
	<h2>
		<?php print $variety->common_name . ': ' . $variety->variety; ?>
	</h2>

	<?php $this->load->view('variety/menu'); ?>
	<div class="grouping block variety-info" id="variety">
		<div class="triptych">
			<h4>Basic Variety Info</h4>
			<?php print edit_field('variety', $variety->variety, 'Variety', 'variety', $variety->id, ['envelope' => 'p']); ?>

			<p><label for="genus">Genus:&nbsp;</label>
				<span class='field'><?php print $variety->genus; ?></span>
			</p>

			<?php print edit_field('species', $variety->species, 'Species', 'variety', $variety->id, ['envelope' => 'p']); ?>

			<fieldset class="field-group inline-box">
				<legend class="label">
					<strong>Height</strong>
				</legend>

				<div class="field-set">
					<?php print edit_field('min_height', clean_decimal($variety->min_height), 'Min', 'variety', $variety->id, ['envelope' => 'span']); ?>
				</div>
				<div class="field-set">
					<?php print edit_field('max_height', clean_decimal($variety->max_height), 'Max', 'variety', $variety->id, ['envelope' => 'span']); ?>
				</div>
				<div class="field-set">
					<?php print edit_field('height_unit', $variety->height_unit, 'Measure', 'variety', $variety->id, [
							'class' => 'dropdown',
							'attributes' => 'menu="measure_unit"',
							'envelope' => 'span',
					]); ?>
				</div>
			</fieldset>
			<fieldset class="field-group inline-box">
				<legend class="label">
					<strong>Width</strong>
				</legend>

				<div class="field-set">
					<?php print edit_field('min_width', clean_decimal($variety->min_width), 'Min', 'variety', $variety->id, ['envelope' => 'span']); ?>
				</div>
				<div class="field-set">
					<?php print edit_field('max_width', clean_decimal($variety->max_width), 'Max', 'variety', $variety->id, ['envelope' => 'span']); ?>
				</div>
				<div class="field-set">
					<?php print edit_field('width_unit', $variety->width_unit, 'Measure', 'variety', $variety->id, [
							'class' => 'dropdown',
							'attributes' => 'menu="measure_unit"',
							'envelope' => 'span',
					]); ?>
				</div>

			</fieldset>
			<div>
				<?php print edit_field('churn_value', clean_decimal($variety->churn_value), 'Churn Value', 'variety', $variety->id, [
						'class' => 'dropdown',
						'attributes' => 'menu="churn_value"',
				]); ?>
			</div>

			<?php print edit_field('plant_color', $variety->plant_color, 'Plant Color(s)', 'variety', $variety->id, [
					'class' => 'multiselect',
					'attributes' => 'menu="plant_color"',
					'format' => 'multiselect',
			]); ?>

			<div class="column odd" id="flags">
				<h4>Flags</h4>
				<div class="flag-list"
					 id="flag-list_<?php print $variety->id; ?>">
					<?php $this->load->view('flag/list'); ?>

				</div>
				<?php if (IS_EDITOR): ?>
					<?php $flag_buttons[] = [
							'selection' => 'flag',
							'text' => 'New Flag',
							'type' => 'span',
							'class' => 'button new flag-add',
							'id' => 'fa_' . $variety->id,
					]; ?>
					<?php print create_button_bar($flag_buttons); ?>
				<?php endif; ?>
			</div>
			<div class="column even" id="is-new">
				<h4>Sale Year</h4>
				<?php print edit_field('new_year', $variety->new_year, 'First Year at Sale', 'variety', $variety->id, ['envelope' => 'p']); ?>
				<?php if (!empty($is_new)): ?>
					<span class="is-new">
				<img src="<?php print site_url('images/new.gif'); ?>"/>
			</span>
				<?php endif; ?>
			</div>
		</div>


		<div class='common-info triptych'>
			<h4>Common Info</h4>
			<p>
				<label>Common Name:</label>
				<span class="field">
				<a href="<?php print site_url('common/view/' . $variety->common_id); ?>"
				   title="View details for <?php print $variety->common_name; ?>"><?php print $variety->common_name; ?></a>
			</span>
				<?php if ($this->ion_auth->in_group(1)): ?>&nbsp;
					<?php

					print create_button([
							'text' => 'Change',
							'class' => [
									'button',
									'edit',
									'change-common',
									'small',
							],
							'data_values' => [
									'variety_id' => $variety->id,
							],
							'id' => 'change-common_' . $variety->id,
					]);

					?>
				<?php endif; ?>
			</p>
			<p>
				<label>Other Names:</label>
				<span class="field">
		<?php print $variety->other_names; ?></span>
			</p>
			<p class="category">
				<label>Category: </label>
				<span class="field"><?php print $variety->category; ?>
			</span>
				<label>Subcategory: </label>
				<span class="field"><?php print $variety->subcategory; ?>
			</span>
			</p>
			<p class="sunlight">
				<label>Sunlight: </label>
				<span class="field"><?php print $variety->sunlight; ?></span>
			</p>

			<div class="well block">
				<h4>Image</h4>
				<div id="image">
					<?php $this->load->view('image/view', [
							'variety' => $variety,
							'file_path' => $file_path,
					]); ?>
				</div>
			</div>
		</div>
		<div class='description-info triptych'>

			<h4>Copy Editing</h4>
			<p>
				<?php print edit_field('editor', $variety->editor, 'Editor', 'variety', $variety->id, [
						'class' => 'user-dropdown',
						'attributes' => 'menu="users"',
						'envelope' => 'span',
				]); ?>

				<?php print edit_field('copywriter', $variety->copywriter, 'Copywriter', 'variety', $variety->id, ['envelope' => 'span']); ?>

			</p>
			<p>

				<?php print edit_field('needs_copy_review', $variety->needs_copy_review, 'Needs Copy', 'variety', $variety->id, [
						'class' => 'dropdown',
						'attributes' => 'menu="boolean"',
						'envelope' => 'span',
				]); ?>
				<?php print edit_field('copy_received', $variety->copy_received, 'Copy Received', 'variety', $variety->id, [
						'class' => 'dropdown',
						'attributes' => 'menu="boolean"',
						'envelope' => 'span',
				]); ?>

			</p>
			<p class="description">
				<?php print edit_field('edit_notes', $variety->edit_notes, 'Copy Editing Notes', 'variety', $variety->id, [
						'class' => 'textarea',
						'envelope' => 'span',
				]); ?>

			</p>
			<div class="well">
				<h4>Descriptions</h4>
				<p class="description">
					<?php print edit_field('description', $variety->description, 'General Description (from Common)', 'common', $variety->common_id, [
							'class' => 'textarea',
							'envelope' => 'span',
					]); ?>

				</p>
				<p class="print_description">

					<?php print edit_field('print_description', $variety->print_description, 'Variety Description', 'variety', $variety->id, [
							'class' => 'textarea',
							'envelope' => 'span',
					]); ?>
				</p>
				<p class="web_description">

					<?php print edit_field('web_description', $variety->web_description, 'Variety Web Description', 'variety', $variety->id, [
							'class' => 'textarea',
							'envelope' => 'span',
					]); ?>
				</p>


			</div>
		</div>
	</div>
	<div class="all-orders block">

		<?php if (needs_bag($orders)): ?>
			<p>
				<span class="message">Based on the pot size, this variety will require a bag for packaging.</span>
			</p>
		<?php endif; ?>
		<h3>Orders</h3>
		<?php
		$data = [
				'orders' => $orders,
				'show_names' => FALSE,
		];
		$this->load->view('order/list', $data);
		?>

	</div>
	<?php
	$order_buttons [] = [
			'selection' => 'order',
			'text' => 'New Order',
			'href' => site_url('order/create/?variety_id=' . $variety->id),
			'class' => 'button new create dialog order-create',
			'id' => 'oc_' . $variety->id,
	];
	print create_button_bar($order_buttons);
endif;
