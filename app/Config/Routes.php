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

// Inventory routes (protected)
$routes->group('inventory', ['filter' => 'auth'], static function($routes) {
    // View routes
    $routes->get('dashboard', 'Inventory::dashboard');
    $routes->get('stock-levels', 'Inventory::stockLevels');
    $routes->get('reports', 'Inventory::reports');
    $routes->get('deliveries', 'Inventory::deliveries');
    $routes->get('damages-expired', 'Inventory::damagesExpired');
    
    // API routes
    $routes->get('api/test', 'Inventory::testApi');
    $routes->get('api/stock-data', 'Inventory::getStockData');
    $routes->post('api/save-stock', 'Inventory::saveStock');
    $routes->post('api/adjust-stock', 'Inventory::adjustStock');
    $routes->delete('api/delete-stock/(:num)', 'Inventory::deleteStock/$1');
    $routes->get('api/recent-reports', 'Inventory::getRecentReports');
    $routes->post('api/generate-report', 'Inventory::generateReport');
    $routes->post('api/report-damage', 'Inventory::reportDamage');
    $routes->post('api/receive-delivery', 'Inventory::receiveDelivery');
    $routes->get('api/delivery-items/(:num)', 'Inventory::getDeliveryItems/$1');
    $routes->get('api/delivery-items', 'Inventory::getAllDeliveries');
    $routes->get('api/damage-items', 'Inventory::getDamageItems');
});

// Logistics API
$routes->group('logistics', ['filter' => 'auth'], static function($routes) {
    $routes->get('api/deliveries', 'Logistics::listDeliveries');
    $routes->post('api/deliveries/schedule', 'Logistics::scheduleDelivery');
    $routes->post('api/deliveries/(:num)/status', 'Logistics::updateDeliveryStatus/$1');
});

// Branch Manager subpages
$routes->group('branchmanager', ['filter' => 'auth'], static function($routes) {
    $routes->get('inventory', 'BranchManager::inventory');
    $routes->get('purchase-requests', 'BranchManager::purchaseRequests');
    $routes->get('transfers', 'BranchManager::transfers');
    $routes->get('reports', 'BranchManager::reports');

    // API routes for branch manager
    $routes->get('api/inventory-data', 'BranchManager::apiInventoryData');
    $routes->get('api/critical-alerts', 'BranchManager::apiCriticalAlerts');
    $routes->post('api/adjust-stock', 'BranchManager::apiAdjustStock');

    // Purchase order actions
    $routes->post('api/purchase-orders', 'BranchManager::createPurchaseOrder');
    $routes->post('api/purchase-orders/(:num)/approve', 'BranchManager::approvePurchaseOrder/$1');
    $routes->post('api/purchase-orders/(:num)/reject', 'BranchManager::rejectPurchaseOrder/$1');

    // Purchase requests UI data endpoints
    $routes->get('api/purchase-requests', 'BranchManager::apiPurchaseRequests');
    $routes->get('api/suppliers', 'BranchManager::apiSuppliers');
    $routes->get('api/products', 'BranchManager::apiProducts');
    $routes->post('api/create-purchase-request', 'BranchManager::apiCreatePurchaseRequest');
    $routes->delete('api/delete-purchase-request/(:num)', 'BranchManager::apiDeletePurchaseRequest/$1');
});