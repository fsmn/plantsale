<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<form name="set_sale_year" id="set_sale_year" action="<?php echo base_url("index/set_year");?>" method="get">
<input type="hidden" name="uri" id="uri" value="<?php echo $uri;?>"/>
<input type="text" name="sale_year" id="sale_year" style="width:5em;" value="<?php echo $year;?>"/>
<input type="submit" class='btn btn-default edit button' value="update"/>

</form>
