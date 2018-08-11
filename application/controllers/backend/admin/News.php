<?php

defined('BASEPATH') or exit('No direct script access allowed');

include dirname(__FILE__) . "/Admin.php";

class news extends admin
{
    public function __construct()
    {
        parent::__construct();
        $this->data['active_page']           = "news";
        $this->data['main_breadcrumb_title'] = "Berita";
        $this->data['active_url']            = ADMIN_WEBAPP_URL . $this->data['active_page'] . '/';

    }

    public function json()
    {
        if ($this->input->post('last_id')) {
            $start = $this->input->post('last_id');
        } else {
            $start = '0';
        }

        $p                = new stdClass();
        $p->dest_table_as = 'news as p';
        $p->select_values = array('p.*', 'cp.name as category_name');
        $join             = array("join_with" => 'category as cp', "join_on" => 'p.category_id = cp.id', "join_type" => '');
        $sort             = array("order_column" => 'p.id', "order_type" => 'desc');
        $p->order_by      = array($sort);
        $p->join_tables   = array($join);
        $get_p            = $this->data_model->get($p);
        $results          = [];
        $total_produk     = count($get_p['results']);

        if ($get_p["results"] != "") {
            foreach ($get_p['results'] as $each) {
                $each->link         = PUBLIC_WEBAPP_URL . 'news/' . $each->slug;
                $each->edit_link    = ADMIN_WEBAPP_URL . 'news/' . $each->id;
                $each->description  = str_split(substr($each->description, 0, 150), 100);
                $each->description  = $each->description[0] . "...";
                $dest               = 'images_news';
                $select             = array('name');
                $where1             = array("where_column" => 'news_id', "where_value" => $each->id);
                $where2             = array("where_column" => 'thumbnail', "where_value" => 'yes');
                $img                = new stdClass();
                $img->dest_table_as = $dest;
                $img->select_values = $select;
                $img->where_tables  = array($where1, $where2);
                $get_img            = $this->data_model->get($img);
                $each->thumb_url    = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'dummy_logo.png';
                if (isset($get_img['results'][0])) {
                    $dir             = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/news/';
                    $image_dir_thumb = $dir . $get_img['results'][0]->name;
                    $check_thumb     = check_if_empty($get_img['results'][0]->name, $image_dir_thumb);
                    if ($check_thumb == NO_IMG_NAME) {
                        $each->thumb_url = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'dummy_logo.png';
                    } else {
                        $each->thumb_url = BASE_URL . $dir . $check_thumb;
                    }
                }
            }
            $this->data['news']         = $get_p["results"];
            $total_produk               = $this->data_model->get_count('news');
            $this->data['total_produk'] = $total_produk['results'];

        }

        echo json_encode(get_success($this->data['news']));
    }

    public function search()
    {
        $start                = '0';
        $keyword              = $this->input->post('keyword');
        $p                    = new stdClass();
        $p->dest_table_as     = 'news as p';
        $p->select_values     = array('p.*', 'cp.name as category_name');
        $p->pagination        = ['offset' => '8', 'start' => $start];
        $join                 = array("join_with" => 'category as cp', "join_on" => 'p.category_id = cp.id', "join_type" => '');
        $sort                 = array("order_column" => 'p.id', "order_type" => 'desc');
        $where1               = array("where_column" => 'title', "where_value" => $keyword);
        $p->order_by          = array($sort);
        $p->join_tables       = array($join);
        $p->where_tables_like = array($where1);
        $get_p                = $this->data_model->get($p);
        // print_data($get_p);
        $results      = [];
        $total_produk = count($get_p['results']);

        if ($get_p["results"] != "") {
            foreach ($get_p['results'] as $each) {
                $each->link         = $this->data['active_url'] . $each->id;
                $each->description  = str_split(substr($each->description, 0, 150), 100);
                $each->description  = $each->description[0] . "...";
                $dest               = 'images_news';
                $select             = array('name');
                $where1             = array("where_column" => 'news_id', "where_value" => $each->id);
                $where2             = array("where_column" => 'thumbnail', "where_value" => 'yes');
                $img                = new stdClass();
                $img->dest_table_as = $dest;
                $img->select_values = $select;
                $img->where_tables  = array($where1, $where2);
                $get_img            = $this->data_model->get($img);
                $each->thumb_url    = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'dummy_logo.png';
                if (isset($get_img['results'][0])) {
                    $dir             = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/news/';
                    $image_dir_thumb = $dir . $get_img['results'][0]->name;
                    $check_thumb     = check_if_empty($get_img['results'][0]->name, $image_dir_thumb);
                    if ($check_thumb == NO_IMG_NAME) {
                        $each->thumb_url = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'dummy_logo.png';
                    } else {
                        $each->thumb_url = BASE_URL . $dir . $check_thumb;
                    }
                }
            }
            $this->data['news']         = $get_p["results"];
            $total_produk               = $this->data_model->get_count('news');
            $total_page                 = $total_produk['results'] / 8;
            $this->data['page_total']   = $total_page;
            $this->data['active_page']  = "all_product";
            $this->data['total_produk'] = $total_produk['results'];
        }

        echo json_encode(get_success($this->data['news']));
    }

    public function add()
    {
        $this->data['title_page'] = "Buat Berita";
        $category_news            = $this->get_category_news();
        $category_news_options    = array();
        $category_news_options[0] = "Pilih";
        foreach ($category_news as $item) {
            $category_news_options[$item->id] = $item->name;
        }
        $this->data['category_news_options'] = $category_news_options;
        set_filemanager('system/news');
        $this->specific_display('news/new', 'news/function');
    }

    private function get_category_news()
    {
        $params                = new stdClass();
        $params->dest_table_as = 'category';
        $params->select_values = array('*');
        $get                   = $this->data_model->get($params);

        $data = $get['results'];

        return $data;
    }

    public function post()
    {
        $title        = $this->input->post("title");
        $desc         = $this->input->post("desc");
        $catid        = $this->input->post("category");
        $default_slug = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $title));
        $slug         = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $title) . ".html");
        $images       = $this->input->post("images_data");
        $thumbnail    = $this->input->post("image_thumbnail");
        $params_data  = array(
            "title"        => $title,
            "category_id"  => $catid,
            "description"  => $desc,
            "default_slug" => $default_slug,
            "slug"         => $slug,
            "created_at"   => date('d-m-Y h:i A'),
            "update_at"    => date('d-m-Y h:i A'),
        );

        $dest_table = 'news';
        $add        = $this->data_model->add($params_data, $dest_table);
        $new_id     = $add["data"];

        if (!empty($images)) {
            $images = json_decode($images);
            foreach ($images as $each) {
                $data = array(
                    "news_id"    => $new_id,
                    "name"       => $each->name,
                    "type"       => "I",
                    "created_at" => date('d-m-Y h:i A'),
                    "update_at"  => date('d-m-Y h:i A'));
                $table      = 'images_news';
                $add_images = $this->data_model->add($data, $table);
            }
        }

        if (!empty($thumbnail)) {
            //step 1
            $img_data           = new stdClass();
            $img_data->new_data = array(
                "thumbnail"  => '',
                "created_at" => date('d-m-Y h:i A'),
                "update_at"  => date('d-m-Y h:i A'),
            );
            $where1                 = array("where_column" => 'news_id', "where_value" => $new_id);
            $img_data->where_tables = array($where1);
            $img_data->table_update = 'images_news';
            $img_data_update        = $this->data_model->update($img_data);

            //step 2
            $img_data           = new stdClass();
            $img_data->new_data = array(
                "thumbnail"  => 'yes',
                "created_at" => date('d-m-Y h:i A'),
                "update_at"  => date('d-m-Y h:i A'),
            );
            $where1                 = array("where_column" => 'news_id', "where_value" => $new_id);
            $where2                 = array("where_column" => 'name', "where_value" => $thumbnail);
            $img_data->where_tables = array($where1, $where2);
            $img_data->table_update = 'images_news';
            $img_data_update        = $this->data_model->update($img_data);
        }

        if ($add) {
            $data   = array("link" => $this->data['active_url'] . $new_id);
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
        $params->dest_table_as = 'news';
        $params->select_values = array('*');
        $params->where_tables  = array(array("where_column" => 'id', "where_value" => $parameter));
        $get                   = $this->data_model->get($params);
        if (isset($get['results'][0])) {
            $this->data['title_page'] = 'Detail Berita';
            $this->session->set_userdata("news_id", $get['results'][0]->id);
            $this->data['images_news'] = $this->get_news_images($get['results'][0]->id);
            $category_news             = $this->get_category_news();
            $category_news_options     = array();
            $category_news_options[0]  = "Pilih";
            foreach ($category_news as $item) {
                $category_news_options[$item->id] = $item->name;
            }
            $this->data['category_news_options'] = $category_news_options;
            $city_news                           = $this->get_city_news($get['results'][0]->id);
            $this->data['city_news']             = $city_news;
            $selected_city                       = [];
            if (!empty($city_news)) {
                foreach ($city_news as $cp) {
                    $cp_array = "";
                    $cp_array = array("txt" => $cp . 'txt', "name" => $cp, "cities" => "", "status" => "O");
                    array_push($selected_city, $cp_array);
                }
            }
            $this->data['selected_city'] = json_encode($selected_city);
            set_filemanager('system/news');
            $this->data['record'] = $get['results'][0];
            $this->specific_display('news/get', 'news/function');
        } else {
            parent::notfound();
        }
    }

    public function update()
    {
        $id            = $this->session->userdata("news_id");
        $title         = $this->input->post("title");
        $title_old     = $this->input->post("title_old");
        $slug          = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $title) . ".html");
        $default_slug  = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $title));
        $catid         = $this->input->post("category");
        $desc          = $this->input->post("desc");
        $images        = $this->input->post("images_data");
        $thumbnail     = $this->input->post("image_thumbnail");
        $images_delete = $this->input->post("deleted_images_data");
        $city_news     = $this->input->post("city_news");
        $error         = [];

        $params_data           = new stdClass();
        $params_data->new_data = array(
            "title"        => $title,
            "category_id"  => $catid,
            "description"  => $desc,
            "slug"         => $slug,
            "default_slug" => $default_slug,
            "update_at"    => date('d-m-Y h:i A'),
        );
        $where                     = array("where_column" => 'id', "where_value" => $id);
        $params_data->where_tables = array($where);
        $params_data->table_update = 'news';
        $update                    = $this->data_model->update($params_data);

        if (!empty($images_delete)) {
            $images_delete = json_decode($images_delete);
            foreach ($images_delete as $del_img) {
                $delete               = new stdClass();
                $where1               = array("where_column" => 'id', "where_value" => $del_img);
                $delete->where_tables = array($where1);
                $delete->table        = 'images_news';
                $delete_data          = $this->data_model->delete($delete);
            }
        }

        if (!empty($images)) {
            $images = json_decode($images);
            foreach ($images as $each) {
                $data = array(
                    "news_id"    => $id,
                    "name"       => $each->name,
                    "type"       => "I",
                    "created_at" => date('d-m-Y h:i A'),
                    "update_at"  => date('d-m-Y h:i A'));
                $table      = 'images_news';
                $add_images = $this->data_model->add($data, $table);
            }
        }

        if (!empty($thumbnail)) {
            //step 1
            $img_data           = new stdClass();
            $img_data->new_data = array(
                "thumbnail"  => '',
                "created_at" => date('d-m-Y h:i A'),
                "update_at"  => date('d-m-Y h:i A'),
            );
            $where1                 = array("where_column" => 'news_id', "where_value" => $id);
            $img_data->where_tables = array($where1);
            $img_data->table_update = 'images_news';
            $img_data_update        = $this->data_model->update($img_data);

            //step 2
            $img_data           = new stdClass();
            $img_data->new_data = array(
                "thumbnail"  => 'yes',
                "created_at" => date('d-m-Y h:i A'),
                "update_at"  => date('d-m-Y h:i A'),
            );
            $where1                 = array("where_column" => 'news_id', "where_value" => $id);
            $where2                 = array("where_column" => 'name', "where_value" => $thumbnail);
            $img_data->where_tables = array($where1, $where2);
            $img_data->table_update = 'images_news';
            $img_data_update        = $this->data_model->update($img_data);
        }

        if (!empty($city_news)) {
            $city_news = json_decode($city_news);
            foreach ($city_news as $city) {
                if ($city->status == 'N') {
                    $count_cities = $this->count_city_news($id, $city->name);
                    if ($count_cities > $city->cities_total or $count_cities < $city->cities_total) {
                        $delete_city_news = $this->delete_city_news($id, $city->name);
                    }

                    foreach ($city->cities as $each_city) {
                        $city_slug = strtolower(preg_replace("/[^a-zA-Z0-9]/", "-", $each_city));
                        $slug      = strtolower($default_slug . "-di-" . $city_slug . ".html");
                        $data      = array(
                            "news_id"    => $id,
                            "city_name"  => $each_city,
                            "pgp_name"   => $city->name,
                            "city_slug"  => $city_slug,
                            "slug"       => $slug,
                            "created_at" => date('d-m-Y h:i A'),
                            "update_at"  => date('d-m-Y h:i A'));
                        $table    = 'city_news';
                        $add_city = $this->data_model->add($data, $table);
                    }

                }
            }
        }

        if ($title != $title_old) {
            $use_concat = array(
                "destination" => 'slug',
                "concat_arg"  => "'" . $default_slug . "-di" . "'" . "," . " '-' " . "," . 'city_slug' . "," . "'" . ".html" . "'",
                "update_date" => true,
            );
            $title_params               = new stdClass();
            $where_                     = array("where_column" => 'news_id', "where_value" => $id);
            $title_params->where_tables = array($where_);
            $title_params->table_update = 'city_news';
            $title_update               = $this->data_model->update($title_params, $use_concat);
        }

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
        $id                    = $this->input->post('id');
        $params                = new stdClass();
        $params->dest_table_as = 'images_news as t';
        $params->select_values = array('t.name');
        $params->where_tables  = array(array("where_column" => 't.news_id', "where_value" => $id));
        $get                   = $this->data_model->get($params);

        if (!empty($get['results'])) {
            foreach ($get['results'] as $each) {
                $file         = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/news/' . $each->name;
                $unlink_files = unlink($file);
                if (!$unlink_files) {
                    $unlink_files = true;
                }
            }

        }

        $delete               = new stdClass();
        $where1               = array("where_column" => 'id', "where_value" => $id);
        $delete->where_tables = array($where1);
        $delete->table        = 'news';
        $delete_data          = $this->data_model->delete($delete);
        if ($delete_data) {
            $result = response_success();
        } else {
            $result = response_fail();
        }
        echo json_encode($result);
    }

//OTHER FUNCTION
    private function get_news_images($id_news)
    {
        $dest_table_as         = 'images_news';
        $select_values         = array('*');
        $where                 = array('where_column' => 'news_id', 'where_value' => $id_news);
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->where_tables  = array($where);
        $params->select_values = $select_values;
        $get                   = $this->data_model->get($params);
        $dir                   = BACKEND_IMAGE_UPLOAD_FOLDER . 'system/news/';
        $images_all            = [];

        if (!empty($get['results'])) {
            foreach ($get['results'] as $img) {
                $name      = $img->name;
                $image_dir = $dir . $name;
                $check     = check_if_empty($name, $image_dir);
                if ($check == NO_IMG_NAME) {
                    $url = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'image_not_exist.png';
                } else {
                    $url = BASE_URL . $image_dir;
                }
                $data_url = array("id" => $img->id, "url" => $url, "name" => $name, "type" => $img->type, "thumbnail" => $img->thumbnail);
                array_push($images_all, $data_url);
            }
        }

        return $images_all;
    }

    public function get_dataset()
    {
        // $this->load->helper('directory');

        $map  = file_get_contents('http://www.postgeneratorpro.com/wp-content/uploads/pgp/');
        $data = strip_tags($map);
        $data = explode(' ', $data);
        $word = [];
        foreach ($data as $each) {
            if (strpos($each, '.txt') == true) {
                array_push($word, $each);
            }
        }

        $word2 = [];

        foreach ($word as $w) {
            $str = substr($w, 0, strpos($w, ".txt")); // }
            $str = str_replace('.', '', $str);
            $str = preg_replace('/[0-9]/', false, $str);
            $str = str_replace('K', false, $str);
            $str = str_replace('&nbsp;', false, $str);
            $str = trim($str);

            array_push($word2, $str);
        }

        echo json_encode(get_success($word2));

    }

    public function get_city_news($news_id)
    {
        $dest_table_as         = 'city_news';
        $select_values         = array('DISTINCT(pgp_name)');
        $where                 = array('where_column' => 'news_id', 'where_value' => $news_id);
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->where_tables  = array($where);
        $params->select_values = $select_values;
        $get                   = $this->data_model->get($params);
        $arr                   = [];
        foreach ($get['results'] as $each) {
            array_push($arr, $each->pgp_name);
        }
        return $arr;
    }

    public function get_dataset_city()
    {
        $parameter = $this->uri->segment(5);
        $data      = file_get_contents('http://www.postgeneratorpro.com/wp-content/uploads/pgp/' . $parameter, FILE_IGNORE_NEW_LINES);
        $data      = str_replace(' ', '-', $data);
        $data      = str_replace('|', '', $data);
        $data      = str_replace('{', false, $data);
        $data      = str_replace('}', false, $data);
        $data      = str_replace("\r", false, $data);
        $data      = trim($data);
        $data      = explode("\n", $data);
        echo json_encode(get_success($data));
    }

    public function count_city_news($id_property, $pgp_name)
    {
        $dest_table_as         = 'city_news';
        $select_values         = array('count(id) as id_count');
        $where                 = array('where_column' => 'news_id', 'where_value' => $id_property);
        $where1                = array('where_column' => 'pgp_name', 'where_value' => $pgp_name);
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->where_tables  = array($where, $where1);
        $params->select_values = $select_values;
        $get                   = $this->data_model->get($params);
        return $get['results'][0]->id_count;
    }

    public function delete_city_news($id_property, $pgp_name)
    {
        $delete               = new stdClass();
        $where1               = array("where_column" => 'news_id', "where_value" => $id_property);
        $where2               = array('where_column' => 'pgp_name', 'where_value' => $pgp_name);
        $delete->where_tables = array($where1, $where2);
        $delete->table        = 'city_news';
        $delete_data          = $this->data_model->delete($delete);
    }

    public function delete_dataset()
    {
        $id_property = $this->session->userdata("news_id");
        $pgp_name    = $this->input->post('pgp_name');
        $delete      = $this->delete_city_news($id_property, $pgp_name);

        echo json_encode(response_success());

    }
}
