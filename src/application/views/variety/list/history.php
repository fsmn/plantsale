<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

$this->load->view('variety/list/header');
?>


<?php foreach($plants as $plant):?>
<div id="variety-row_<?php print $plant->id;?>" style="padding-top:2em;">

<div id="variety-info">
		<h4><span><a
			href="<?php print site_url(format_string('common/find?genus=@genus', [
					'@genus' => $plant->genus
			]));?>"
			title="View all <?php print $plant->genus;?>"><?php print $plant->genus;?></a></span>&nbsp;
		<span><?php print $plant->species;?></span>&nbsp;
		<span><a href="<?php print site_url('common/view/' . $plant->common_id);?>"
			title="View the details for <?php print $plant->name;?>"><?php print $plant->name;?></a></span>&nbsp;
		<span><a href="<?php print site_url('variety/view/' . $plant->id);?>"
			title="View the details for <?php print $plant->variety;?>"><?php print $plant->variety;?></a></span>
			</h4>
	</div>
<div id="variety-orders" style="max-width: 900px;">
<?php $data['orders'] = $plant->orders;
$this->load->view('order/list', $data);
endforeach; ?>
</div>
</div>

