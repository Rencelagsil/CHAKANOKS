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
