<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

// orphans.php Chris Dart Jan 12, 2015 3:47:05 PM chrisdart@cerebratorium.com
$sale_year = $this->session->userdata("sale_year");
?>
<h3><?php echo $title;?></h3>
<p><?php echo $message;?></p>
<?php if($orphans): ?>
<table class="list">
	<thead>
		<tr>
			<th>Grower ID</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach($orphans as $orphan):?>
<tr>
			<td>
<?php echo $orphan->grower_id;?>
</td>
			<td>
			<?php echo create_button(array("text"=>"Add Grower","class"=>array("button","new"),"href"=>site_url("grower/create/$orphan->grower_id"),"title"=>"Create a new record for this grower"));?>
			</td>
			<td>
			<?php echo create_button(array("text"=>"Show Orders","class"=>array("button","details"),"href"=>site_url("order/search?grower_id=$orphan->grower_id&year=$sale_year&sorting%5B%5D=genus&direction%5B%5D=ASC"),"title"=>"Show orders for this orphan groer"));?></td>
		</tr>

<?php endforeach;?>
</tbody>
</table>
<?php endif;Ω