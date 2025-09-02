<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/branchmanager', 'BranchManager::index');

$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/', 'Staff::index');
$routes->get('/staff', 'Staff::index');

$routes->get('/', 'Logistics::index');
$routes->get('/logistics', 'Logistics::index');