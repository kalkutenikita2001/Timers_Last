<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
*/

$route['default_controller'] = 'Auth/login';
$route['translate_uri_dashes'] = FALSE;
$route['404_override'] = '';

/*
| -------------------------------------------------------------------------
| Dashboard routes
| -------------------------------------------------------------------------
| Ensure dashboard URL maps to the correct controller. Your controller
| class is DashboardController, so route 'dashboard' to that.
|
| Also expose the AJAX endpoint center_stats and students_list at both:
|  - dashboard/center_stats
|  - superadmin/dashboard/center_stats
|  - dashboard/students_list
|  - superadmin/dashboard/students_list
| so the view JS can call either path depending on your previous code.
*/

$route['dashboard'] = 'DashboardController/dashboard';
$route['superadmin/dashboard'] = 'DashboardController/dashboard';

// AJAX endpoints for stats and student lists per center
$route['dashboard/center_stats'] = 'DashboardController/center_stats';
$route['superadmin/dashboard/center_stats'] = 'DashboardController/center_stats';

$route['dashboard/students_list'] = 'DashboardController/students_list';
$route['superadmin/dashboard/students_list'] = 'DashboardController/students_list';

/*
| -------------------------------------------------------------------------
| Include/Widget routes (unchanged)
| -------------------------------------------------------------------------
*/

$route['Sidebar'] = 'Superadmin/Include/Sidebar';
$route['Navbar'] = 'Superadmin/Include/Navbar';
$route['CenterManagement2'] = 'Superadmin/Include/CenterManagement2';
$route['New_admission'] = 'Superadmin/Include/New_admission';

/*
| -------------------------------------------------------------------------
| Admission / Receipt / Students routes
| -------------------------------------------------------------------------
*/
$route['receipt'] = 'admission/receipt';
$route['newreceipt'] = 'admission/newreceipt';
$route['Re_admission'] = 'admission/Re_admission';
$route['Students'] = 'admission/Students';
$route['Renew_admission'] = 'admission/Renew_admission';
$route['View_Renew_Students'] = 'admission/View_Renew_Students';
$route['View_Re_Admission'] = 'admission/View_Re_Admission'; // kept original mapping
$route['EvenetList'] = 'admission/EvenetList';

// NOTE: you previously had View_Re_Admission mapped twice. The second mapping to 'admission/Report' was removed to avoid conflict.
// If you intended to route a different URL to admission/Report, add it with a different key here, eg:
// $route['admission/report'] = 'admission/Report';

/*
| -------------------------------------------------------------------------
| Center Management (SuperAdmin)
| -------------------------------------------------------------------------
*/
$route['center'] = 'center/index';
$route['center/save'] = 'center/save';
$route['center/get_all'] = 'center/get_all';
$route['center/get/(:num)'] = 'center/get/$1';
$route['center/filter'] = 'center/filter';

/*
| -------------------------------------------------------------------------
| Event And Notice participant views
| -------------------------------------------------------------------------
*/
$route['superadmin/EventAndNotice/view_participants/(:num)'] = 'EventAndNotice/view_participants/$1';
$route['admin/EventAndNotice/view_participants/(:num)'] = 'EventAndNotice/view_participants/$1';

/*
| -------------------------------------------------------------------------
| Misc / Admin / Superadmin routes (unchanged)
| -------------------------------------------------------------------------
*/
$route['Superadmin/view_center_details'] = 'Superadmin/view_center_details';
$route['admin/get_center_stats'] = 'admin/get_center_stats';

$route['admin/Leave'] = 'Leave/index';        // Admin URL
$route['superadmin/Leave'] = 'Leave/index';   // Superadmin URL

$route['superadmin/finance'] = 'finance';
///Report
$route['overall_report'] = 'Superadmin/overall_report';

$route['admin'] = 'admin/dashboard';
