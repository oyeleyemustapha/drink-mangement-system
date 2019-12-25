<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'drinks';
$route['404_override'] = 'error404';

$route['translate_uri_dashes'] = FALSE;

$route['login']='drinks/login';
$route['logout']='drinks/logout';

$route['supervisor']="supervisor/index";
$route['cashier']="cashier/index";

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


//STOCK
$route['stock']="administrator/stock";
$route['drinks-to-stock']="administrator/fetchDrinktoStock";
$route['add-drinks-to-stock']="administrator/add_drinks_stock";
$route['fetch-drinks-stock']="administrator/fetchDrinksStock";

//SALES
$route['sales']="administrator/sales";
$route['fetch-allocated-stock']="administrator/fetch_allocated_stock";
$route['post-record']="administrator/post_sales";
$route['update-sales']="administrator/update_sales";

//REPORTS
$route['reports']="administrator/reports";
$route['daily-sales-reports']="administrator/sales_reports_day";
$route['monthly-sales-reports']="administrator/sales_reports_month";
$route['annual-sales-reports']="administrator/sales_reports_annual";
$route['staff-sales']="administrator/sales_reports_day_staff";
$route['sales-sheet']="administrator/sales_sheet";


//PROFILE
$route['profile']="administrator/profile";
$route['update-profile']="administrator/update_profile";