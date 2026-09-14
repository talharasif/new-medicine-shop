<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/auth.php';

/* Models */
require_once __DIR__ . '/../Model/Category.php';
require_once __DIR__ . '/../Model/Dashboard.php';
require_once __DIR__ . '/../Model/Medicine.php';
require_once __DIR__ . '/../Model/Order.php';
require_once __DIR__ . '/../Model/User.php';

/* Base controller first */
require_once __DIR__ . '/../Control/BaseController.php';

/* Individual controllers */
require_once __DIR__ . '/../Control/DashboardController.php';
require_once __DIR__ . '/../Control/CategoryController.php';
require_once __DIR__ . '/../Control/MedicineController.php';
require_once __DIR__ . '/../Control/CustomerController.php';
require_once __DIR__ . '/../Control/OrderController.php';

$action = $_GET['action'] ?? 'dashboard';

$routes = [
    'dashboard' => [DashboardController::class, 'index'],

    'categories' => [CategoryController::class, 'index'],
    'category_save' => [CategoryController::class, 'save'],
    'category_edit' => [CategoryController::class, 'edit'],
    'category_delete' => [CategoryController::class, 'delete'],

    'medicines' => [MedicineController::class, 'index'],
    'medicine_save' => [MedicineController::class, 'save'],
    'medicine_edit' => [MedicineController::class, 'edit'],
    'medicine_delete' => [MedicineController::class, 'delete'],
    'medicine_details' => [MedicineController::class, 'details'],
    'medicine_search_api' => [MedicineController::class, 'searchApi'],

    'customers' => [CustomerController::class, 'index'],
    'customer_edit' => [CustomerController::class, 'edit'],
    'customer_save' => [CustomerController::class, 'save'],
    'customer_delete' => [CustomerController::class, 'delete'],
    'customer_details' => [CustomerController::class, 'details'],
    'customer_search_api' => [CustomerController::class, 'searchApi'],

    'orders' => [OrderController::class, 'index'],
    'order_status_api' => [OrderController::class, 'updateStatusApi'],
    'order_search_api' => [OrderController::class, 'searchApi'],

    'history' => [OrderController::class, 'history']
];

if (!isset($routes[$action])) {
    http_response_code(404);
    exit('Page not found.');
}

[$class, $method] = $routes[$action];

$controller = new $class();
$controller->$method();
