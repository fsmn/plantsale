<?php defined('BASEPATH') OR exit('No direct script access allowed');
$i = 1;?>

<fieldset class="search-fieldset">
	<legend title="click to show or hide the parameters">Search Parameters</legend>
	<div class='search-parameters'>
	<? if (isset ( $options )) : ?>

		<? $keys = array_keys ( $options ); ?>
		<? $values = array_values ( $options ); ?>

		<ul>

		<? for($i = 0; $i < count ( $options ); $i ++):?>
       	<? if(is_array($values[$i])){
       		$values[$i] = implode(",",$values[$i]);
       	}?>
       	<? if($keys[$i] == "no_image"): ?>
       	<? if($values[$i] == 1 ): ?>
       	        	<li>
       	  <strong>Only Showing Varieties without Images</strong></li>
       	  <?else: ?>
       	  <?endif;?>
       	<? else:?>
       	<li>
       	<? echo ucwords(clean_string($keys [$i])); ?>:&nbsp;<strong><?=ucwords(clean_string($values [$i]));?></strong>
</li>
       <?	endif;?>

		<? endfor;?>
		</ul>
	<?  else : ?>
		<p>Showing All Varieties</p>
	<? endif; ?>
<p>
		<strong>Sort Order</strong>
	</p>
<? $sorting = $this->input->get("sorting"); ?>
<? $direction = $this->input->get("direction");?>
<ul>
<? for($i = 0; $i < count($sorting); $i++):?>
<li><? printf("%s, %s", ucwords($sorting[$i]), $direction[$i]); ?></li>
<? endfor; ?>
</ul>
<p>
Found Count: <strong><?=count($plants);?> Varieties</strong>
</p>
<?php echo create_button_bar(array(array("text"=>"Refine Search","class"=>array("button","search-varieties","refine"))));?>

	</div>
</fieldset>
<?
$buttons[] = array("text"=>"Print Tabloid","class"=>"button print variety-print-tabloid","href"=>site_url("variety/print_result/tabloid"),"target"=>"_blank");
$buttons[] = array("text"=>"Print Statement","class"=>"button print variety-print-statement","href"=>site_url("variety/print_result/statement"), "target"=>"_blank");
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
			<?=form_checkbox(array("name"=>"omit","value"=>1, "title"=>"Omit this plant from printing","id"=>"omit-plant_$plant->order_id","checked"=>$checked,"class"=>"omit-row omit"));?></td>
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