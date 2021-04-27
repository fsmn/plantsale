<?php
if (!empty($rows) && !empty($types)) : ?>
	<ul class="filters">
		<?php foreach ($types as $type) : ?>
			<li class="filter-item"><a href="" data-target="<?php print
			 $type; ?>"><?php print
			 $type; ?></a></li>
		<?php endforeach; ?>
	</ul>
	<table class="log-list">
		<thead>
			<tr>
				<th>Type</th>
				<th>Message</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($rows as $row) : ?>
				<?php [$type, $message] = $row; ?>
				<tr class="file-output <?php print $type; ?>">
					<td><?php print
					 $type; ?></td>
					<td><?php print
					 $message; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
