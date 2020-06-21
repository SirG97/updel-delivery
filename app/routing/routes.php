<?php

require_once __DIR__.'/../../vendor/altorouter/altorouter/AltoRouter.php';


$router = new Altorouter();

$router->map('GET', '/', '\App\Controllers\IndexController@show', 'home');

$router->map('GET', '/register', '\App\Controllers\AuthController@showregister', 'show_register');
$router->map('POST', '/register', '\App\Controllers\AuthController@register', 'register_user');

// Authentication and login
$router->map('GET', '/login', '\App\Controllers\AuthController@show', 'login');
$router->map('POST', '/login', '\App\Controllers\AuthController@login', 'auth');
$router->map('GET', '/logout', '\App\Controllers\AuthController@logout', 'logout');

// Dashboard
$router->map('GET', '/dashboard', '\App\Controllers\DashboardController@show', 'dashboard');
$router->map('POST', '/dashboard', '\App\Controllers\DashboardController@store', 'dt');
$router->map('GET', '/dashboard/chart', '\App\Controllers\DashboardController@chart_info', 'chart');

// Staff routes
$router->map('GET', '/profile', '\App\Controllers\UserController@view_profile', 'profile');
$router->map('GET', '/managers', '\App\Controllers\UserController@get_managers', 'managers');
$router->map('GET', '/staff/[:staff_id]', '\App\Controllers\UserController@get_staff', 'staff');
$router->map('GET', '/support_staff', '\App\Controllers\UserController@get_support_staff', 'support_staff');
$router->map('GET', '/riders', '\App\Controllers\UserController@get_riders', 'riders');
$router->map('GET', '/staff', '\App\Controllers\UserController@new_staff_form', 'new_staff_form');
$router->map('POST', '/staff/add', '\App\Controllers\UserController@store_staff', 'store_staff');
$router->map('POST', '/staff/[:user_id]/edit', '\App\Controllers\UserController@edit_staff', 'edit_staff');
$router->map('POST', '/staff/[:user_id]/delete', '\App\Controllers\UserController@delete_staff', 'delete_staff');

//District and route routes
$router->map('GET', '/district_routes', '\App\Controllers\DistrictController@get_district', 'district');
$router->map('POST', '/district/create', '\App\Controllers\DistrictController@store_district', 'store_district');
$router->map('POST', '/route/create', '\App\Controllers\DistrictController@store_route', 'store_route');
$router->map('POST', '/route/[:route_id]/edit', '\App\Controllers\DistrictController@edit_route', 'edit_route');
$router->map('POST', '/route/[:route_id]/delete', '\App\Controllers\DistrictController@delete_route', 'delete_route');

//Order Routes
$router->map('GET', '/orders', '\App\Controllers\OrderController@show_orders', 'orders');
$router->map('GET', '/create_order', '\App\Controllers\OrderController@get_order_form', 'order_form');
$router->map('POST', '/save_order', '\App\Controllers\OrderController@save_order', 'save_order');
$router->map('GET', '/order/[:order_no]', '\App\Controllers\OrderController@edit_order', 'get_order');
$router->map('POST', '/order/[:order_no]/edit', '\App\Controllers\OrderController@edit_order', 'edit_order');
$router->map('POST', '/order/[:order_no]/delete', '\App\Controllers\OrderController@delete_order', 'delete_order');



$router->map('GET', '/customer/[:customer_id]', '\App\Controllers\OrderController@getcustomer', 'get_customer');


//$router->map('GET', '/customer/[:contribution_id]', '\App\Controllers\CustomerController@getcontribution', 'get_contribution');
$router->map('POST', '/customer/[:customer_id]/edit', '\App\Controllers\CustomerController@editcustomer', 'edit_customer');
$router->map('POST', '/customer/[:customer_id]/delete', '\App\Controllers\CustomerController@deletecustomer', 'delete_customer');
$router->map('GET', '/customer/[:terms]/search', '\App\Controllers\CustomerController@searchcustomer', 'search_customer');

//Fastrak Pin Route
$router->map('GET', '/pins', '\App\Controllers\PinController@index', 'pins');
$router->map('GET', '/newpins', '\App\Controllers\PinController@generate_form', 'generate_pins_form');
$router->map('POST', '/pins/new', '\App\Controllers\PinController@generate', 'generate_pins');
$router->map('GET', '/pins/live', '\App\Controllers\PinController@live', 'get_live_pins');
$router->map('GET', '/pins/used', '\App\Controllers\PinController@used', 'get_used_pins');
$router->map('GET', '/pins/pending', '\App\Controllers\PinController@pending', 'get_pending_pins');

//$router->addMatchTypes(array('cId' => '[a-zA-Z]{2}[0-9](?:_[0-9]++)?'));

//Contributions
$router->map('GET', '/contributions', '\App\Controllers\ContributionController@get_all', 'contributions');
$router->map('GET', '/contribute', '\App\Controllers\ContributionController@contribute_form', 'contribute_form');
$router->map('POST', '/contribute', '\App\Controllers\ContributionController@contribute', 'contribute');
$router->map('GET', '/contributions/[:terms]/search', '\App\Controllers\ContributionController@search_contribution', 'search_contribution');
$router->map('POST', '/ussd', '\App\Controllers\ContributionController@ussd', 'ussd');

// Settings
$router->map('GET', '/settings', '\App\Controllers\SettingsController@showSettings', 'show_settings');
$router->map('POST', '/settings', '\App\Controllers\SettngsController@settings', 'settings');

