<?php
if(!empty($rows) && !empty($types)):?>
<ul class="filters">
<?php foreach($types as $type):?>
	<li class="filter-item"><a href="" data-target="<?php echo $type;?>"><?php echo $type; ?></a></li>
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
<?php foreach($rows as $row): ?>
<?php [$type,$message] = $row;?>
<tr class="file-output <?php print $type; ?>">
	<td><?php echo $type;?></td>
	<td><?php echo $message; ?></td>
</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif;
