<?php defined('BASEPATH') OR exit('No direct script access allowed');

// batch_flag_list.php Chris Dart Mar 2, 2015 2:19:06 PM chrisdart@cerebratorium.com
$this->load->view("variety/list/header");
foreach($plants as $variety):?>
<h4><?=$variety->genus . "&nbsp;" . $variety->variety;?> (<?=format_latin_name($variety);?>) <a href="<?=site_url("variety/view/$variety->id");?>">View</a></h4>
			<div class="flag-list" id="flag-list_<?=$variety->id;?>">
<? $data = array("flags"=>$variety->flags);?>
<? $this->load->view("flag/list",$data);?>
	</div>

	<? if(IS_EDITOR):?>
			<? $flag_buttons = array("selection"=>"flag","text"=>"New Flag","type"=>"span","class"=>"button small new flag-add","id"=>"fa_$variety->id");?>
			<?=create_button($flag_buttons);?>
	<?endif;?>

<? endforeach;