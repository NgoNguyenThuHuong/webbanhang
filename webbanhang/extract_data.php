<?php
// Script này giúp lấy dữ liệu từ SQLite local để bạn copy sang MySQL Aiven
$sqlite_path = 'database.sqlite';

if (!file_exists($sqlite_path)) {
    die("Không tìm thấy file database.sqlite tại thư mục gốc.");
}

try {
    $db = new PDO("sqlite:" . $sqlite_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy dữ liệu sản phẩm
    $stmt = $db->query("SELECT * FROM products");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "-- CÂU LỆNH SQL ĐỂ NHẬP VÀO HEIDISQL (AIVEN) --\n\n";
    
    foreach ($products as $p) {
        $columns = implode(", ", array_keys($p));
        $values = array_map(function($val) {
            if ($val === null) return "NULL";
            return "'" . str_replace("'", "''", $val) . "'";
        }, array_values($p));
        $values_str = implode(", ", $values);
        
        echo "INSERT INTO products ($columns) VALUES ($values_str);\n";
    }

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
