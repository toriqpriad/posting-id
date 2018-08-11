<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function set_filemanager($path)
{
    $CI = &get_instance();
    $CI->load->library('session');
    $CI->load->helper('jwt_helper', 'key_helper', 'cookie');
    $key   = generate_key();
    $token = JWT::encode($key, SERVER_SECRET_KEY);

    $cookie_upload_url = array(
        'name'   => 'fm_url',
        'value'  => base_url() . 'backend/filemanager_check/',
        'expire' => '86500',
    );

    $cookie_upload_dir = array(
        'name'   => 'fm_dir',
        'value'  => MAIN_DIR . BACKEND_IMAGE_UPLOAD_FOLDER . $path,
        'expire' => '86500',
    );

    $CI->session->set_userdata("fm_token", $token);
    $CI->input->set_cookie($cookie_upload_url);
    $CI->input->set_cookie($cookie_upload_dir);
    $CI->data['filebrowser_url'] = base_url('assets/statics/filemanager/index.php') . '?integration=custom&filemanager=go';
}
