<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function initialize_elfinder($value = '')
{
    $CI = &get_instance();
    $CI->load->helper('path');
    $opts = array(
        //'debug' => true,
        'roots' => array(
            array(
                'driver' => 'LocalFileSystem',
                'path'   => set_realpath('./assets/images/'),
            ),
        ),
    );
    return $opts;
}
