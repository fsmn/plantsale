<?php defined('BASEPATH') OR exit('No direct script access allowed');
$i = 1;

?>
<div id="plant-box" class="column">
<div>
<?foreach($plants as $plant): ?>
<div class="plant-row" tabindex=<?=$i;?> id="plant-row_<?=$plant->id;?>">
<ul class="plant-info inline-list" id="plant-info_<?=$plant->id;?>">
<li class="field year"><?=$plant->year;?></li>
<li class="field genus" id="genus_<?=$plant->common_id;?>"><?=$plant->genus;?></li>
<li class="field species"><?=$plant->species;?></li>
<li class="field common-name" id="common-name_<?=$plant->common_id;?>"><?=$plant->name;?></li>
<li class="field variety"><?=$plant->variety;?></li>
</ul>
</div>
<? $i++;?>
<? endforeach;?>
</div>
</div>
<div id="plant-details" class="column float">
</div>