<?php

defined('BASEPATH') or exit('No direct script access allowed');

//front
$route['default_controller']   = 'welcome/index';
$route['404_override']         = 'front/not_found';
$route['translate_uri_dashes'] = false;

//front
$route['notfound'] = 'front/notfound';
// $route['home']     = 'front/home';
// $route['home']     = 'front/index';
$route['home']                                  = 'front/page';
$route['about_us']                              = 'front/about_us';
$route['contact']                               = 'front/contact';
$route['manage']                                = 'front/login';
$route['forgot_password']                       = 'front/forgot_password';
$route['cities']                                = 'front/cities';
$route['news']                                  = 'front/news';
$route['news/json']                             = 'front/json_news';
$route['news/cities']                           = 'front/get_cities';
$route['news/(:any)']                           = 'front/get_news_detail';
$route['submit_login_manage']                   = 'authentication/submit_login_manage';
$route['submit_forgot_password']                = 'authentication/submit_forgot_password';
$route['backend/admin']                         = 'backend/admin/admin/dashboard';
$route['backend/admin/setting']                 = 'backend/admin/admin/setting';
$route['backend/admin/setting/update']          = 'backend/admin/admin/setting_update';
$route['backend/admin/setting/update_password'] = 'backend/admin/admin/password_update';
$route['backend/admin/category/json']           = 'backend/admin/category/json';
$route['backend/admin/category/post']           = 'backend/admin/category/post';
$route['backend/admin/category/update']         = 'backend/admin/category/update';
$route['backend/admin/category/delete']         = 'backend/admin/category/delete';
$route['backend/admin/category/(:any)']         = 'backend/admin/category/get';
$route['backend/admin/news/json']               = 'backend/admin/news/json';
$route['backend/admin/news/add']                = 'backend/admin/news/add';
$route['backend/admin/news/json']               = 'backend/admin/news/json';
$route['backend/admin/news/post']               = 'backend/admin/news/post';
$route['backend/admin/news/update']             = 'backend/admin/news/update';
$route['backend/admin/news/delete']             = 'backend/admin/news/delete';
$route['backend/admin/news/dataset']            = 'backend/admin/news/get_dataset';
$route['backend/admin/news/dataset/delete']     = 'backend/admin/news/delete_dataset';
$route['backend/admin/news/dataset/(:any)']     = 'backend/admin/news/get_dataset_city';
$route['backend/admin/news/search']             = 'backend/admin/news/search';
$route['backend/admin/news/(:any)']             = 'backend/admin/news/get';
$route['backend/filemanager_check']             = 'backend/backend/filemanager_check';
$route['backend/admin/submit_logout']           = 'backend/admin/admin/submit_logout';
$route['(:any)']                                = 'front/page';

//public
