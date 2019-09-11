<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$this->load->view("variety/list/header");
?>


<?php foreach($plants as $plant):?>
<div id="variety-row_<?php echo $plant->id;?>" style="padding-top:2em;">

<div id="variety-info">
		<h4><span><a
			href="<?php echo site_url(sprintf("common/find?genus=%s",$plant->genus));?>"
			title="View all <?php echo $plant->genus;?>"><?php echo $plant->genus;?></a></span>&nbsp;
		<span><?php echo $plant->species;?></span>&nbsp;
		<span><a href="<?php echo site_url("common/view/$plant->common_id");?>"
			title="View the details for <?php echo $plant->name;?>"><?php echo $plant->name;?></a></span>&nbsp;
		<span><a href="<?php echo site_url("variety/view/$plant->id");?>"
			title="View the details for <?php echo $plant->variety;?>"><?php echo $plant->variety;?></a></span>
			</h4>
	</div>
<div id="variety-orders" style="max-width: 900px;">
<?php $data["orders"] = $plant->orders;
$this->load->view("order/list",$data);
endforeach; ?>
</div>
</div>

