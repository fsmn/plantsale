<?php
if(!empty($file_list)):?>
<table class="table">
	<thead></thead>
	<tbody>
	<?php foreach($file_list as $item):?>
	<tr>
		<td><a href="<?php echo base_url('logs/read/' . $item);?>"><?php echo $item;?></a></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php endif;
