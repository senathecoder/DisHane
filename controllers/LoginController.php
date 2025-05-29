<?php
require_once '../models/User.php';

class LoginController {
    public function showLoginForm() {
        $title = "Giriş Yap";
        $content = '../views/auth/login.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tc_no = trim($_POST['tc_no']);
            $password = $_POST['password'];

            if(!ctype_digit($tc_no) || strlen($tc_no) !== 11) {
                echo "Geçerli bir TC Kimlik No giriniz.";
                return;
            }
            $userModel = new User();
            $user = $userModel->getByTc($tc_no);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php?page=dashboard");
                exit;
            }
            else {
                echo "TC No veya şifre hatalı.";
            }
        }
    }
}