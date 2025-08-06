<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['translate_uri_dashes'] = FALSE;
$route['404_override'] = '';

//SuperAdmin
$route['dashboard'] = 'superadmin/dashboard';
$route['Sidebar'] = 'superadmin/Include/Sidebar';
$route['Navbar'] = 'superadmin/Include/Navbar';
$route['Center'] = 'superadmin/Center';
$route['Staff'] = 'superadmin/Staff';
$route['Batch'] = 'superadmin/Batch';
$route['EventAndNotice'] = 'superadmin/EventAndNotice';
$route['Admission'] = 'superadmin/Admission';
$route['Students'] = 'superadmin/Students';
$route['Leave'] = 'superadmin/Leave';
// $route['Expenses'] = 'superadmin/Expenses';

//Admin
$route['Sidebar'] = 'admin/Include/Sidebar';
$route['Navbar'] = 'admin/Include/Navbar';
$route['Batch'] = 'admin/Batch';
$route['EventAndNotice'] = 'admin/EventAndNotice';
$route['Admission'] = 'admin/Admission';
$route['IncomeAndExpenses'] = 'admin/IncomeAndExpenses';
$route['Attendance'] = 'admin/Attendance';
$route['Leave'] = 'admin/Leave';
$route['Profile'] = 'admin/Profile';
$route['Dashboard'] = 'admin/Dashboard';
$route['Finance'] = 'admin/Finance';
$route['venue'] = 'admin/venue';


// base module
$route['login'] = 'base/login';
$route['adminlogin'] = 'base/adminlogin';
$route['superadminlogin'] = 'base/superadminlogin';

//SuperAdmin Backend Side
$route['center'] = 'center/index';
$route['staff'] = 'staff/index';
$route['batch'] = 'batch/index';
$route['event_notice'] = 'event_notice/index';
$route['revenue'] = 'revenue/index';
$route['expense/(:any)'] = 'expense/$1';
$route['expense'] = 'expense/index';
