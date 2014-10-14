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
        "text" => "<input type='text' name='variety-search' id='variety-search-body' class='search-field variety-search' value='Find Plants'/>"
);

$buttons[] = array(
        "selection" => "all",
        "text" => "Common Search",
        "class" => array(
                "button",
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
                "search-orders"
        ),
        "href" => "#",
        "title" => "Search Orders"
);

$buttons[] = array(
	"selection"=>"all",
        "text"=>"Click Here",
        "class"=>array(
	"button",
                "mr-shmallow",
                ),
        "href" =>"#",
        "title" =>"Look Lively!",
);



print create_button_bar($buttons, array(
        "id" => "navigation-buttons"
));
