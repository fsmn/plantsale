<?php
defined('BASEPATH') or exit('No direct script access allowed');

$buttons[] = array(
        "selection" => "index",
        "text" => "Home",
        "class" => array(
                "button"
        ),
        "href" => site_url(""),
        "title" => "Home"
);

$buttons[] = array(
        "selection" => "variety",
        "type" => "pass-through",
        "text" => "<input type='text' name='variety-search' id='variety-search-body' class='search-field variety-search' value='' placeholder='Quickly find plants here'/>"
);

$buttons[] = array(
        "selection" => "all",
        "text" => "Common Search",
        "class" => array(
                "button",
        		"search",
                "search-common-names",
        ),
        "type" => "span",
        "title" => "Search among the common names"
);

$buttons[] = array(
        "selection" => "all",
        "text" => "Variety Search",
        "class" => array(
                "button",
        		"search",
                "search-varieties",
        ),
        "type" => "span",
        "title" => "Search among the varieties"
);

$buttons[] = array(
        "selection" => "order",
        "text" => "Orders Search",
        "class" => array(
                "button",
        		"search",
                "search-orders"
        ),
        "href" => "#",
        "title" => "Search Orders"
);

$buttons[] = array(
	"selection" => "grower",
        "text"=> "Grower Totals",
        "class"=> array("button","grower-totals"),
        "href"=>base_url("grower/totals"),
        "title" => "Get Dollar Totals for All Growers for the current year",
);

// $buttons[] = array(
// 	"selection"=>"all",
//         "text"=>"Try This Out!",
//         "class"=>array(
// 	"button",
//                 "mr-shmallow",
//                 ),
//         "href" =>"#",
//         "title" =>"More Experiments",
// );



print create_button_bar($buttons, array(
        "id" => "navigation-buttons"
));
