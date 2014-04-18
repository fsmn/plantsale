<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<form name="set_sale_year" id="set_sale_year" action="<?=base_url("index/set_year");?>" method="get">
<input type="hidden" name="uri" id="uri" value="<?=$uri;?>"/>
<input type="text" name="sale_year" id="sale_year" style="width:5em;" value="<?=get_current_year();?>"/>
<input type="submit" value="update"/>

</form>