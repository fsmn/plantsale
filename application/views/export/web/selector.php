<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="export-list">
<h5>Select the Download for Import to the Website.</h5>
<?=create_button(array("text"=>"Hide","class"=>"button hide-quark-export small","href"=>"#"));?>
	<ul class="list">
	<li class="item"><a href="<?=site_url("index/web/" . get_cookie("sale_year") . "/common");?>">Export Common Names<i class='fa fa-download'></i></a></li>
	<li class="item"><a href="<?=site_url("index/web/" . get_cookie("sale_year") . "/variety");?>">Export Varieties<i class='fa fa-download'></i></a></li>

</ul>
</div>
