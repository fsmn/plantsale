<?php
if (!empty($file_list)) : ?>
	<table class="table">
		<thead></thead>
		<tbody>
			<?php foreach ($file_list as $item) : ?>
				<tr>
					<td><a href="<?php print base_url('logs/read/' . $item); ?>"><?php print $item; ?></a></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;
