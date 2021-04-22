<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');


function set_user_cookies ($cookies)
{
    foreach ($cookies as $cookie) {
        $data = array();
        $data['name'] = $cookie->type;
        $data['value'] = $cookie->value;
        $data['expire'] = 0;
        set_cookie($data);
    }
}
