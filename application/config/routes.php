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

//STAFF
$route['staff']="administrator/staff";
$route['staff-list']="administrator/fetch_staff_list";
$route['add-staff']="administrator/add_staff";
$route['delete-staff']="administrator/delete_staff";
$route['fetch-staff']="administrator/fetch_staff_info";
$route['update-staff']="administrator/update_staff";

//PRODUCT
$route['products']="administrator/products";
$route['add-product']="administrator/add_product";
$route['fetch-products']="administrator/fetch_product_list";
$route['fetch-product']="administrator/fetch_product_info";
$route['update-product']="administrator/update_product_info";