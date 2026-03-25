<?php
require_once 'app/config/database.php';
require_once 'app/models/OrderModel.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/CouponModel.php';

class AdminController {
    private $db;
    private $orderModel;
    private $productModel;
    private $userModel;

    public function __construct() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Account/login');
            exit;
        }
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
        $this->productModel = new ProductModel($this->db);
        $this->userModel = new UserModel($this->db);
    }

    public function index() {
        // Thống kê tổng quan
        $totalRevenue = $this->orderModel->getTotalRevenue();
        $orderCount = $this->orderModel->getOrderCountByStatus();
        $pendingOrders = $this->orderModel->getOrderCountByStatus('pending');
        $userCount = count($this->userModel->getAllUsers());
        
        // Dữ liệu biểu đồ
        $monthlyRevenue = $this->orderModel->getMonthlyRevenue();
        $topProducts = $this->orderModel->getTopSellingProducts();

        include 'app/views/shares/header.php';
        include 'app/views/admin/dashboard.php';
        include 'app/views/shares/footer.php';
    }

    public function users() {
        $users = $this->userModel->getAllUsers();
        include 'app/views/shares/header.php';
        include 'app/views/admin/users.php';
        include 'app/views/shares/footer.php';
    }

    public function lockUser($id) {
        $this->userModel->lockUser($id);
        header('Location: /Admin/users');
    }

    public function unlockUser($id) {
        $this->userModel->unlockUser($id);
        header('Location: /Admin/users');
    }

    public function coupons() {
        $couponModel = new CouponModel($this->db);
        $coupons = $couponModel->getAllCoupons();
        include 'app/views/shares/header.php';
        include 'app/views/admin/coupons.php';
        include 'app/views/shares/footer.php';
    }

    public function addCoupon() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code'];
            $discount = $_POST['discount'];
            $expires_at = $_POST['expires_at'];
            
            $couponModel = new CouponModel($this->db);
            $couponModel->addCoupon($code, $discount, $expires_at);
        }
        header('Location: /Admin/coupons');
    }
}
