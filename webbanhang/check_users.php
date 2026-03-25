<?php
require_once 'app/config/database.php';
$db = (new Database())->getConnection();
$stmt = $db->query("SELECT id, username, password, fullname, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users, JSON_PRETTY_PRINT);
