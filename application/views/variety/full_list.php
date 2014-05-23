<?php defined('BASEPATH') OR exit('No direct script access allowed');
$i = 1;
?>
<h4>Click on a plant to view details. Press "tab" or "shift-tab" to move up and down the list"</h4>
<?=create_button_bar(array(array("text"=>"Print Tabloid","class"=>"button print variety-print-tabloid","href"=>site_url("variety/print_result/tabloid"),"target"=>"_blank","selection"=>"print")));?>

<div id="plant-box" class="column">
	<div>
	<?foreach($plants as $plant): ?>
	<? $checked = "";?>
	<? if($plant->print_omit ==1 ):?>
	<? $checked = "checked";?>
	<? endif;?>
		<div class="plant-row" tabindex=<?=$i;?> id="plant-row_<?=$plant->id;?>">
		<ul class="plant-info inline-list" id="plant-info_<?=$plant->id;?>">
			<li class="field omit-plant"><?=form_checkbox(array("name"=>"omit","value"=>1, "title"=>"Omit this plant","id"=>"omit-plant_$plant->order_id","checked"=>$checked));?></li>
			<li class="field year"><?=$plant->year;?></li>
			<li class="field genus"><span id="genus_<?=$plant->common_id;?>"><?=$plant->genus;?></span>
			&nbsp;<span class="species"><?=$plant->species;?></span></li>
			<li class="field common-name"><span id="common-name_<?=$plant->common_id;?>"><?=$plant->name;?></span>
			<span class="variety"><?=$plant->variety;?></span></li>
		</ul>
		</div>
		<? $i++;?>
	<? endforeach;?>
	</div>
</div>
<div id="plant-details" class="column float">
</div>