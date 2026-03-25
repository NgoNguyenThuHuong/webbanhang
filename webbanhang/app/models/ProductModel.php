<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function searchProduct($keyword)
    {
        $query = "SELECT * FROM product WHERE name LIKE :keyword";
        $stmt = $this->conn->prepare($query);

        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getProducts($searchTerm = null, $category_id = null)
    {
        // 1. Khởi tạo câu lệnh SQL cơ bản
        $query = "SELECT p.*, c.name as category_name 
              FROM " . $this->table_name . " p 
              LEFT JOIN category c ON p.category_id = c.id 
              WHERE 1=1";

        // 2. Chỉ lọc theo Tên sản phẩm (Loại bỏ lọc theo mô tả)
        if ($searchTerm) {
            $query .= " AND p.name LIKE :searchTerm";
        }

        // 3. Lọc theo Danh mục (Nếu có)
        if ($category_id) {
            $query .= " AND p.category_id = :category_id";
        }

        $stmt = $this->conn->prepare($query);

        // 4. Bind các tham số an toàn
        if ($searchTerm) {
            $term = "%$searchTerm%";
            $stmt->bindParam(':searchTerm', $term);
        }
        if ($category_id) {
            $stmt->bindParam(':category_id', $category_id);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function getProductById($id)
    {
        // Cập nhật SQL để lấy thêm tên danh mục (category_name)
        $query = "SELECT p.*, c.name as category_name 
              FROM " . $this->table_name . " p 
              LEFT JOIN category c ON p.category_id = c.id 
              WHERE p.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function addProduct($name, $description, $price, $category_id)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (count($errors) > 0) {
            return $errors;
        }
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, stock_quantity) VALUES (:name, :description, :price, :category_id, :stock)";
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 100;
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':stock', $stock);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateProduct(
        $id,
        $name,
        $description,
        $price,
        $category_id,
        $stock = null
    ) {
        $query = "UPDATE " . $this->table_name . " SET name=:name, description=:description, price=:price, category_id=:category_id";
        if ($stock !== null) {
            $query .= ", stock_quantity=:stock";
        }
        $query .= " WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = htmlspecialchars(strip_tags($price));
        $category_id = htmlspecialchars(strip_tags($category_id));
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        if ($stock !== null) {
            $stmt->bindParam(':stock', $stock);
        }
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}