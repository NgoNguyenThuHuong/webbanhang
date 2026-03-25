<?php
class CouponModel {
    private $conn;
    private $table_name = "coupons";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllCoupons() {
        $stmt = $this->conn->query("SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function addCoupon($code, $discount, $expires_at) {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table_name . " (code, discount_percent, expires_at) VALUES (?, ?, ?)");
        return $stmt->execute([$code, $discount, $expires_at]);
    }

    public function deleteCoupon($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCouponByCode($code) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE code = ? AND status = 'active' AND (expires_at IS NULL OR expires_at >= date('now'))");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
