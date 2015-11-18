<?php
defined('BASEPATH') or exit('No direct script access allowed');

$buttons[] = array(
        "selection" => "index",
        "text" => "Home",
        "class" => array(
                "button"
        ),
		"style"=>"default",
        "href" => site_url(""),
        "title" => "Home"
);

$buttons[] = array(
        "selection" => "variety",
        "type" => "pass-through",
        "text" => "<form class='form-inline'><span class='form-group'><input type='text' name='variety-search' id='variety-search-body' class='search-field form-control variety-search' value='' placeholder='Quickly find plants here'/></span></span>"
);

$buttons[] = array(
        "selection" => "all",
        "text" => "Common Search",
        "class" => array(
                "button",
        		"search",
        		"dialog",
                "search-common-names",
        ),
		"style"=>"default",
		"href" => site_url("common/search"),
        "title" => "Search among the common names"
);

$buttons[] = array(
        "selection" => "all",
        "text" => "Variety Search",
        "class" => array(
                "button",
        		"search",
        		"dialog",
                "search-varieties",
        ),
		"style"=>"search",
        "href"=> site_url("variety/search"),
        "title" => "Search among the varieties"
);

$buttons[] = array(
        "selection" => "order",
        "text" => "Orders Search",
        "class" => array(
                "button",
        		"search",
        		"dialog",
                "search-orders"
        ),
		"style"=>"search",
        "href" => site_url("order/search/"),
        "title" => "Search Orders"
);

$buttons[] = array(
	"selection" => "grower",
        "text"=> "Grower Totals",
        "class"=> array("button","grower-totals"),
        "href"=>base_url("grower/totals"),
        "title" => "Get Dollar Totals for All Growers for the current year",
		"style"=>"search",
);


print create_button_bar($buttons, array(
        "id" => "navigation-buttons"
));
