<?php
// Hiển thị lỗi để dễ debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';
session_start();

// Load database và model
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';

// Lấy URL
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = trim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định controller
if (!empty($url[0]) && strtolower($url[0]) === 'webbanhang') {
    array_shift($url);
}

// --- START BÀI 5: RESTful API Routing ---
$isApi = false;
if (!empty($url[0]) && strtolower($url[0]) === 'api') {
    $isApi = true;
    array_shift($url); // Remove 'api'
}

$controllerName = (!empty($url[0])) 
    ? ucfirst($url[0]) . ($isApi ? 'ApiController' : 'Controller') 
    : ($isApi ? 'DefaultApiController' : 'DefaultController');

// Xác định action và arguments
if ($isApi) {
    // API Controller doesn't need an action from URL, handled by HTTP Method
    $action = 'handleRequest';
    $args = array_slice($url, 1);
} else {
    // Normal MVC Routing
    $action = (!empty($url[1])) ? $url[1] : 'index';
    $args = array_slice($url, 2);
}
// --- END API Routing ---

// Đường dẫn controller
$controllerPath = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra controller tồn tại
if (!file_exists($controllerPath)) {
    if ($isApi) {
        header('Content-Type: application/json');
        http_response_code(404);
        die(json_encode(['error' => 'API Controller not found']));
    } else {
        die('Controller not found: ' . $controllerName);
    }
}

// Load controller
require_once $controllerPath;
$controller = new $controllerName();

// Kiểm tra action tồn tại
if (!method_exists($controller, $action)) {
    if ($isApi) {
        header('Content-Type: application/json');
        http_response_code(404);
        die(json_encode(['error' => 'Action not found in API Controller']));
    } else {
        die('Action not found: ' . $action);
    }
}

// Gọi action
call_user_func_array([$controller, $action], $args);