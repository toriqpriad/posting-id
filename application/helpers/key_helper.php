<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function generate_key($length = null)
{
    if ($length == "" or empty($length) or !isset($length)) {
        $length = 10;
    }
    $characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function create_hash($key)
{
    return hash_hmac('snefru', $key, SERVER_SECRET_KEY);
}
