<?php

defined('BASEPATH') or exit('No direct script access allowed');

// preference_model.php Chris Dart Dec 10, 2014 4:33:55 PM
// chrisdart@cerebratorium.com
class Preference_model extends MY_Model
{
    var $user_id;
    var $preference_id;

    function __construct ()
    {
        parent::__construct();
    }
}