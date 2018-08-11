<?php
class authentication extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('data_model');
        $this->load->library(array('curl', 'session', 'email'));
        $this->load->helper(array('form', 'url', 'jwt_helper', 'rest_response_helper', 'key_helper', 'send_mail_helper', 'client_access_helper',
            'image_process_helper'));
        $this->data = [];
    }

    private function _create_hash($password_to_hash)
    {
        return create_hash($password_to_hash);
    }

    public function submit_login_manage()
    {
        $this->submit_login(true);
    }

    public function submit_register()
    {
        $process_response               = new stdClass();
        $process_response->response     = FAIL_STATUS;
        $process_response->message      = "Terjadi Kesalahan";
        $process_response->error_status = false;
        $process_response->error        = [];
        $process_response->data         = "";
        if ($this->input->post('nameuser') == '') {
            array_push($process_response->error, 'Nama tidak boleh kosong');
            $process_response->error_status = true;
        }
        if ($this->input->post('emailuser') == '') {
            array_push($process_response->error, 'Email tidak boleh kosong');
            $process_response->error_status = true;
        }
        if ($this->input->post('passworduser') == '') {
            array_push($process_response->error, 'Password tidak boleh kosong');
            $process_response->error_status = true;
        }

        $result = response_custom($process_response);
        if ($process_response->error_status == false) {
            if (!empty($this->input->post())) {
                $name        = $this->input->post('nameuser');
                $email       = $this->input->post('emailuser');
                $password    = $this->_create_hash($this->input->post('passworduser'));
                $params_data = array(
                    "name"       => $name,
                    "email"      => $email,
                    "password"   => $password,
                    "created_at" => date('d-m-Y h:i A'),
                    "update_at"  => date('d-m-Y h:i A'),
                );
                $dest_table = 'user';
                $add        = $this->data_model->add($params_data, $dest_table);
                $new_id     = $add["data"];

                if ($add) {
                    $p                    = new stdClass();
                    $p->from_email        = 'toriqpriad@gmail.com';
                    $p->destination_email = 'toriqpriad@gmail.com';
                    $p->subject           = "Pendaftaran User Baru di Iklamedia";
                    $p->message           = 'User baru telah mendaftar atas nama ' . $name . ' . Harap segera di proses';
                    $p->code              = generate_key();
                    $p->event             = "UR";
                    $p->status            = "N";
                    $p->user_type         = "A";
                    $p->user_id           = "";
                    $send_to_admin        = send_mail($p);
                    $save_email_admin     = save_mail($p);
                    // SEND TO USER
                    $u                    = new stdClass();
                    $u->code              = generate_key();
                    $u->link              = BASE_URL . 'register/confirmation/' . $u->code;
                    $u->from_email        = 'toriqpriad@gmail.com';
                    $u->destination_email = $email;
                    $u->subject           = "Pendaftaran User Baru di Iklamedia";
                    $u->message           = 'Terima kasih ' . $name . ' telah mendaftar sebagai user. Informasi pendaftaran telah dikirimkan. Akses halaman ini untuk memverifikasi pendaftaran Anda. <br> <a href="' . $u->link . '">' . $u->link . '</a>';
                    $u->event             = "UR";
                    $u->status            = "N";
                    $u->user_type         = "U";
                    $u->user_id           = $new_id;
                    $send_to_user         = send_mail($u);
                    $save_email_user      = save_mail($u);
                    $result               = response_success();
                } else {
                    $process_response->error_status = true;
                }
            }
        }

        if ($process_response->error_status == false) {
            $status = 'success';
        } else {
            $status = 'failed';
        }

        $result = $this->session->set_flashdata('registered', $status);
        redirect('register');
    }

    public function submit_confirmation()
    {
        $code             = $this->uri->segment(3);
        $p                = new stdClass();
        $p->dest_table_as = "mail_log";
        $p->select_values = array('*');
        $w                = array("where_column" => 'code', "where_value" => $code);
        $p->where_tables  = array($w);
        $get              = $this->data_model->get($p);
        $confirmed        = new stdClass();
        if (!isset($get['results'][0])) {
            $confirmed->status  = FAIL_STATUS;
            $confirmed->message = "Link tidak ditemukan";
            $this->redir_login($confirmed);
            exit();
        }
        if ($get['results'][0]->status == 'E') {
            $confirmed->status  = FAIL_STATUS;
            $confirmed->message = "Link verifikasi kadaluarsa";
            $this->redir_login($confirmed);
            exit();
        }

        // UPDATE MAIL LOG STATUS
        $params_data           = new stdClass();
        $params_data->new_data = array(
            "status"    => 'E',
            "update_at" => date('d-m-Y h:i A'),
        );
        $where                     = array("where_column" => 'code', "where_value" => $code);
        $params_data->where_tables = array($where);
        $params_data->table_update = 'mail_log';
        $update                    = $this->data_model->update($params_data);

        //UPDATE USER STATUS
        $u           = new stdClass();
        $u->new_data = array(
            "status"    => 'A',
            "update_at" => date('d-m-Y h:i A'),
        );
        $where_user      = array("where_column" => 'id', "where_value" => $get['results'][0]->user_id);
        $u->where_tables = array($where_user);
        $u->table_update = 'user';
        $update_user     = $this->data_model->update($u);
        if ($update_user) {
            $confirmed->status = OK_STATUS;
        } else {
            $confirmed->status  = FAIL_STATUS;
            $confirmed->message = "Terjadi Kesalahan";
        }
        $this->redir_login($confirmed);
    }

    private function redir_error($warning, $redir_route)
    {
        $result = $this->session->set_flashdata('confirmed', $warning);
        redirect($redir_route);
    }

    public function submit_login($admin_login = null)
    {
        $param_fail               = new stdClass();
        $param_fail->response     = FAIL_STATUS;
        $param_fail->message      = "Terjadi Kesalahan";
        $param_fail->error_status = false;
        $param_fail->error        = [];
        $param_fail->data         = "";
        $warn                     = new stdClass();
        if ($this->input->post('email') == '') {
            $warn->status  = FAIL_STATUS;
            $warn->message = "Email tidak boleh kosong";
            $this->redir_error($warn, 'manage');
            exit();
        }

        if ($this->input->post('password') == '') {
            $warn->status  = FAIL_STATUS;
            $warn->message = "Password tidak boleh kosong";
            $this->redir_error($warn, 'manage');
            exit();
        }

        $params        = new stdClass();
        $dest_table_as = 'user';
        if ($admin_login == true) {
            $dest_table_as   = 'setting';
            $user_role_admin = 'A';
        }

        $params->dest_table_as = $dest_table_as;
        $params->select_values = array('*');
        $where1                = array("where_column" => 'email', "where_value" => $this->input->post('email'));
        $hash_password         = $this->_create_hash($this->input->post('password'));
        $where2                = array("where_column" => 'password', "where_value" => $hash_password);
        $params->where_tables  = array($where1, $where2);
        $get                   = $this->data_model->get($params);
        // print_r($get);exit();

        if (!isset($get['results'][0])) {
            $warn->status  = FAIL_STATUS;
            $warn->message = "Email dan password tidak sesuai";
            if (isset($user_role_admin)) {
                $result = $this->session->set_flashdata('confirmed', $warn);
                redirect('manage');
            } else {
                $this->redir_error($warn, 'manage');
            }
            exit();
        }

        if (isset($get['results'][0]->status)) {
            if ($get['results'][0]->status == 'N') {
                $warn->status  = FAIL_STATUS;
                $warn->message = "Akun anda belum terverifikasi, periksa email Anda untuk melakukan verifikasi data.";
                $this->redir_error($warn, 'manage');
                exit();
            }
        }

        if (isset($user_role_admin)) {
            $get['results'][0]->role = 'A';
        }

        $session_data = $this->_create_session_data($get['results'][0]);
        $cookie       = array(
            'name'   => 'admin_url',
            'value'  => $session_data['backend_url'],
            'expire' => '86500',
        );

        $this->input->set_cookie($cookie);
        redirect($session_data['backend_url'], 'refresh');

    }

    private function _create_session_data($data)
    {

        $role         = $data->role;
        $id           = $data->id;
        $redirect_url = '';

        if ($role == "A") {
            $redirect_url = ADMIN_WEBAPP_URL;
        } elseif ($role == "AG") {
            $redirect_url = AGENCY_WEBAPP_URL;
        } else {
            $redirect_url = USER_WEBAPP_URL;
        }

        if ($data->logo != "") {
            $logo        = $data->logo;
            $dir         = BACKEND_IMAGE_UPLOAD_FOLDER;
            $image_dir   = $dir . 'logo/' . $logo;
            $check_thumb = check_if_empty($logo, $image_dir);
            if ($check_thumb == NO_IMG_NAME) {
                $logo_data = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'dummy_logo.png';
            } else {
                $logo_data = BASE_URL . $dir . 'logo/' . $check_thumb;
            }
        } else {
            $logo_data = BASE_URL . BACKEND_IMAGE_UPLOAD_FOLDER . 'dummy_logo.png';
        }

        $data_session['name']     = $data->name;
        $data_session['logo_url'] = $logo_data;
        $data_session['role']     = $role;
        $data_session['id']       = $id;
        $set_session              = $this->session->set_userdata("user", $data_session);

        $return = array("backend_url" => $redirect_url, "role" => $data_session['role']);
        return $return;
    }

    public function submit_forgot_password()
    {
        $param_fail               = new stdClass();
        $param_fail->response     = FAIL_STATUS;
        $param_fail->message      = "Terjadi Kesalahan";
        $param_fail->error_status = false;
        $param_fail->error        = [];
        $param_fail->data         = "";
        $warn                     = new stdClass();
        if ($this->input->post('email') == '') {
            $warn->status  = FAIL_STATUS;
            $warn->message = "Email tidak boleh kosong";
            $this->redir_error($warn, 'forgot_password');
            exit();
        }
        $email                 = $this->input->post('email');
        $params                = new stdClass();
        $dest_table_as         = 'setting';
        $params->dest_table_as = $dest_table_as;
        $params->select_values = array('email');
        $where1                = array("where_column" => 'email', "where_value" => $email);
        $params->where_tables  = array($where1);
        $get                   = $this->data_model->get($params);
        if (!isset($get['results'][0])) {
            $warn->status  = FAIL_STATUS;
            $warn->message = "Email tidak sesuai";
            $this->redir_error($warn, 'forgot_password');
            exit();
        } else {
            $params_data               = new stdClass();
            $new_pass                  = generate_key();
            $new_password_hash         = create_hash($new_pass);
            $params_data->new_data     = array("password" => $new_password_hash);
            $where                     = array("where_column" => 'id', "where_value" => "0");
            $params_data->where_tables = array($where);
            $params_data->table_update = 'setting';
            $update                    = $this->data_model->update($params_data);
            if ($update["response"] == OK_STATUS) {
                $p                    = new stdClass();
                $p->from_email        = $email;
                $p->destination_email = $email;
                $p->subject           = "Posting ID Group - Reset Password";
                $p->message           = 'Anda telah melakukan permintaan untuk me-reset password, gunakan text di bawah ini sebagai password sementara untuk login di halaman di halaman <a href="' . PUBLIC_WEBAPP_URL . 'manage">' . PUBLIC_WEBAPP_URL . 'manage</a> : <br> Password Sementara Anda : <b>' . $new_pass . '</b>';
                $p->code              = generate_key();
                $p->event             = "UR";
                $p->status            = "N";
                $p->user_type         = "A";
                $p->user_id           = "";
                $send_to_admin        = send_mail($p);
                $save_email_admin     = save_mail($p);
                $warn->status         = OK_STATUS;
                $warn->message        = "Berhasil, silakan cek email";
                $this->redir_error($warn, 'forgot_password');
                exit();
            } else {
                $warn->status  = FAIL_STATUS;
                $warn->message = "Terjadi Kesalahan";
                $this->redir_error($warn, 'forgot_password');
                exit();
            }
        }

    }

}
