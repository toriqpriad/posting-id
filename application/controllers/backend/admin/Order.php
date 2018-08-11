<?php

defined('BASEPATH') or exit('No direct script access allowed');

include dirname(__FILE__) . "/Admin.php";

class Order extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->data['active_page']           = "order";
        $this->data['main_breadcrumb_title'] = "Pesanan";
        $this->data['active_url']            = ADMIN_WEBAPP_URL . $this->data['active_page'] . '/';
    }

    public function index()
    {
        $this->data['title_page'] = "Data order";
        $this->specific_display('order/index', 'order/function', true);
    }

    public function json()
    {
        $dest_table_as         = 'order';
        $select_values         = array('*');
        $order                 = array('order_column' => 'id', 'order_type' => 'desc');
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $params->order_by      = array($order);
        $get                   = $this->data_model->get($params);
        echo json_encode(array("data" => $get['results']));
    }

    public function get()
    {
        $parameter             = $this->uri->segment(4);
        $params                = new stdClass();
        $params->dest_table_as = 'order';
        $params->select_values = array('*');
        $params->where_tables  = array(array("where_column" => 'id', "where_value" => $parameter));
        $get                   = $this->data_model->get($params);
        if (!empty($get['results'][0])) {
            $this->data['record']     = $get['results'][0];
            $this->data['title_page'] = "Detail Order";
            $this->session->set_userdata("order_id", $get['results'][0]->id);
            $this->specific_display('order/get', 'order/function');
        } else {
            parent::notfound();
        }
    }

    public function update()
    {
        $id    = $this->session->userdata("order_id");
        $name  = $this->input->post("name");
        $desc  = $this->input->post("desc");
        $link  = $this->input->post("link");
        $email = $this->input->post("email");

        $params_data           = new stdClass();
        $params_data->new_data = array(
            "name"        => $name,
            "description" => $desc,
            "link"        => $link,
            "email"       => $email,
            "update_at"   => date('d-m-Y h:m'),
        );
        $where                     = array("where_column" => 'id', "where_value" => $id);
        $params_data->where_tables = array($where);
        $params_data->table_update = 'order';
        $update                    = $this->data_model->update($params_data);

        if ($update) {
            $data   = array("link" => $this->data['active_url'] . $id);
            $result = get_success($data);
        } else {
            $params           = new stdClass();
            $params->response = NO_DATA_STATUS;
            $params->message  = FAIL_STATUS;
            $params->data     = array("error" => $error);
            $result           = response_custom($params);
        }
        echo json_encode($result);
    }

    public function delete()
    {
        $id                    = $this->input->post('id');        
        $delete               = new stdClass();
        $where1               = array("where_column" => 'id', "where_value" => $id);
        $delete->where_tables = array($where1);
        $delete->table        = 'order';
        $delete_data          = $this->data_model->delete($delete);
        if ($delete_data) {
            $result = response_success();
        } else {
            $result = response_fail();
        }
        echo json_encode($result);
    }

//OTHER FUNCTION

}
