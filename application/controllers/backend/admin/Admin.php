<?php

defined('BASEPATH') or exit('No direct script access allowed');

include dirname(__FILE__) . "/../Backend.php";

class admin extends Backend
{
    public function __construct()
    {
        parent::__construct();
        parent::checkauth('A');
        $this->data['role_name'] = "Administrator";
        $this->data['role_case'] = "A";
    }

    public function notfound()
    {
        $this->data['active_page'] = "notfound";
        $this->data['title_page']  = "Tidak ditemukan";
        $this->specific_display('404', false, false, true);
    }

    public function setting()
    {
        $this->data['active_page'] = "setting";
        $this->data['title_page']  = "Pengaturan";
        $website_information       = $this->website_information();
        $this->data['email']       = $website_information->email;
        $this->specific_display('setting/index', 'setting/function');
    }

    public function password_update()
    {
        $old_pass              = $this->input->post("old_pass");
        $new_pass              = $this->input->post("new_pass");
        $dest_table_as         = 'setting';
        $select_values         = array('password');
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $where1                = array("where_column" => 'id', "where_value" => "0");
        $params->where_tables  = array($where1);
        $get                   = $this->data_model->get($params);
        $old_password_hash     = create_hash($old_pass);
        if ($get['response'] == OK_STATUS) {
            if ($old_password_hash != $get['results'][0]->password) {
                $response_data = array("response" => FAIL_STATUS, "message" => "Password lama tidak sesuai");
            } else {
                $params_data               = new stdClass();
                $new_password_hash         = create_hash($new_pass);
                $params_data->new_data     = array("password" => $new_password_hash);
                $where                     = array("where_column" => 'id', "where_value" => "0");
                $params_data->where_tables = array($where);
                $params_data->table_update = 'setting';
                $update                    = $this->data_model->update($params_data);
                if ($update["response"] == OK_STATUS) {
                    $response_data = array("response" => OK_STATUS, "message" => "Password sudah diganti");
                }
            }
        }
        echo json_encode($response_data);
    }

    public function setting_update()
    {
        $email                 = $this->input->post("email");
        $params_data           = new stdClass();
        $params_data->new_data = array(
            "email"     => $email,
            "update_at" => date('d-m-Y h:i A'),
        );
        $where                     = array("where_column" => 'id', "where_value" => '0');
        $params_data->where_tables = array($where);
        $params_data->table_update = 'setting';
        $update                    = $this->data_model->update($params_data);

        if ($update) {            
            $result = response_success();
        } else {
            $params           = new stdClass();
            $params->response = NO_DATA_STATUS;
            $params->message  = FAIL_STATUS;
            $params->data     = array("error" => $error_data);
            $result           = response_custom($params);
        }
        echo json_encode($result);
    }

    public function submit_logout()
    {
        delete_cookie('admin_url');
        parent::logout();
    }

    public function specific_display($view_location, $js_function = null, $need_table = null, $notfound = null)
    {
        $website_information = $this->website_information();
        if ($notfound) {
            parent::display($view_location, false, false, false, $website_information);
        } else {
            parent::display('admin/' . $view_location, 'admin/specific_js_function', 'admin/' . $js_function, $need_table, $website_information);
        }

    }

    public function dashboard()
    {
        $this->data['active_page']           = "dashboard";
        $this->data['title_page']            = "Administrator Dashboard";
        $this->data['main_breadcrumb_title'] = "Dashboard";
        $this->specific_display('dashboard/index', 'dashboard/function');
    }

    public function menu()
    {
        $d = array(
            "label"     => "Dashboard",
            "link"      => base_url() . 'backend/admin/',
            "page_name" => "dashboard",
            // "icon"      => "fa fa-tachometer 1x",
        );

        $st = array(
            "label"     => "Pengaturan",
            "link"      => base_url() . 'backend/admin/setting/',
            "page_name" => "setting",
            // "icon"      => "fa fa-cog 1x",
        );
 
        $array = [$d, $st,];
        return $array;
    }

    private function website_information()
    {
        $dest_table_as         = 'setting';
        $select_values         = array('*');
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $where1                = array("where_column" => 'id', "where_value" => '0');
        $params->where_tables  = array($where1);
        $get                   = $this->data_model->get($params);
        // $count                 = $this->data_model->get_count('access_log')['results'];
        if ($get['response'] == OK_STATUS) {
            $dir_photo = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/setting/' . $get['results'][0]->logo;
            $check     = check_if_empty($get['results'][0]->logo, $dir_photo);
            if ($check == NO_IMG_NAME) {
                $img = base_url() . BACKEND_IMAGE_UPLOAD_FOLDER . 'noimg.png';
            } else {
                $img = base_url() . $dir_photo;
            }
            $get['results'][0]->photo = $img;
            // $get['results'][0]->access_log = $count;
            $website = $get['results'][0];
        } else {
            $website = [];
        }
        return $website;
    }

    public function count_data()
    {
        $c    = $this->data_model->get_count('category_property');
        $p    = $this->data_model->get_count('property');
        $b    = $this->data_model->get_count('brand');
        $s    = $this->data_model->get_count('slider');
        $n    = $this->data_model->get_count('news');
        $o    = $this->data_model->get_count('order');
        $data = array(
            'news'     => $n['results'],
            'category' => $c['results'],
            'product'  => $p['results'],
            'brand'    => $b['results'],
            'slider'   => $s['results'],
            'order'    => $o['results'],
        );
        return $data;

    }
}
