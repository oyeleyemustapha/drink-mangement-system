<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'drinks';
$route['404_override'] = 'error404';

$route['translate_uri_dashes'] = FALSE;

$route['login']='drinks/login';
$route['logout']='drinks/logout';


$route['settings']="administrator/settings";

