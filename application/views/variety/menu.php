<?php defined('BASEPATH') OR exit('No direct script access allowed');
if(IS_EDITOR){
$buttons["edit"] = array("text"=>"Edit","class"=>"button edit variety-edit","id"=>"edit-variety_$variety->id","href"=>site_url("variety/view/$variety->id"),"selection"=>"home");
}
$buttons["print-tabloid"] = array("text"=>"Print Tabloid","class"=>"button print variety-print-tabloid-one","id"=>"print-tabloid_$variety->id","href"=>site_url("variety/print_one/$variety->id/tabloid"),"target"=>"_blank");
$buttons["print-statement"] = array("text"=>"Print Statement","class"=>"button print variety-print-statement-one","id"=>"print-statement_$variety->id","href"=>site_url("variety/print_one/$variety->id/statement"),"target"=>"_blank");
$buttons["print-letter"] = array("text"=>"Print Letter","class"=>"button print variety-print-letter","href"=>site_url("variety/print_result/letter"), "target"=>"_blank");

if(IS_EDITOR){
	$buttons["delete"] = array("text"=>"Delete","class"=>"button delete variety-delete","id"=>"delete-variety_$variety->id","type"=>"span","selection"=>"home");
}

print create_button_bar($buttons);