<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        $keyword = $_GET['keyword'] ?? '';
        $category_id = $_GET['category_id'] ?? null;
        $categoryName = null;

        if ($category_id) {
            $categoryModel = new CategoryModel($this->db);
            $category = $categoryModel->getCategoryById($category_id);
            if ($category) {
                $categoryName = $category->name;
            }
        }

        // Use the improved getProducts method which handles both search and category filtering
        $products = $this->productModel->getProducts($keyword, $category_id);

        require_once 'app/views/shares/header.php';
        require_once 'app/views/product/list.php';
        require_once 'app/views/shares/footer.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        require_once 'app/views/shares/header.php';

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }

        require_once 'app/views/shares/footer.php';
    }

    public function add()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/add.php';
    }

    public function save()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            $errors = [];

            $result = $this->productModel->addProduct(
                $name,
                $description,
                $price,
                $category_id
            );

            if (is_array($result)) {
                $errors = array_merge($errors, $result);
            }

            if (!empty($errors)) {
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
                exit;
            }
        }
    }

    public function edit($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $errors = [];

            if (empty($errors)) {
                $edit = $this->productModel->updateProduct(
                    $id,
                    $name,
                    $description,
                    $price,
                    $category_id
                );

                if ($edit) {
                    header('Location: /webbanhang/Product');
                    exit;
                } else {
                    $errors[] = "Đã xảy ra lỗi khi lưu sản phẩm.";
                }
            }

            if (!empty($errors)) {
                $product = $this->productModel->getProductById($id);
                // Keep the input values so user doesn't have to retype them
                $product->name = $name;
                $product->description = $description;
                $product->price = $price;
                $product->category_id = $category_id;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/edit.php';
            }
        }
    }

    public function delete($id)
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }

    public function cart()
    {
        $cart = $_SESSION['cart'] ?? [];
        include 'app/views/product/cart.php';
    }

    public function updateCart($id)
    {
        $quantity = $_POST['quantity'] ?? 1;

        if (isset($_SESSION['cart'][$id])) {

            if ($quantity <= 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id]['quantity'] = $quantity;
            }
        }

        header('Location: /webbanhang/Product/cart');
    }

    public function removeFromCart($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }

        header('Location: /webbanhang/Product/cart');
    }

    public function api_frontend()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /webbanhang/Account/login');
            exit;
        }
        require_once 'app/views/shares/header.php';
        require_once 'app/views/product/api_frontend.php';
        require_once 'app/views/shares/footer.php';
    }
}