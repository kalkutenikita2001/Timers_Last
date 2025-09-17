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
$route['dashboard'] = 'Superadmin/dashboard';
$route['Sidebar'] = 'Superadmin/Include/Sidebar';
$route['Navbar'] = 'Superadmin/Include/Navbar';
$route['CenterManagement2'] = 'Superadmin/Include/CenterManagement2';
$route['New_admission'] = 'Superadmin/Include/New_admission';
$route['receipt'] = 'admission/receipt';
$route['Re_admission'] = 'admission/Re_admission';
$route['Students'] = 'admission/Students';
$route['Renew_admission'] = 'admission/Renew_admission';
$route['View_Renew_Students'] = 'admission/View_Renew_Students';
$route['View_Re_Admission'] = 'admission/View_Re_Admission';
$route['EvenetList'] = 'admission/EvenetList';
$route['View_Re_Admission'] = 'admission/Report';

// base module
$route['adminlogin'] = 'base/adminlogin';
$route['superadminlogin'] = 'base/superadminlogin';

// SuperAdmin
// Center Management
$route['center'] = 'center/index';
$route['center/save'] = 'center/save';
$route['center/get_all'] = 'center/get_all';
$route['center/get/(:num)'] = 'center/get/$1';
$route['center/filter'] = 'center/filter';


$route['superadmin/EventAndNotice/view_participants/(:num)'] = 'EventAndNotice/view_participants/$1';

$route['admin/EventAndNotice/view_participants/(:num)'] = 'EventAndNotice/view_participants/$1';

$route['superadmin/view_center_details'] = 'superadmin/view_center_details';

$route['admin/get_center_stats'] = 'admin/get_center_stats';

$route['admin/Leave'] = 'Leave/index';        // Admin URL
$route['superadmin/Leave'] = 'Leave/index';   // Superadmin URL
