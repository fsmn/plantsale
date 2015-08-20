<?php
defined('BASEPATH') or exit('No direct script access allowed');

// varieties.php Chris Dart Feb 17"," 2015 2:57:55 PM
// chrisdart@cerebratorium.com

$filename = "varieties_web_" . date("Y-m-d_H-i-s") . ".csv";

$header = array(
        "common_id",
        "catalog_number",
        "web_id",
        "variety",
        "species",
        "plant_color",
        "other_names",
        "category",
        "description",
        "extended_description",
        "price",
        "pot_size",
        "min_height_inches",
        "max_height_inches",
        "min_width_inches",
        "max_width_inches",
        "flag_is_new",
        "flag_saturday_delivery",
        "flag_birds",
        "flag_butterflies",
        "flag_cold_sensitive",
        "flag_interesting_foliage",
        "flag_culinary",
        "flag_edible_flowers",
        "flag_ground_cover",
        "flag_hummingbirds",
        "flag_medicinal",
        "flag_native",
        "flag_organic",
        "flag_poisonous",
        "flag_rock_garden",
        "flag_bees"
);

$output[] = implode(",", $header);

foreach ($varieties as $variety) {
    if (! strstr($variety->subcategory, "Hanging")) {
        $flags = $variety->flags;
        $line = array(
                $variety->common_id,
                $variety->catalog_number,
                "P" . $variety->web_id,
                $variety->variety,
                $variety->species,
                str_replace(",", "\r", $variety->plant_color),
                $variety->other_names,
                $variety->subcategory ? $variety->web_label : $variety->category,
                str_replace("'", "&rsquo;", str_replace("\"", "&quot;", $variety->print_description)),
                str_replace("'", "&rsquo;", str_replace("\"", "&quot;", $variety->web_description)),
                $variety->price,
                str_replace("'", "&rsquo;", str_replace("\"", "&quot;", $variety->pot_size)),
                $variety->height_unit == "Feet" ? $variety->min_height * 12 : $variety->min_height,
                $variety->height_unit == "Feet" ? $variety->max_height * 12 : $variety->max_height,
                $variety->width_unit == "Feet" ? $variety->min_width * 12 : $variety->min_width,
                $variety->width_unit == "Feet" ? $variety->max_width * 12 : $variety->max_width,
                $variety->year == $variety->new_year ? 1 : 0,
                $variety->count_midsale > 0 ? 1 : 0,
                in_array("Birds", $flags),
                in_array("Butterflies", $flags),
                in_array("Cold Sensitive", $flags),
                in_array("Interesting Foliage", $flags),
                in_array("Culinary", $flags),
                in_array("Edible Flowers", $flags),
                in_array("Ground Cover", $flags),
                in_array("Hummingbirds", $flags),
                in_array("Medicinal", $flags),
                in_array("Minnesota Native", $flags),
                in_array("Organic", $flags),
                in_array("Poisonous", $flags),
                in_array("Rock Garden", $flags),
                in_array("Bees", $flags)
        );
        $output[] = "\"" . implode("\",\"", $line) . "\"";
    }
}

$data = implode("\n", $output);
force_download($filename, $data);