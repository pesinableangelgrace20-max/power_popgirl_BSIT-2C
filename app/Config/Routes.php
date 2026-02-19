<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Auth::index');
$routes->get('/login', 'Auth::index');
$routes->post('/auth', 'Auth::auth');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/logout', 'Auth::logout');

// User Accounts routes
$routes->get('/users', 'Users::index');
$routes->post('users/save', 'Users::save');
$routes->get('users/edit/(:segment)', 'Users::edit/$1');
$routes->post('users/update', 'Users::update');
$routes->delete('users/delete/(:num)', 'Users::delete/$1');
$routes->post('users/fetchRecords', 'Users::fetchRecords');

// Profiling routes
$routes->get('/profiling', 'Profiling::index');
$routes->post('profiling/save', 'Profiling::save');
$routes->get('profiling/edit/(:segment)', 'Profiling::edit/$1');
$routes->post('profiling/update', 'Profiling::update');
$routes->delete('profiling/delete/(:num)', 'Profiling::delete/$1');
$routes->post('profiling/fetchRecords', 'Profiling::fetchRecords');

// Logs routes for admin
$routes->get('/log', 'Logs::log');