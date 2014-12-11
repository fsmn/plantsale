<?php
defined('BASEPATH') or exit('No direct script access allowed');

// user_preferences_model.php Chris Dart Dec 10, 2014 5:02:42 PM
// chrisdart@cerebratorium.com
class User_Preferences_Model extends MY_Model
{
    var $preference_id;
    var $user_id;
    var $value;

    function __construct ()
    {
        parent::__construct();
    }

    function get ($user_id, $preference_id)
    {
        $this->db->from("user_preferences");
        $this->db->where("user_id", $user_id);
        $this->db->where("preference_id", $preference_id);
        $result = $this->db->get()->row();
        return $result->value;
    }

    function get_all ($user_id)
    {
        $this->db->from("preferences");
        $this->db->join("user_preferences", "preferences.id = user_preferences.preference_id AND user_id = $user_id","LEFT");
//         $this->db->join("user", "user_id=user.id");
//         $this->db->where("user_id", $user_id);
        $this->db->order_by("preferences.weight","ASC");
        $result = $this->db->get()->result();
        return $result;
    }
}