<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::beranda');
$routes->get('/you-are-offline', 'Home::offline');

// Driver
$routes->get('/driver/login', 'Driver\Auth::login', ['filter' => 'auth_not_login_driver']);
$routes->get('/driver/sign-up', 'Driver\Auth::sign_up', ['filter' => 'auth_not_login_driver']);
$routes->get('/driver/lupa-password', 'Driver\Auth::lupa_password', ['filter' => 'auth_not_login_driver']);
$routes->get('/driver/reset-password/(:any)', 'Driver\Auth::reset_password/$1', ['filter' => 'auth_not_login_driver']);
$routes->get('/driver', 'Driver\Dashboard::index', ['filter' => 'auth_driver']);

$routes->get('/driver/pengantaran', 'Driver\Pengantaran::index', ['filter' => 'auth_driver']);
$routes->get('/driver/pengantaran/create', 'Driver\Pengantaran::create', ['filter' => 'auth_driver']);
$routes->get('/driver/pengantaran/detail/(:num)', 'Driver\Pengantaran::detail/$1', ['filter' => 'auth_driver']);

$routes->get('/driver/orderan', 'Driver\Orderan::index', ['filter' => 'auth_driver']);

$routes->get('/driver/history', 'Driver\Orderan::history', ['filter' => 'auth_driver']);
$routes->get('/driver/history/detail/(:any)', 'Driver\Orderan::detail_history/$1', ['filter' => 'auth_driver']);

$routes->get('/driver/akun', 'Driver\Akun::index', ['filter' => 'auth_driver']);

$routes->get('/driver/logout', 'Logout::driver', ['filter' => 'auth_driver']);


// Admin
$routes->get('/admin/login', 'Admin\Auth::login', ['filter' => 'auth_not_login_admin']);
$routes->get('/admin', 'Admin\Dashboard::index', ['filter' => 'auth_admin']);

$routes->get('/admin/orderan', 'Admin\Orderan::index', ['filter' => 'auth_admin']);
$routes->get('/admin/orderan/detail/(:any)', 'Admin\Orderan::detail/$1', ['filter' => 'auth_admin']);

$routes->get('/admin/driver', 'Admin\Driver::index', ['filter' => 'auth_admin']);
$routes->get('/admin/customer', 'Admin\Customer::index', ['filter' => 'auth_admin']);
$routes->get('/admin/bandara', 'Admin\Bandara::index', ['filter' => 'auth_admin']);

$routes->get('/admin/logout', 'Logout::admin', ['filter' => 'auth_admin']);


// Customer
$routes->get('/customer/login', 'Customer\Auth::login', ['filter' => 'auth_not_login_customer']);
$routes->get('/customer/sign-up', 'Customer\Auth::sign_up', ['filter' => 'auth_not_login_customer']);
$routes->get('/customer/lupa-password', 'Customer\Auth::lupa_password', ['filter' => 'auth_not_login_customer']);
$routes->get('/customer/reset-password/(:any)', 'Customer\Auth::reset_password/$1', ['filter' => 'auth_not_login_customer']);
$routes->get('/customer', 'Customer\Dashboard::index', ['filter' => 'auth_customer']);

$routes->get('/customer/order', 'Customer\Order::index', ['filter' => 'auth_customer']);
$routes->post('/customer/order/submit-order', 'Customer\Order::submit_order', ['filter' => 'auth_customer']);
$routes->get('/customer/order/edit/(:num)', 'Customer\Order::edit/$1', ['filter' => 'auth_customer']);

$routes->get('/customer/history', 'Customer\Order::history', ['filter' => 'auth_customer']);
$routes->get('/customer/history/detail/(:any)', 'Customer\Order::detail_history/$1', ['filter' => 'auth_customer']);

$routes->get('/customer/akun', 'Customer\Akun::index', ['filter' => 'auth_customer']);
$routes->get('/customer/logout', 'Logout::customer', ['filter' => 'auth_customer']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
