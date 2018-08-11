<?php

class Front extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data = [];
        $this->load->library(array('user_agent', 'session'));
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->data['base_url'] = BASE_URL;
        $this->data['city_name'] = "";
    }

    public function render($location)
    {
        $this->load->view('public/include/head', $this->data);
        $this->load->view('public/include/top_menu');
        $this->load->view('public/' . $location);
        $this->load->view('public/include/footer_menu');
    }

    public function render_backend($location)
    {
        $this->load->view('backend/include/head', $this->data);
        $this->load->view('backend/' . $location);
    }

    public function not_found()
    {
        $this->render('404');
    }

    public function page()
    {
        $city_name = 'Indonesia';
        if ($this->uri->segment(1)) {            
            $city_name = strtolower(preg_replace("/[^a-zA-Z0-9]/", " ", $this->uri->segment(1)));
        }
        $this->data['city_name'] = $city_name;
        $this->data['news']      = $this->get_news('6');
        $this->render('dashboard');

    }

    public function cities()
    {
        $city = $this->get_city_available();
        $link = '';
        foreach ($city as $c) {
            $link .= '<a href="' . PUBLIC_WEBAPP_URL . $c->city . '">' . $c->city . '</a>';
        }
        echo $link;

    }

    public function login()
    {
        $this->data['url']         = base_url() . "submit_login_manage";
        $this->data['active_page'] = "login";
        $this->data['description'] = "";
        $this->data['title_page']  = "Masuk";
        $this->render_backend('login');
    }

     public function forgot_password()
    {
        $this->data['url']         = base_url() . "submit_forgot_password";
        $this->data['active_page'] = "forgot_password";
        $this->data['description'] = "";
        $this->data['title_page']  = "Lupa Password";
        $this->render_backend('forgot_password');
    }

    public function news()
    {
        $this->data['title_page'] = "Berita - Posting ID Group";
        $this->render('news_all');
    }

    public function json_news()
    {
        $news = $this->get_news();
        echo json_encode(get_success($news));
    }

    private function get_news($limit = null)
    {
        $this->load->library(array('curl', 'session', 'datatables'));
        $this->load->helper(array('form', 'url', 'jwt_helper', 'rest_response_helper', 'key_helper', 'image_process_helper', 'file', 'filemanager', 'cookie', 'send_mail_helper'));
        $p                = new stdClass();
        $p->dest_table_as = 'news as p';
        $p->select_values = array('p.*', 'cp.name as category_name');
        $join             = array("join_with" => 'category as cp', "join_on" => 'p.category_id = cp.id', "join_type" => '');
        $sort             = array("order_column" => 'p.id', "order_type" => 'desc');
        $p->order_by      = array($sort);
        $p->join_tables   = array($join);
        $p->limit         = $limit;
        $get_p            = $this->data_model->get($p);
        $results          = [];
        $total_produk     = count($get_p['results']);

        if ($get_p["results"] != "") {
            foreach ($get_p['results'] as $each) {
                $each->link         = PUBLIC_WEBAPP_URL . 'news/' . $each->slug;
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
        return $this->data['news'];
    }

    public function get_news_detail()
    {
        $slug                  = $this->uri->segment(2);
        $params                = new stdClass();
        $params->dest_table_as = 'news as p';
        $params->select_values = array('p.*', 'cp.name as category_name');
        $params->where_tables  = array(array("where_column" => 'p.slug', "where_value" => $slug));
        $join                  = array("join_with" => 'category as cp', "join_on" => 'p.category_id = cp.id', "join_type" => '');
        $params->join_tables   = array($join);
        $get                   = $this->data_model->get($params);
        if (isset($get['results'][0])) {
            $id = $get['results'][0]->id;
        } else {
            $get_from_city_news = $this->get_city_news_id($slug);
            if (!empty($get_from_city_news)) {
                $id                    = $get_from_city_news->news_id;
                $city_name             = $get_from_city_news->city_name;
                $dest_table_as         = 'news as p';
                $select_values         = array('p.*', 'cp.name as category_name', 'cp.slug as category_slug');
                $join                  = array("join_with" => 'category as cp', "join_on" => 'p.category_id = cp.id', "join_type" => 'LEFT');
                $where                 = array('where_column' => 'p.id', 'where_value' => $id);
                $params                = new stdClass();
                $params->dest_table_as = $dest_table_as;
                $params->select_values = $select_values;
                $params->where_tables  = array($where);
                $params->join_tables   = array($join);
                $get                   = $this->data_model->get($params);
            }
        }

        if (isset($id)) {

            $this->session->set_userdata("news_id", $id);
            $get['results'][0]->images_news = $this->get_news_images($id);
            foreach ($get['results'][0]->images_news as $each) {
                if ($each['thumbnail'] == 'yes') {
                    $get['results'][0]->thumbnail = $each['url'];
                }
            }
            $this->data['record']     = $get['results'][0];
            $this->data['title_page'] = $get['results'][0]->title;
            if (isset($city_name)) {
                $this->data['city_name']  = $city_name;
                $this->data['title_page'] = $get['results'][0]->title . " di " . $city_name;
            }
            $this->data['meta'] = $this->set_meta($get['results'][0]);
            $this->render('news_detail');
        } else {
            $this->not_found();
        }
    }

    private function get_news_images($id_news)
    {
        $this->load->helper(array('image_process_helper'));
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

    private function set_meta($data)
    {
        if (isset($this->data['title_page'])) {
            $title = $this->data['title_page'];
        } else {
            $title = $this->data['site']->title;
        }
        $meta = '';
        $meta .= '<title>' . $title . '</title>';
        $meta .= '<meta content="width=device-width, initial-scale=1.0" name="viewport" />';
        $meta .= '<meta content="width=device-width, initial-scale=1.0" name="viewport" />';
        $meta .= '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />';
        $meta .= '<meta content="' . strip_tags($data->description) . '" name="description" />';
        $meta .= '<meta content="' . strtolower(str_replace(" ", ",", ($data->title))) . '" name="keywords" />';
        $meta .= '<meta content="' . strtolower($data->category_name) . '" name="keywords" />';
        $meta .= '<meta content="Posting ID Group" name="author" />';
        $meta .= '<meta property="og:locale" content="en_US" />';
        $meta .= '<meta property="og:type" content="article" />';
        $meta .= '<meta property="og:title" content="' . $this->data['title_page'] . '" / />';
        $meta .= '<meta property="og:description" content="' . strip_tags($data->description) . '" />';
        $meta .= '<meta property="og:url" content="' . base_url() . 'news/' . $data->slug . '" />';
        $meta .= '<meta property="og:site_name" content= "Posting ID Group" />';
        $meta .= '<meta property="article:tag" content="' . strtolower($data->title) . '" />';
        $meta .= '<meta property="article:tag" content="' . strtolower($data->category_name) . '" />';
        $meta .= '<meta property="article:section" content="' . strtolower($data->category_name) . '" />';
        $meta .= '<meta property="article:published_time" content="' . $data->created_at . '" />';
        $meta .= '<meta property="og:image" content="' . $data->thumbnail . '">';
        $meta .= '<meta property="og:image:secure_url" content = "' . $data->thumbnail . '" />';
        $meta .= '<meta name= "twitter:card" content="summary" />';
        $meta .= '<meta name= "twitter:description" content= "' . strip_tags($data->description) . '" />';
        $meta .= '<meta name= "twitter:title" content= "' . $this->data['title_page'] . '" />';
        $meta .= '<meta name = "twitter:image" content = "' . $data->thumbnail . '" />';

        return $meta;

    }

    public function get_cities()
    {
        $this->load->helper(array('rest_response_helper'));
        $id                    = $this->session->userdata("news_id");
        $dest_table_as         = 'city_news';
        $select_values         = array('city_name', 'slug');
        $where                 = array('where_column' => 'news_id', 'where_value' => $id);
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $params->where_tables  = array($where);
        $get                   = $this->data_model->get($params);
        $arr                   = [];
        if (!empty($get['results'])) {
            foreach ($get['results'] as $res) {
                $res->city_name = str_replace("-", " ", $res->city_name);
                $res->slug      = base_url() . 'news/' . $res->slug;
            }

            if (count($get['results']) > 50) {
                $split_1 = array_slice($get['results'], 0, 50);
                $split_2 = array_slice($get['results'], 50);
                $arr     = array($split_1, $split_2);
            } else {
                $arr = $get['results'];
            }

        }

        echo json_encode(get_success($arr));
    }

    public function get_city_news_id($slug)
    {
        $dest_table_as         = 'city_news';
        $select_values         = array('city_name', 'news_id');
        $where                 = array('where_column' => 'slug', 'where_value' => $slug);
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $params->where_tables  = array($where);
        $get                   = $this->data_model->get($params);
        if (!empty($get['results'])) {
            return $get['results'][0];
        }
    }

    private function get_city_available($limit = null)
    {
        // SELECT city_name, count(property_id) as total_product FROM city_news GROUP BY city_name ORDER BY sum(property_id) desc limit 50
        $dest_table_as         = 'city_news';
        $select_values         = array('city_name as city');
        $groupby               = 'city_name';
        $sort                  = array("order_column" => 'sum(news_id)', "order_type" => 'desc');
        $params                = new stdClass();
        $params->dest_table_as = $dest_table_as;
        $params->select_values = $select_values;
        $params->group_by      = $groupby;
        $params->order_by      = array($sort);
        if ($limit != null) {
            $params->limit = $limit;
        }

        $get = $this->data_model->get($params);
        if (!empty($get['results'])) {
            foreach ($get['results'] as $res) {
                $res->link = PUBLIC_WEBAPP_URL . 'product/city/' . strtolower($res->city);
            }
        }

        return $get['results'];
    }

}
