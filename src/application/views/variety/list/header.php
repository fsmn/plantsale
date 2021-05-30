<?php defined('BASEPATH') or exit('No direct script access allowed');

// header.php Chris Dart Mar 2, 2015 2:48:19 PM chrisdart@cerebratorium.com
?>

<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class='search-parameters'>
		<?php if (isset ($options)) : ?>

			<?php $keys = array_keys($options); ?>
			<?php $values = array_values($options); ?>

			<ul>

				<?php for ($i = 0; $i < count($options); $i++): ?>
					<?php if (is_array($values[$i])) {
						$values[$i] = implode(',', $values[$i]);
					} ?>
					<?php if ($keys[$i] == 'no_image'): ?>
						<?php if ($values[$i] == 1): ?>
							<li>
								<strong>Only Showing Varieties without Images</strong></li>
						<?php else: ?>
						<?php endif; ?>
					<?php else: ?>
						<li>
							<?php echo ucwords(clean_string($keys [$i])); ?>
							:&nbsp;<strong><?php echo ucwords(clean_string($values [$i])); ?></strong>
						</li>
					<?php endif; ?>

				<?php endfor; ?>
			</ul>
		<?php else : ?>
			<p>Showing All Varieties</p>
		<?php endif; ?>
		<p>
			<strong>Sort Order</strong>
		</p>
		<?php $sorting = $this->input->get('sorting'); ?>
		<?php $direction = $this->input->get('direction'); ?>
		<?php if (!empty($sorting)): ?>
			<ul>
				<?php for ($i = 0; $i < count($sorting); $i++): ?>
					<li><?php printf('%s, %s', ucwords($sorting[$i]), $direction[$i]); ?></li>
				<?php endfor; ?>
			</ul>
		<?php endif; ?>
		<p>
			Found Count: <strong><?php echo count($plants); ?> Varieties</strong>
		</p>
		<?php
		/*This $action value allows the same interface to toggle
		 *  between generic variety searches and the specialized copyedits search interface with less code.
		 */
		$action = FALSE;
		if ($this->input->get('action') == 'edits') {
			$action = 'edits';
		}
		print create_button_bar([[
				'text' => 'Refine Search',
				'class' => ['button',
						'search',
						'dialog',
						'refine',
				],
				'href' => site_url('variety/search?refine=1'),
		]]); ?>

	</div>
</fieldset>
