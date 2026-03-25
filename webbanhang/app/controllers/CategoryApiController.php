<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryApiController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function handleRequest($id = null)
    {
        header('Content-Type: application/json');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            if ($id) {
                $category = $this->categoryModel->getCategoryById($id);
                echo json_encode($category);
            } else {
                $categories = $this->categoryModel->getCategories();
                echo json_encode($categories);
            }
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Method Not Allowed']);
        }
    }
}
