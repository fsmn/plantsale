<?php defined('BASEPATH') OR exit('No direct script access allowed');

// export.php Chris Dart Jan 9, 2015 2:47:18 PM chrisdart@cerebratorium.com

$filename = "grower_totals-$year.txt";
//Define the fields desired for output in this array
$fields = array(
        "id" => "Grower ID",
        "grower_name" => "Grower Name",
        "street_address" => "Street",
        "po_box" => "PO Box",
        "city" => "City",
        "state" => "State",
        "zip" => "Postal Code",
        "country" => "Country",
        "total" => "Total",
);
foreach (array_values($fields) as $value) {
    $header_values[] = $value;
}

$output = array(
        implode("\t", $header_values)
);
foreach ($growers as $grower) {
    foreach (array_keys($fields) as $key) {
        $line[] = $grower->$key;
    }
    $output[] = implode("\t", $line);
    $line = NULL;
}

$data = implode("\n", $output);
force_download($filename, $data);