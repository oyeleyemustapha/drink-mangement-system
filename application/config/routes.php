<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'drinks';
$route['404_override'] = 'error404';

$route['translate_uri_dashes'] = FALSE;

$route['login']='drinks/login';
$route['logout']='drinks/logout';



//STOTE SETTINGS
$route['settings']="administrator/settings";
$route['update-store-setting']="administrator/update_store_settings";
$route['export-records']="administrator/export_records";


//STAFF LOGS
$route['staff-logs']="administrator/logs";
$route['fetchLogs']="administrator/fetch_logs";
$route['purge-staff-logs']="administrator/clear_staff_logs";