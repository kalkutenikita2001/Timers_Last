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
$route['Center'] = 'Superadmin/Center';
$route['Staff'] = 'Superadmin/Staff';
$route['Batch'] = 'Superadmin/Batch';
$route['EventAndNotice'] = 'Superadmin/EventAndNotice';
$route['Admission'] = 'Superadmin/Admission';
$route['Students'] = 'Superadmin/Students';
$route['Leave'] = 'Superadmin/Leave';
$route['Superadmin_profile'] = 'Superadmin/Superadmin_profile';
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
$route['Locker_fees'] = 'admin/Locker_fees';
$route['Venues'] = 'admin/Venues';


// base module
$route['adminlogin'] = 'base/adminlogin';
$route['superadminlogin'] = 'base/superadminlogin';



//SuperAdmin Backend Side
$route['Center'] = 'Center/index';
$route['Staff'] = 'Staff/index';
$route['Batch'] = 'Batch/index';
$route['Event_notice'] = 'Event_notice/index';
$route['Revenue'] = 'Revenue/index';
$route['Expense/(:any)'] = 'Expense/$1';
$route['Expense'] = 'Expense/index';
// Route for the Leave controller
$route['Leave'] = 'Leave/index';
$route['Leave/get_leaves'] = 'Leave/get_leaves';
$route['Leave/add_leave'] = 'Leave/add_leave';
$route['Leave/update_leave'] = 'Leave/update_leave';
$route['Leave/delete_leave'] = 'Leave/delete_leave';
$route['Leave/get_batches'] = 'Leave/get_batches';


//admin backend Side 
$route['Income_expenses'] = 'admincontroller/Income_expenses/index';
$route['Income_expenses/get_income_expenses'] = 'admincontroller/Income_expenses/get_income_expenses';
$route['Income_expenses/get_income_expense/(:num)'] = 'admincontroller/Income_expenses/get_income_expense/$1';
$route['Income_expenses/add_income_expense'] = 'admincontroller/Income_expenses/add_income_expense';
$route['Income_expenses/update_income_expense'] = 'admincontroller/Income_expenses/update_income_expense';
$route['Income_expenses/approve_income_expense/(:num)'] = 'admincontroller/Income_expenses/approve_income_expense/$1';
$route['Income_expenses/reject_income_expense/(:num)'] = 'admincontroller/Income_expenses/reject_income_expense/$1';
// // Locker Fees Routes
// $route['admin/Locker_fees'] = 'admincontroller/Locker_fees/index';
// $route['admin/Locker_fees/add'] = 'admincontroller/Locker_fees/add';
// $route['admin/Locker_fees/update'] = 'admincontroller/Locker_fees/update';
// $route['admin/Locker_fees/get_by_id/(:num)'] = 'admincontroller/Locker_fees/get_by_id/$1';
// $route['admin/Locker_fees/delete/(:num)'] = 'admincontroller/Locker_fees/delete/$1';
// $route['admin/Locker_fees/filter'] = 'admincontroller/Locker_fees/filter';

// Add this to application/config/routes.php
$route['admin/add-on-facilities'] = 'admincontroller/Add_on_facilities/index';



$route['admin/venues'] = 'admincontroller/Venues/index';
$route['admin/venues/add'] = 'admincontroller/Venues/add';
$route['admin/venues/update'] = 'admincontroller/Venues/update';
$route['admin/venues/delete/(:num)'] = 'admincontroller/Venues/delete/$1';
$route['admin/venues/get_by_id/(:num)'] = 'admincontroller/Venues/get_by_id/$1';
$route['admin/venues/get_batches_by_venue/(:num)'] = 'admincontroller/Venues/get_batches_by_venue/$1';
$route['admin/venues/add_batch'] = 'admincontroller/Venues/add_batch';
$route['admin/venues/update_batch'] = 'admincontroller/Venues/update_batch';
$route['admin/venues/delete_batch/(:num)'] = 'admincontroller/Venues/delete_batch/$1';
$route['admin/venues/get_batch_by_id/(:num)'] = 'admincontroller/Venues/get_batch_by_id/$1';