<?php

defined('BASEPATH') or exit('No direct script access allowed');

include dirname(__FILE__) . "/Admin.php";

class category extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->data['active_page']           = "category";
        $this->data['main_breadcrumb_title'] = "Kategori";
        $this->data['active_url']            = ADMIN_WEBAPP_URL . $this->data['active_page'] . '/';

    }

    public function json()
    {
        $dest_table_as         = 'category';
        $select_values         = array('*');
        $order                 = array('order_column' => 'id', 'order_type' => 'desc');
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $params->order_by      = array($order);
        $get                   = $this->data_model->get($params);
        echo json_encode(get_success($get['results']));
    }

    public function post()
    {
        $name        = $this->input->post("name");
        $slug        = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $name));
        $params_data = array(
            "name"       => $name,
            "slug"       => $slug,
            "created_at" => date('d-m-Y h:i A'),
            "update_at"  => date('d-m-Y h:i A'),
        );
        $dest_table = 'category';
        $add        = $this->data_model->add($params_data, $dest_table);
        $new_id     = $add["data"];
        if ($add) {
            $data   = array("link" => $this->data['active_url'] . '/' . $new_id);
            $result = get_success($data);
        } else {
            $params           = new stdClass();
            $params->response = NO_DATA_STATUS;
            $params->message  = FAIL_STATUS;
            $params->data     = array("error" => $error_data);
            $result           = response_custom($params);
        }
        echo json_encode($result);
    }

    public function get()
    {
        $parameter             = $this->uri->segment(4);
        $params                = new stdClass();
        $params->dest_table_as = 'category';
        $params->select_values = array('name');
        $params->where_tables  = array(array("where_column" => 'id', "where_value" => $parameter));
        $get                   = $this->data_model->get($params);
        echo json_encode(get_success($get['results'][0]));
    }

    public function get_json()
    {
        $parameter             = $this->uri->segment(5);
        $params                = new stdClass();
        $params->dest_table_as = 'category_property';
        $params->select_values = array('*');
        $params->where_tables  = array(array("where_column" => 'id', "where_value" => $parameter));
        $get                   = $this->data_model->get($params);
        if (isset($get['results'][0])) {
            $attributes                    = $this->get_attribute($get['results'][0]->id);
            $get['results'][0]->attributes = $attributes;
            $data                          = $get['results'][0];
            echo json_encode(get_success($data));
        } else {
            echo json_encode(get_not_found());
        }
    }

    public function update()
    {
        $id                    = $this->input->post("id");
        $name                  = $this->input->post("name");
        $slug                  = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $name));
        $desc                  = $this->input->post("desc");
        $params_data           = new stdClass();
        $params_data->new_data = array(
            "name"      => $name,
            "slug"      => $slug,
            "update_at" => date('d-m-Y h:i A'),
        );
        $where                     = array("where_column" => 'id', "where_value" => $id);
        $params_data->where_tables = array($where);
        $params_data->table_update = 'category';
        $update                    = $this->data_model->update($params_data);
        if ($update) {
            $data   = array("link" => $this->data['active_url'] . $id);
            $result = get_success($data);
        } else {
            $params           = new stdClass();
            $params->response = NO_DATA_STATUS;
            $params->message  = FAIL_STATUS;
            $params->data     = array("error" => $error_data);
            $result           = response_custom($params);
        }
        echo json_encode($result);
    }

    public function delete()
    {
        $id                   = $this->input->post("id");
        $delete               = new stdClass();
        $where                = array("where_column" => 'id', "where_value" => $id);
        $delete->where_tables = array($where);
        $delete->table        = 'category';
        $delete_data          = $this->data_model->delete($delete);

        if ($delete_data) {
            $result = response_success();
        } else {
            $result = response_fail();
        }
        echo json_encode($result);
    }

//OTHER FUNCTION

    public function attribute_json()
    {
        $category_property_id = $this->session->userdata("category_property_id");
        $get_attribute_data   = $this->get_attribute($category_property_id);
        echo json_encode(get_success($get_attribute_data));
    }

    public function attribute_latest()
    {
        $category_property_id = $this->session->userdata("category_property_id");
        $get_attribute_data   = $this->get_attribute($category_property_id);
        echo json_encode(get_success(end($get_attribute_data)));
    }

    public function attribute_post()
    {
        $name                 = $this->input->post('name');
        $type                 = $this->input->post('type');
        $count_as             = $this->input->post('count_as');
        $category_property_id = $this->session->userdata("category_property_id");

        $data_attribute = array(
            "category_property_id" => $category_property_id,
            "name"                 => $name,
            "type"                 => $type,
            "count_as"             => $count_as,
            "created_at"           => date('d-m-Y h:i A'),
            "update_at"            => date('d-m-Y h:i A'));
        $table         = 'attribute_category_property';
        $add_attribute = $this->data_model->add($data_attribute, $table);
        $id_attribute  = $add_attribute['data'];

        $options = $this->input->post('options');

        if (!empty($options)) {
            $options = json_decode($options);
            foreach ($options as $opts) {
                $data_opts = array(
                    "attribute_category_property_id" => $id_attribute,
                    "label"                          => $opts,
                    "created_at"                     => date('d-m-Y h:i A'),
                    "update_at"                      => date('d-m-Y h:i A'));
                $table_value         = 'value_attribute_category_property';
                $add_value_attribute = $this->data_model->add($data_opts, $table_value);
            }
        }

        if ($add_attribute) {
            $result = response_success();
        } else {
            $result = response_fail();
        }
        echo json_encode($result);
    }

    public function attribute_new()
    {
        $this->data['title_page']           = "Tambah Attribut";
        $this->data['category_property_id'] = $this->session->userdata("category_property_id");
        $this->specific_display('category/attribute_new', 'category/function');
    }

    public function attribute_detail()
    {
        $parameter             = $this->uri->segment(5);
        $params                = new stdClass();
        $params->dest_table_as = 'attribute_category_property';
        $params->select_values = array('*');
        $params->where_tables  = array(array("where_column" => 'id', "where_value" => $parameter));
        $get                   = $this->data_model->get($params);
        if (isset($get['results'][0])) {
            $this->data['title_page'] = "Detail Attribut";
            $v                        = new stdClass();
            $v->dest_table_as         = 'value_attribute_category_property';
            $v->select_values         = array('*');
            $v->where_tables          = array(array("where_column" => 'attribute_category_property_id', "where_value" => $parameter));
            $get_v                    = $this->data_model->get($v);
            if (isset($get_v['results'])) {
                $get['results'][0]->options = $get_v['results'];
            } else {
                $get['results'][0]->options = '';
            }
            $this->data['record'] = $get['results'][0];
            $this->session->set_userdata("attribute_category_property_id", $get['results'][0]->id);
            $this->specific_display('category/attribute_detail', 'category/function');
        } else {
            parent::notfound();
        }
    }

    public function attribute_update()
    {
        $id                    = $this->session->userdata("attribute_category_property_id");
        $name                  = $this->input->post("name");
        $type                  = $this->input->post("type");
        $count_as              = $this->input->post("count_as");
        $params_data           = new stdClass();
        $params_data->new_data = array(
            "name"      => $name,
            "type"      => $type,
            "count_as"  => $count_as,
            "update_at" => date('d-m-Y h:i A'),
        );
        $where                     = array("where_column" => 'id', "where_value" => $id);
        $params_data->where_tables = array($where);
        $params_data->table_update = 'attribute_category_property';
        $update                    = $this->data_model->update($params_data);

        $options = $this->input->post("options");
        if (!empty($options)) {
            $options = json_decode($options);
            foreach ($options as $opt) {
                $v_data           = new stdClass();
                $v_data->new_data = array(
                    "label"     => $opt->value,
                    "update_at" => date('d-m-Y h:i A'),
                );
                $v_where              = array("where_column" => 'id', "where_value" => $opt->id);
                $v_data->where_tables = array($where);
                $v_data->table_update = 'value_attribute_category_property';
                $v_update             = $this->data_model->update($v_data);
            }
        }

        $options_new = $this->input->post("options_new");
        if (!empty($options_new)) {
            $options_new = json_decode($options_new);
            foreach ($options_new as $opt) {
                $vn = array(
                    "label"                          => $opt,
                    "attribute_category_property_id" => $id,
                    "created_at"                     => date('d-m-Y h:i A'),
                    "update_at"                      => date('d-m-Y h:i A'),
                );
                $vn_table = 'value_attribute_category_property';
                $vn_add   = $this->data_model->add($vn, $vn_table);
            }
        }

        $options_delete = $this->input->post("options_delete");
        if (!empty($options_delete)) {
            $options_delete = json_decode($options_delete);
            foreach ($options_delete as $del) {
                $delete               = new stdClass();
                $where1               = array("where_column" => 'id', "where_value" => $del);
                $delete->where_tables = array($where1);
                $delete->table        = 'value_attribute_category_property';
                $delete_data          = $this->data_model->delete($delete);
            }
        }

        if ($update) {
            $data   = array("link" => $this->data['active_url'] . 'attribute/' . $id);
            $result = get_success($data);
        } else {
            $params           = new stdClass();
            $params->response = NO_DATA_STATUS;
            $params->message  = FAIL_STATUS;
            $params->data     = array("error" => $error_data);
            $result           = response_custom($params);
        }
        echo json_encode($result);
    }

    public function attribute_delete()
    {
        $id                   = $this->input->post('id');
        $delete               = new stdClass();
        $where1               = array("where_column" => 'id', "where_value" => $id);
        $delete->where_tables = array($where1);
        $delete->table        = 'attribute_category_property';
        $delete_data          = $this->data_model->delete($delete);
        if ($delete_data) {
            $result = response_success();
        } else {
            $result = response_fail();
        }
        echo json_encode($result);
    }

    public function get_attribute($category_property_id)
    {
        $params                = new stdClass();
        $params->dest_table_as = 'attribute_category_property';
        $params->select_values = array('*');
        $params->where_tables  = array(array("where_column" => 'category_property_id', "where_value" => $category_property_id));
        $get                   = $this->data_model->get($params);
        $data_return           = [];
        if ($get['results'] != "") {
            foreach ($get['results'] as $res) {
                $v                = new stdClass();
                $v->dest_table_as = 'value_attribute_category_property';
                $v->select_values = array('*');
                $v->where_tables  = array(array("where_column" => 'attribute_category_property_id', "where_value" => $res->id));
                $get_v            = $this->data_model->get($v);
                if ($get_v['results'] != "") {
                    foreach ($get_v['results'] as $each) {
                        $each->status = 'old';
                    }
                    $res->options = $get_v['results'];
                }
            }
            $data_return = $get['results'];
        }
        return $data_return;
    }

    public function get_subcategory($cat_id)
    {
        $params                = new stdClass();
        $params->dest_table_as = 'category_property';
        $params->select_values = array('*');
        $params->where_tables  = array(array("where_column" => 'parent_id', "where_value" => $cat_id));
        $get                   = $this->data_model->get($params);
        $data                  = [];
        if (!empty($get['results'])) {
            $data = $get['results'];
        }
        return $data;

    }

}
