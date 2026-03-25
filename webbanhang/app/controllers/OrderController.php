<?php
require_once('app/config/database.php');
require_once('app/models/OrderModel.php');

class OrderController {
    private $orderModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->orderModel = new OrderModel($this->db);
    }

    /**
     * Trang thanh toán đơn hàng
     */

    // Form thanh toán
    public function checkout() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để tiến hành đặt hàng.";
            header('Location: /Account/login');
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header('Location: /webbanhang/Product/cart');
            exit;
        }

        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        require_once 'app/views/shares/header.php';
        include 'app/views/order/checkout.php';
        require_once 'app/views/shares/footer.php';
    }

    // Xử lý đặt hàng
    public function placeOrder() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Order/checkout');
            exit;
        }

        if (empty($_SESSION['cart'])) {
            header('Location: /webbanhang/Product/cart');
            exit;
        }

        $fullname    = trim($_POST['fullname'] ?? '');
        $phone       = trim($_POST['phone'] ?? '');
        $address     = trim($_POST['address'] ?? '');
        $note        = trim($_POST['note'] ?? '');
        $user_id     = $_SESSION['user_id'] ?? null;

        $errors = [];
        if (empty($fullname)) $errors[] = "Vui lòng nhập họ tên.";
        if (empty($phone))    $errors[] = "Vui lòng nhập số điện thoại.";
        if (empty($address))  $errors[] = "Vui lòng nhập địa chỉ giao hàng.";

        if (!empty($errors)) {
            $cart = $_SESSION['cart'];
            $total = 0;
            foreach ($cart as $item) $total += $item['price'] * $item['quantity'];
            require_once 'app/views/shares/header.php';
            include 'app/views/order/checkout.php';
            require_once 'app/views/shares/footer.php';
            return;
        }

        $cart = $_SESSION['cart'];
        $total = 0;
        foreach ($cart as $item) $total += $item['price'] * $item['quantity'];

        // Xử lý mã giảm giá (nếu có)
        $discount_percent = 0;
        if (!empty($_POST['coupon_code'])) {
            if (!class_exists('CouponModel')) require_once 'app/models/CouponModel.php';
            $couponModel = new CouponModel($this->db);
            $coupon = $couponModel->getCouponByCode($_POST['coupon_code']);
            if ($coupon) {
                $discount_percent = $coupon->discount_percent;
                $total = $total * (1 - ($discount_percent / 100));
            }
        }

        $order_id = $this->orderModel->createOrder($user_id, $fullname, $phone, $address, $note, $total, $cart);

        if ($order_id) {
            unset($_SESSION['cart']); // Xóa giỏ hàng sau khi đặt
            header('Location: /webbanhang/Order/success/' . $order_id);
            exit;
        } else {
            $errors[] = "Đã có lỗi xảy ra. Vui lòng thử lại.";
            require_once 'app/views/shares/header.php';
            include 'app/views/order/checkout.php';
            require_once 'app/views/shares/footer.php';
        }
    }

    // Trang đặt hàng thành công
    public function success($order_id) {
        $order = $this->orderModel->getOrderById($order_id);
        $items = $this->orderModel->getOrderItems($order_id);

        require_once 'app/views/shares/header.php';
        include 'app/views/order/success.php';
        require_once 'app/views/shares/footer.php';
    }

    // Khách hàng: Xem lịch sử đơn hàng của mình
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Account/login');
            exit;
        }
        $user_id = $_SESSION['user_id'];
        $orders = $this->orderModel->getOrdersByUser($user_id);
        
        require_once 'app/views/shares/header.php';
        include 'app/views/order/index.php';
        require_once 'app/views/shares/footer.php';
    }

    // Admin: xem tất cả đơn hàng
    public function manage() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Product');
            exit;
        }
        $orders = $this->orderModel->getAllOrders();
        
        // Thống kê nhanh cho manage page
        $stats = [
            'total_revenue' => $this->orderModel->getTotalRevenue(),
            'pending_count' => $this->orderModel->getOrderCountByStatus('pending'),
            'done_count'    => $this->orderModel->getOrderCountByStatus('done'),
            'all_count'     => count($orders)
        ];

        // Lấy sản phẩm của từng đơn hàng để hiển thị nhanh
        foreach ($orders as &$order) {
            $order->items = $this->orderModel->getOrderItems($order->id);
        }

        require_once 'app/views/shares/header.php';
        include 'app/views/order/manage.php';
        require_once 'app/views/shares/footer.php';
    }

    // Admin: Cập nhật trạng thái đơn hàng
    public function updateStatus($order_id) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Product');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'] ?? 'pending';
            if ($this->orderModel->updateStatus($order_id, $status)) {
                $_SESSION['success'] = "Cập nhật trạng thái thành công!";
            } else {
                $_SESSION['error'] = "Không thể cập nhật trạng thái.";
            }
        }
        header('Location: /webbanhang/Order/manage');
        exit;
    }

    // AJAX: Kiểm tra mã giảm giá
    public function checkCoupon() {
        header('Content-Type: application/json');
        $code = $_POST['code'] ?? '';
        
        if (empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập mã.']);
            exit;
        }

        require_once 'app/models/CouponModel.php';
        $couponModel = new CouponModel($this->db);
        $coupon = $couponModel->getCouponByCode($code);

        if ($coupon) {
            echo json_encode([
                'success' => true,
                'discount' => $coupon->discount_percent,
                'message' => 'Áp dụng thành công! Giảm ' . $coupon->discount_percent . '%'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Mã giảm giá không tồn tại hoặc đã hết hạn.']);
        }
        exit;
    }
}
