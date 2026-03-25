<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');

class ProductApiController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function handleRequest($id = null)
    {
        header('Content-Type: application/json');
        
        // --- START JWT CHECK ---
        $headers = getallheaders();
        $authHeader = '';
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'authorization') {
                $authHeader = $value;
                break;
            }
        }
        if (empty($authHeader)) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? '';
        }
        
        $token = preg_replace('/Bearer\s+/i', '', $authHeader);
        
        require_once 'app/utils/JWTHandler.php';
        $userData = \App\Utils\JWTHandler::decodeToken($token);
        
        if (!$userData) {
            http_response_code(401);
            echo json_encode([
                'message' => 'Unauthorized: Please login to access this API',
                'debug_header' => $authHeader ? 'Received but invalid' : 'Not received'
            ]);
            return;
        }
        // --- END JWT CHECK ---

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case 'GET':
                if ($id) {
                    $product = $this->productModel->getProductById($id);
                    echo json_encode($product);
                } else {
                    $products = $this->productModel->getProducts();
                    echo json_encode($products);
                }
                break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"), true);
                if (!$data) $data = $_POST;
                
                $name = $data['name'] ?? '';
                $description = $data['description'] ?? '';
                $price = $data['price'] ?? 0;
                $category_id = $data['category_id'] ?? null;
                
                $result = $this->productModel->addProduct($name, $description, $price, $category_id);
                if ($result === true) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Product created successfully']);
                } else {
                    http_response_code(400);
                    echo json_encode(['errors' => $result]);
                }
                break;
            case 'PUT':
                $data = json_decode(file_get_contents("php://input"), true);
                if ($id && $data) {
                    $name = $data['name'] ?? '';
                    $description = $data['description'] ?? '';
                    $price = $data['price'] ?? 0;
                    $category_id = $data['category_id'] ?? null;
                    
                    $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id);
                    if ($result === true) {
                        echo json_encode(['message' => 'Product updated successfully']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'Update failed']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Invalid data or missing ID']);
                }
                break;
            case 'DELETE':
                if ($id) {
                    $result = $this->productModel->deleteProduct($id);
                    if ($result) {
                        echo json_encode(['message' => 'Product deleted successfully']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'Delete failed']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['message' => 'Missing ID']);
                }
                break;
            default:
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                break;
        }
    }
}
