<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Public routes
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('logout', 'Login::logout');

// Test route
$routes->get('test', function() {
    return 'Test route is working!';
});

// Protected routes (require authentication)
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('branchmanager', 'BranchManager::index', ['filter' => 'auth']);
$routes->get('staff', 'Staff::index', ['filter' => 'auth']);
$routes->get('logistics', 'Logistics::index', ['filter' => 'auth']);

// Inventory Staff subpages
$routes->group('staff', ['filter' => 'auth'], static function($routes) {
    $routes->get('stock-levels', 'Staff::stockLevels');
    $routes->get('deliveries', 'Staff::deliveries');
    $routes->get('damages-expired', 'Staff::damagesExpired');
    $routes->get('reports', 'Staff::reports');
});

// Branch Manager subpages
$routes->group('branchmanager', ['filter' => 'auth'], static function($routes) {
    $routes->get('inventory', 'BranchManager::inventory');
    $routes->get('purchase-requests', 'BranchManager::purchaseRequests');
    $routes->get('transfers', 'BranchManager::transfers');
    $routes->get('reports', 'BranchManager::reports');
});