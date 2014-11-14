<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

function is_logged_in ($data)
{
    $result = false;
    if (array_key_exists("username", $data) && array_key_exists("db_role", $data) && array_key_exists("user_id", $data)) {
        $result = true;
    }
    return $result;
}

function set_user_cookies ($cookies)
{
    foreach ($cookies as $cookie) {
        $data = array();
        $data["name"] = $cookie->type;
        $data["value"] = $cookie->value;
        $data["expire"] = 0;
        set_cookie($data);
    }
}

/**
 *
 * @param array of objects $user_groups expecting ion_auth user_groups array of
 *        objects, each object defining the groups to which a user belongs
 *        returns true if the user is an administrator or editor.
 */
function is_editor ($user_groups)
{
    $output = FALSE;
    foreach ($user_groups as $group) {
        if ($group->name == "admin" || $group->name == "editors") {
            $output = TRUE;
        }
    }
    return $output;
}