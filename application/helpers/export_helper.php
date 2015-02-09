<?php
defined('BASEPATH') or exit('No direct script access allowed');

// quark_helper.php Chris Dart Feb 9, 2015 4:34:51 PM
// chrisdart@cerebratorium.com
function format_sunlight ($sunlight, $format = "quark")
{
    $output = "";
    if ($format == "quark") {
        if (strstr($sunlight, "full")) {
            $output .= "Í";
        }
        if (strstr($sunlight, "part")) {
            $output .= "∏";
        }
        if (strstr($sunlight, "shade")) {
            $output .= "Ó";
        } else {
            if (strstr($sunlight, "full")) {
                $output .= "+++";
            }
            if (strstr($sunlight, "part")) {
                $output .= "%%%";
            }
            if (strstr($sunlight, "shade")) {
                $output .= "///";
            }
        }
        return $output;
    }
}

/**
 * the rules for codes are baffling and require special knowledge,
 * but here we are with a crazy setup.
 * Someday we'll
 * clean this up.
 */
function format_flags ($flags, $format = "quark")
{
    $output = "";
    foreach ($flags as $flag) {
        switch ($flag->name) {
            case "Bees":
                if ($format == "quark") {
                    $output .= "Ω";
                    // If(flag~Bee > "a";"Ω";"")
                } else {
                    $output = "Bee";
                }
                break;
            case "Butterflies":
                if ($format == "quark") {
                    $output .= "∫";
                } else {
                    $output .= "ButterB";
                }
                break;
            case "Cold Sensitive":
                if ($format == "quark") {
                    $output .= "†";
                } else {
                    $output .= "ColdB";
                }
                break;
            case "Culinary":
                if ($format == "quark") {
                    $output .= "Ç";
                } else {
                    $output .= "CulinaryB";
                }
                break;
            case "Edible Flowers":
                if ($format == "quark") {
                    $output .= "´";
                } else {
                    $output .= "EdibleB";
                }
                break;
            case "Ground Cover":
                if ($format == "quark") {
                    $output .= "˝";
                } else {
                    $output = "GroundB";
                }
                break;
            case "Hummingbirds":
                if ($format == "quark") {
                    $output .= "˙";
                } else {
                    $output .= "HummB";
                }
                break;
            case "Interesting Foliage":
                if ($format == "quark") {
                    $output .= "ç";
                } else {
                    $output .= "FoliageB";
                }
                break;
            case "Medicinal":
                if ($format == "quark") {
                    $output .= "Â";
                } else {
                    $output .= "MedicinalB";
                }
                break;
            case "Minnesota Native":
                if ($format == "quark") {
                    $output .= "˜";
                } else {
                    $output .= "NativeB";
                }
                break;
            case "Organic":
                if ($format == "quark") {
                    $output .= "Ø";
                } else {
                    $output .= "OrganicB";
                }
            case "Poisonous":
                if ($format == "quark") {
                    $output .= "¥";
                } else {
                    $output .= "PoisonousB";
                }
                break;
            case "Rock Garden":
                if ($format == "quark") {
                    $output .= "‰";
                } else {
                    $output .= "RockB";
                }
                break;
        }
    }
    return $output;
}

/**
 * Assume that the determination of new year is calculated elsewhere.
 */
function format_new($format = "quark")
{
    if ($format == "quark") {
        $output = "◊";
    } else {
        $output = "Y";
    }
    return $output;
}


function format_saturday($format = "quark")
{
    if ($format == "quark") {
        $output = "ß";
    } else {
        $output = "qqq";
    }
    return $output;
}

function format_quark_dimensions(){

    format_dimensions($common->min_height,$common->max_height,$common->height_unit == "Inches"?"”":"’","h");
    format_dimensions($common->min_width,$common->max_width,$common->width_unit == "Inches"?"”":"’","h");

}
