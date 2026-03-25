<?php
require_once('app/config/database.php');
require_once('app/models/UserModel.php');
require_once('app/utils/JWTHandler.php');
use \App\Utils\JWTHandler;

class AccountController {
    private $userModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->userModel = new UserModel($this->db);
    }

    public function register() {
        require_once 'app/views/shares/header.php';
        include 'app/views/account/register.php';
        require_once 'app/views/shares/footer.php';
    }

    public function saveRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $errors = [];
            if (empty($username) || empty($password) || empty($fullname)) {
                $errors[] = "Vui lòng điền đầy đủ thông tin.";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Mật khẩu xác nhận không khớp.";
            }
            if ($this->userModel->isUsernameExists($username)) {
                $errors[] = "Tên đăng nhập đã tồn tại.";
            }

            if (empty($errors)) {
                if ($this->userModel->register($username, $password, $fullname)) {
                    header('Location: /Account/login');
                    exit;
                } else {
                    $errors[] = "Đã xảy ra lỗi khi đăng ký.";
                }
            }

            require_once 'app/views/shares/header.php';
            include 'app/views/account/register.php';
            require_once 'app/views/shares/footer.php';
        }
    }

    public function login() {
        require_once 'app/views/shares/header.php';
        include 'app/views/account/login.php';
        require_once 'app/views/shares/footer.php';
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->checkLogin($username, $password);
            if ($user === "locked") {
                $errors = ["Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên."];
                require_once 'app/views/shares/header.php';
                include 'app/views/account/login.php';
                require_once 'app/views/shares/footer.php';
                return;
            }

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['fullname'] = $user->fullname;
                $_SESSION['role'] = $user->role;

                header('Location: /Product');
                exit;
            } else {
                $errors = ["Tên đăng nhập hoặc mật khẩu không đúng."];
                require_once 'app/views/shares/header.php';
                include 'app/views/account/login.php';
                require_once 'app/views/shares/footer.php';
            }
        }
    }

    public function api_login() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!$data) $data = $_POST;
            
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';

            $user = $this->userModel->checkLogin($username, $password);
            if ($user && $user !== "locked") {
                $token = JWTHandler::generateToken([
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role
                ]);

                // Set session for traditional web compatibility
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                $_SESSION['fullname'] = $user->fullname;
                $_SESSION['role'] = $user->role;

                echo json_encode(['token' => $token, 'user' => $user]);
            } else {
                http_response_code(401);
                echo json_encode(['message' => 'Invalid username or password']);
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /Product');
        exit;
    }

    public function profile() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Account/login');
            exit;
        }
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        
        require_once 'app/views/shares/header.php';
        include 'app/views/account/profile.php';
        require_once 'app/views/shares/footer.php';
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            if ($this->userModel->updateProfile($_SESSION['user_id'], $fullname, $email, $phone, $address)) {
                $_SESSION['fullname'] = $fullname;
                $_SESSION['success'] = "Cập nhật hồ sơ thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật hồ sơ.";
            }
        }
        header('Location: /Account/profile');
        exit;
    }

    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Account/login');
            exit;
        }
        require_once 'app/views/shares/header.php';
        include 'app/views/account/change_password.php';
        require_once 'app/views/shares/footer.php';
    }

    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($current_password) || empty($new_password)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin.";
                header('Location: /Account/changePassword');
                exit;
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "Mật khẩu mới không khớp.";
                header('Location: /Account/changePassword');
                exit;
            }

            $user = $this->userModel->getUserById($_SESSION['user_id']);
            if (password_verify($current_password, $user->password)) {
                if ($this->userModel->updatePassword($_SESSION['user_id'], $new_password)) {
                    $_SESSION['success'] = "Đổi mật khẩu thành công!";
                } else {
                    $_SESSION['error'] = "Đã xảy ra lỗi khi cập nhật.";
                }
            } else {
                $_SESSION['error'] = "Mật khẩu hiện tại không chính xác.";
            }
        }
        header('Location: /Account/changePassword');
        exit;
    }

    public function forgotPassword() {
        require_once 'app/views/shares/header.php';
        include 'app/views/account/forgot_password.php';
        require_once 'app/views/shares/footer.php';
    }

    public function verifyForgot() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';

            $user = $this->userModel->getUserByUsernameAndEmail($username, $email);
            if ($user) {
                $_SESSION['reset_user_id'] = $user->id;
                require_once 'app/views/shares/header.php';
                include 'app/views/account/reset_password.php';
                require_once 'app/views/shares/footer.php';
            } else {
                $_SESSION['error'] = "Thông tin không khớp. Vui lòng kiểm tra lại.";
                header('Location: /Account/forgotPassword');
                exit;
            }
        }
    }

    public function resetPasswordConfirm() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['reset_user_id'])) {
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($new_password) || $new_password !== $confirm_password) {
                $_SESSION['error'] = "Mật khẩu không khớp hoặc để trống.";
                header('Location: /Account/forgotPassword'); // Restart flow
                exit;
            }

            if ($this->userModel->updatePassword($_SESSION['reset_user_id'], $new_password)) {
                unset($_SESSION['reset_user_id']);
                $_SESSION['success'] = "Đặt lại mật khẩu thành công! Hãy đăng nhập lại.";
                header('Location: /Account/login');
                exit;
            }
        }
    }
}
