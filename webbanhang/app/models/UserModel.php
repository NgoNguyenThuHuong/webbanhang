<?php
class UserModel {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $password, $fullname) {
        $query = "INSERT INTO " . $this->table_name . " (username, password, fullname) VALUES (:username, :password, :fullname)";
        $stmt = $this->conn->prepare($query);

        $username = htmlspecialchars(strip_tags($username));
        $fullname = htmlspecialchars(strip_tags($fullname));
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':fullname', $fullname);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function checkLogin($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user && password_verify($password, $user->password)) {
            if (isset($user->is_locked) && $user->is_locked) {
                return "locked";
            }
            return $user;
        }
        return false;
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function lockUser($id) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET is_locked = 1 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function unlockUser($id) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET is_locked = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function isUsernameExists($username) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function updateProfile($id, $fullname, $email, $phone, $address) {
        $query = "UPDATE " . $this->table_name . " 
                  SET fullname = :fullname, email = :email, phone = :phone, address = :address 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function updatePassword($id, $new_password) {
        $query = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getUserByUsernameAndEmail($username, $email) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username AND email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
