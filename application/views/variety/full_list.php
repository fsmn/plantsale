<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div id="plant-box" class="column">
<table class="list">
<?foreach($plants as $plant): ?>
<tr class="plant-row" id="plant-row_<?=$plant->id;?>">
<td class="plant-info inline-list" id="plant-info_<?=$plant->id;?>">
<td class="field year"><?=$plant->year;?></td>
<td class="field genus" id="genus_<?=$plant->common_id;?>"><?=$plant->genus;?></td>
<td class="field species"><?=$plant->species;?></td>
<td class="field common-name" id="common-name_<?=$plant->common_id;?>"><?=$plant->name;?></td>
<td class="field variety"><?=$plant->variety;?></td>

</tr>

<? endforeach;?>
</table>
</div>
<div id="plant-details" class="column float">
</div>