<?php defined('BASEPATH') OR exit('No direct script access allowed');

$action_buttons[] = array("text"=>"New Common Name/Genus","class"=>array("button","new","create","dialog","common-create"), "selection"=>"common","href"=>site_url("common/create"));
$action_buttons[] = array("text"=>"New Grower","class"=>array("button","new","grower-create"),"selection"=>"grower","type"=>"span");
if($orphan_count > 0){
    $verb = $orphan_count == 1?"is":"are";
    $plural = $orphan_count > 1?"s":"";
$action_buttons[] = array("text"=>"Show $orphan_count Orphan Grower$plural <span class='badge'>$orphan_count</span>","title"=>"There $verb $orphan_count grower$plural with no grower record. Click here to fix this.","class"=>array("button"),"href"=>site_url("grower/show_orphans"));
}
$action_buttons[] = array("selection"=>"variety","text"=>"Update New Varieties","class"=>"button edit","title"=>"Update records for all varieties ordered for the first time this year","href"=>site_url("variety/update_new_status/" . get_cookie("sale_year")));
if(IS_ADMIN){
$action_buttons[] = array("selection"=>"order","text"=>"Set Catalog Numbers","class"=>array("button edit show-catalog-updater"),"title"=>"Update all catalog numbers for the current year","href"=>site_url("order/set_catalog_numbers") );
$action_buttons[] = array("selection"=>"index","text"=>"Export for Quark","href"=>"#", "class"=>"button export ready show-quark-export");
$action_buttons[] = array("selection"=>"index","text"=>"Export for Web","href"=>"#", "class"=>"button export ready export-for-web");

}
?>

<h1>Welcome to the Friends School Plant Sale Database!</h1>

<p>Click on any of the buttons below to get totals overviews. Use the search field above to quickly find plants by common name, genus, variety name or species.</p>

<p>
<?=create_button_bar($action_buttons);?>
<div id="category-selector" style="width: 250px;position:absolute; max-height: 500px;">
</div>
<h3>Totals</h3>

<div style="width:250px;margin:0 auto; float: left;">
<?=create_button_bar(array(array("selection"=>"order","text"=>"Show Order Totals","href"=>"#order-totals-end","class"=>"button show-order-totals")));?>
<div id="order-totals" class="front-page-widget">
</div>
<div id="order-totals-end"></div>
</div>
<div style="float:left; width: 250px;">
<?=create_button_bar(array(array("selection"=>"variety","text"=>"Show Category Totals","href"=>"#category-totals-end", "class"=>"button show-category-totals")));?>
<div id="category-totals"  class="front-page-widget">
</div>
<div id="category-totals-end"></div>
</div>
<div style="float:left; width: 250px">
<?=create_button_bar(array(array("selection"=>"variety","text"=>"Show Flat Totals","href"=>"#flat-totals-end", "class"=>"button show-flat-totals")));?>
<div id="flat-totals"  class="front-page-widget">
</div>
<div id="flat-totals-end"></div>
</div>


