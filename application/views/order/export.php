<?php
defined('BASEPATH') or exit('No direct script access allowed');

$filename = "order_export.txt";
// Define the fields desired for output in this array
$fields = array(
        "grower_id" => "Grower ID",
        "year" => "Year",
        "catalog_number" => "Catalog Number",
        "new_year" => "First year at Sale",
        "name" => "Common Name",
        "genus" => "Genus",
        "species" => "Species",
        "variety" => "Variety",
        "category" => "Category",
        "subcategory" => "Subcategory",
        "pot_size" => "Pot Size",
        "count_presale" => "Presale Order",
        "count_midsale" => "Midsale Order",
        "flat_size" => "Flat Size",
        "flat_cost" => "Flat Cost",
        "plant_cost" => "Plant Cost",
        "price" => "Sale Price",
        "grower_code" => "Grower Code",
);
foreach (array_values($fields) as $value) {
    $header_values[] = $value;
}

$output = array(
        implode("\t", $header_values)
);
foreach ($orders as $order) {
    $current_year = $order->year;
    foreach (array_keys($fields) as $key) {
        if ($key == "new_year") {
            if ($order->$key == $current_year) {
                $line[] = "New";
            }else{
                $line[] = "";
            }
        } else {
            $line[] = $order->$key;
        }
    }
    $output[] = implode("\t", $line);
    $line = NULL;
}

$data = implode("\n", $output);
force_download($filename, $data);