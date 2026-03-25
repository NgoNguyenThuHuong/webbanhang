<?php
// Simulate the environment
error_reporting(E_ALL);
ini_set('display_errors', 1);
define('BASE_PATH', __DIR__);
require_once 'vendor/autoload.php';
session_start();
require_once 'app/config/database.php';
require_once 'app/models/UserModel.php';
require_once 'app/controllers/AccountController.php';

// Mock the POST data
$_SERVER['REQUEST_METHOD'] = 'POST';
$input = json_encode(['username' => 'admin', 'password' => '123']);
// We can't easily mock php://input for file_get_contents in a simple script
// but my code has a fallback: if (!$data) $data = $_POST;
$_POST['username'] = 'admin';
$_POST['password'] = '123';

$controller = new AccountController();
echo "Executing api_login()...\n";
$controller->api_login();
echo "\nDone.\n";
