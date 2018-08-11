<?php

class Backend extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
        $this->load->library(array('curl', 'session', 'datatables'));
        $this->load->helper(array('form', 'url', 'jwt_helper', 'rest_response_helper', 'key_helper', 'image_process_helper', 'file', 'filemanager', 'cookie', 'send_mail_helper'));
        $this->data = [];
        $this->checkauth();
    }

    public function logout()
    {
        $delete_session = $this->session->sess_destroy();
        $login          = 'login';

        if ($this->session->userdata("user")['role'] == 'A') {
            $login = 'manage';
        }

        $data = array('link' => BASE_URL . $login);

        echo json_encode(get_success($data));
    }

    public function display(
        $location, $specific_js_function_location = null, $function_location = null, $table = null, $website_information = null
    ) {
        $this->data['menu'] = $this->menu();
        $this->data['site'] = $website_information;
        $this->load->view('backend/include/head', $this->data);
        if ($table == true) {
            $this->load->view('backend/include/table');
        }

        $this->load->view('backend/include/main_function');

        if ($specific_js_function_location == true) {
            $this->load->view('backend/' . $specific_js_function_location);
        }
        $this->load->view('backend/include/modal');
        $this->load->view('backend/include/top_menu');
        // $this->load->view('backend/include/sidebar_menu');
        // $this->load->view('backend/include/breadcrumb');
        if ($function_location == true) {
            $this->load->view('backend/' . $function_location);
        }
        $this->load->view('backend/' . $location);

        // $this->load->view('backend/include/footer_menu');
    }

    public function notfound()
    {
        $this->display('404');
    }

    public function checkauth($role = null)
    {
        if ($this->session->userdata("user") != "") {
            if ($role) {
                if ($this->session->userdata("user")['role'] != $role) {
                    redirect('');
                    exit();
                }
            }
        } else {
            redirect('');
            exit();
        }
    }

    public function filemanager_check()
    {
        if ($this->session->userdata("fm_token") != "") {
            $decode = JWT::decode($this->session->userdata("fm_token"), SERVER_SECRET_KEY, JWT_ALGHORITMA);
            if (!$decode) {
                echo 'NO';
            }
        } else {
            echo 'NO';
        }
    }

}
