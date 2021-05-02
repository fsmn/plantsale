<?php defined('BASEPATH') or exit('No direct script access allowed');
?>

<form name="set_sale_year" id="set_sale_year" action="<?php print base_url('index/set_year'); ?>" method="get">
    <input type="hidden" name="uri" id="uri" value="<?php print $uri; ?>" />
    <input type="text" name="sale_year" id="sale_year" style="width:5em;" value="<?php print get_current_year(); ?>" />
    <input type="submit" class='btn btn-default edit button' value="update" />

</form>