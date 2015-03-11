<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view("variety/list/header");
$i = 1;
$buttons[] = array("text"=>"Print Tabloid","class"=>"button print variety-print-tabloid","href"=>site_url("variety/print_result/tabloid"),"target"=>"_blank");
$buttons[] = array("text"=>"Print Statement","class"=>"button print variety-print-statement","href"=>site_url("variety/print_result/statement"), "target"=>"_blank");
$buttons[] = array("text"=>"Print Letter","class"=>"button print variety-print-letter","href"=>site_url("variety/print_result/letter"), "target"=>"_blank");

if(IS_ADMIN){
$buttons[] = array("text"=>"Batch Flag Update","title"=>"Batch update flags for the listed items", "class"=>"button batch-update-flags edit","href"=>$_SERVER['REQUEST_URI']);
}
print create_button_bar($buttons);
?>

<h4>Click on a plant to view details. Press "tab" or "shift-tab" to move up and down the list. Check items you do NOT want to print.</h4>

<div id="plant-box" class="column">
	<table class="list">
	<thead>
	<tr>
	<th></th>
	<th>Year</th>
	<th>Latin Name</th>
	<th>Commmon Name</th>
	<th>Variety</th>
	<!-- <th>Pot Size</th>  -->
	</tr>
	</thead>
	<tbody>
	<?foreach($plants as $plant): ?>
		<? $checked = "";?>
		<? $class = "print"; ?>
		<? if($plant->omit ==1 ):?>
			<? $checked = "checked";?>
			<? $class = "omitted"; ?>
		<? endif;?>
		<tr class="plant-row plant-info inline-list <?=$class; ?>" tabindex=<?=$i;?> id="plant-info_<?=$plant->id;?>" >
			<td class="field omit-plant">
			<?=form_checkbox(array("name"=>"omit","value"=>1, "title"=>"Omit this plant from printing","id"=>"omit-plant_$plant->id","checked"=>$checked,"class"=>"omit-row omit plant-info"));?></td>
			<td class="field year"><?=$plant->year;?></td>
			<td class="field latin-name"><?=format_latin_name($plant->genus,$plant->species);?></td>
			<td class="field common-name"><?=$plant->name;?></td>
			<td class="field variety"><?=$plant->variety;?></td>
			<!-- <td class="field pot-size"><?=$plant->pot_size;?></td> -->
		</tr>
		<? $i++;?>
	<? endforeach;?>
	</tbody>
	</table>
</div>
<div id="plant-details" class="column float">
</div>