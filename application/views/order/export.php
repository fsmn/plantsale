<?php

defined('BASEPATH') or exit('No direct script access allowed');

$filename = "order_export.txt";
//Define the fields desired for output in this array
$fields = array(
        "grower_id" => "Grower ID",
        "year" => "Year",
        "name" => "Common Name",
        "genus" => "Genus",
        "species" => "Species",
        "variety" => "Variety",
        "pot_size" => "Pot Size",
        "count_presale" => "Presale Order",
        "count_midsale" => "Midsale Order",
        "flat_size" => "Flat Size",
        "flat_cost" => "Flat Cost",
        "grower_code" => "Grower Code",
        "category" => "Category"
);
foreach (array_values($fields) as $value) {
    $header_values[] = $value;
}

$output = array(
        implode("\t", $header_values)
);
foreach ($orders as $order) {
    foreach (array_keys($fields) as $key) {
        $line[] = $order->$key;
    }
    $output[] = implode("\t", $line);
    $line = NULL;
}

$data = implode("\n", $output);
force_download($filename, $data);