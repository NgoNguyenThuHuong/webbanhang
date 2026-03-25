<?php
require_once('app/config/database.php');

class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($user_id, $fullname, $phone, $address, $note, $total, $items) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                INSERT INTO orders (user_id, fullname, phone, address, note, total_price, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, 'pending', CURRENT_TIMESTAMP)
            ");
            $stmt->execute([$user_id, $fullname, $phone, $address, $note, $total]);
            $order_id = $this->db->lastInsertId();

            foreach ($items as $product_id => $item) {
                $stmt2 = $this->db->prepare("
                    INSERT INTO order_items (order_id, product_id, product_name, price, quantity)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt2->execute([$order_id, $product_id, $item['name'], $item['price'], $item['quantity']]);
            }

            $this->db->commit();
            return $order_id;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function getOrdersByUser($user_id) {
        $stmt = $this->db->prepare("
            SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getOrderById($order_id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getOrderItems($order_id) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getAllOrders() {
        $stmt = $this->db->query("SELECT o.*, u.username FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateStatus($order_id, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $order_id]);
    }

    // --- CÁC PHƯƠNG THỨC THỐNG KÊ CHO DASHBOARD ---
    
    public function getTotalRevenue() {
        $stmt = $this->db->query("SELECT SUM(total_price) as total FROM orders WHERE status = 'done'");
        return $stmt->fetch(PDO::FETCH_OBJ)->total ?? 0;
    }

    public function getOrderCountByStatus($status = null) {
        if ($status) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = ?");
            $stmt->execute([$status]);
        } else {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
        }
        return $stmt->fetch(PDO::FETCH_OBJ)->count;
    }

    public function getMonthlyRevenue() {
        // SQLite: strftime('%m', created_at)
        $stmt = $this->db->query("
            SELECT strftime('%m', created_at) as month, SUM(total_price) as revenue 
            FROM orders 
            WHERE status = 'done' AND strftime('%Y', created_at) = strftime('%Y', 'now')
            GROUP BY month
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTopSellingProducts($limit = 5) {
        $stmt = $this->db->prepare("
            SELECT product_id, product_name, SUM(quantity) as total_sold 
            FROM order_items 
            GROUP BY product_id 
            ORDER BY total_sold DESC 
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
