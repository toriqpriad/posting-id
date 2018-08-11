  <?php

defined('BASEPATH') or exit('No direct script access allowed');

include dirname(__FILE__) . "/Admin.php";

class setting extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->data['active_page']           = "setting";
        $this->data['main_breadcrumb_title'] = "Pengaturan";
        $this->data['active_url']            = ADMIN_WEBAPP_URL . $this->data['active_page'] . '/';
    }

    public function index()
    {
        $this->data['title_page'] = "Pengaturan Website";
        $this->data['record']     = $this->get();
        $this->specific_display('setting/index', 'setting/function', true);
    }

    public function get()
    {
        $parameter             = $this->uri->segment(4);
        $params                = new stdClass();
        $params->dest_table_as = 'setting';
        $params->select_values = array('*');
        $get                   = $this->data_model->get($params);
        $dir                   = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/setting/';
        if (!empty($get['results'])) {
            $name      = $get['results'][0]->logo;
            $image_dir = $dir . $name;
            $check     = check_if_empty($name, $image_dir);
            if ($check == NO_IMG_NAME) {
                $url = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'image_not_exist.png';
            } else {
                $url = BASE_URL . $image_dir;
            }
            $get['results'][0]->logo     = $url;
            $get['results'][0]->logo_old = $name;

        }
        return $get['results'][0];
    }

    public function update()
    {
        $name            = $this->input->post("name");
        $desc            = $this->input->post("desc");
        $email           = $this->input->post("email");
        $channel_id      = $this->input->post("channel_id");
        $channel_api     = $this->input->post("channel_api");
        $map             = $this->input->post("map");
        $moto            = $this->input->post("moto");
        $addr            = $this->input->post("address");
        $contact         = $this->input->post("contact");
        $whatsapp        = $this->input->post("whatsapp");
        $old_logo        = $this->input->post("old_logo");
        $error           = [];
        $image_logo_name = $old_logo;

        if (isset($_FILES["logo"])) {
            if (!empty($_FILES["logo"]["name"])) {
                $backend_dir     = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/setting/';
                $upload_logo     = image_upload(array($_FILES["logo"]), $backend_dir);
                $image_logo_name = $upload_logo->data[0];
                // $image_data      = array("logo" => $image_logo_name);
                // array_push($params_data->new_data, $image_data);
                if ($upload_logo->response == OK_STATUS) {
                    if ($old_logo != "") {
                        $remove_old = unlink($backend_dir . $old_logo);
                    }
                } else {
                    if ($upload_logo->data['error']) {
                        foreach ($upload_logo->data['error'] as $er) {
                            array_push($error, $er);
                        }
                    }
                    $image_logo_name = $old_logo;
                }
            }
        }

        $params_data           = new stdClass();
        $params_data->new_data = array(
            "name"                => $name,
            "moto"                => $moto,
            "description"         => $desc,
            "address"             => $addr,
            "logo"                => $image_logo_name,
            "video_id_channel   " => $channel_id,
            "video_api_key"       => $channel_api,
            "map_embed"           => $map,
            "contact"             => $contact,
            "whatsapp"            => $whatsapp,
            "email"               => $email,
            "update_at"           => date('d-m-Y h:m'),
        );
        $where                     = array("where_column" => 'id', "where_value" => '0');
        $params_data->where_tables = array($where);
        $params_data->table_update = 'setting';
        $update                    = $this->data_model->update($params_data);

        if ($update['response'] == OK_STATUS) {
            $params = new stdClass();
            if ($error) {
                $params->response = FAIL_STATUS;
                $params->message  = "Peringatan";
                $params->data     = $error;
            } else {
                $params->response = OK_STATUS;
                $params->message  = OK_MESSAGE;
            }
            $result = response_custom($params);
        } else {
            $result = response_fail();
        }
        echo json_encode($result);
    }

    public function update_password()
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

    //OTHER FUNCTION

}