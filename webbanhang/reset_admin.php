<?php
require_once 'app/config/database.php';
$db = (new Database())->getConnection();
$new_password = password_hash('123', PASSWORD_BCRYPT);
$stmt = $db->prepare("UPDATE users SET password = :password WHERE username = 'admin'");
if ($stmt->execute(['password' => $new_password])) {
    echo "Admin password reset to '123' successfully.\n";
} else {
    echo "Failed to reset admin password.\n";
}
