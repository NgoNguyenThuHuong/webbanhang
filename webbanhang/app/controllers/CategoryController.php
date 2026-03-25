<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController {
    private $categoryModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index() {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        include 'app/views/category/add.php';
    }

    public function save() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->categoryModel->addCategory($_POST['name'], $_POST['description']);
            header('Location: /Category');
        }
    }

    public function edit($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        $category = $this->categoryModel->getCategoryById($id);
        include 'app/views/category/edit.php';
    }

    public function update() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->categoryModel->updateCategory($_POST['id'], $_POST['name'], $_POST['description']);
            header('Location: /Category');
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        $this->categoryModel->deleteCategory($id);
        header('Location: /Category');
    }
}