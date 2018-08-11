<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

function get_main_email()
{
    $ci = &get_instance();
    $ci->load->model('data_model');
    $parameter             = '0';
    $params                = new stdClass();
    $params->dest_table_as = 'setting';
    $params->select_values = array('email');
    $params->where_tables  = array(array("where_column" => 'id', "where_value" => $parameter));
    $get                   = $ci->data_model->get($params);
    return $get['results'][0]->email;
}

function send_mail($params)
{
    $ci = &get_instance();
    $ci->load->library('email');
    $ci->email->from($params->from_email, '');
    $ci->email->to($params->destination_email);
    $ci->email->subject($params->subject);
    $ci->email->message($params->message);
    $ci->email->set_mailtype("html");
    $ci->email->send();
}

function save_mail($params)
{
    $ci = &get_instance();
    $ci->load->model('data_model');
    $params_data = array(
        "code"        => $params->code,
        "event"       => $params->event,
        "destination" => $params->destination_email,
        "subject"     => $params->subject,
        "message"     => $params->message,
        "status"      => $params->status,
        "user_type"   => $params->user_type,
        "user_id"     => $params->user_id,
        "created_at"  => date('d-m-Y h:i A'),
        "update_at"   => date('d-m-Y h:i A'),
    );
    $dest_table = 'mail_log';
    $add        = $ci->data_model->add($params_data, $dest_table);
}
