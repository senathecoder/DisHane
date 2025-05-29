<?php
require_once '../models/User.php';

class AuthController {
    public function loginForm() {
        include '../views/auth/login.php';
    }

    public function login() {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = (new User())->login($email, $password);
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php?page=dashboard");
        } else {
            echo "Hatalı giriş!";
        }
    }
    public function handleForgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tc_no = $_POST['tc_no'] ?? '';
            $email = $_POST['email'] ?? '';

            require_once BASE_PATH . '/models/User.php';
            $userModel = new User();
            $user = $userModel->getByTc($tc_no);

            if (!$user || strtolower($user['email']) !== strtolower($email)) {
                $_SESSION['error'] = "Girilen bilgilerle eşleşen kullanıcı bulunamadı.";
                header("Location: index.php?page=forgotPassword");
                exit;
            }

            // Şifreyi değiştireceği yeni sayfaya yönlendir
            $_SESSION['reset_user_id'] = $user['id'];
            header("Location: index.php?page=resetPassword");
            exit;
        }
    }
    public function handleResetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['reset_user_id'])) {
                $_SESSION['error'] = "Geçersiz işlem!";
                header("Location: index.php?page=login");
                exit;
            }

            $user_id = $_SESSION['reset_user_id'];
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $_SESSION['error'] = "Şifreler eşleşmiyor.";
                header("Location: index.php?page=resetPassword");
                exit;
            }
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Şifre en az 6 karakter olmalı.";
                header("Location: index.php?page=resetPassword");
                exit;
            }

            require_once BASE_PATH . '/models/User.php';
            $userModel = new User();
            $userModel->updatePassword($user_id, $password);

            unset($_SESSION['reset_user_id']);
            $_SESSION['success'] = "Şifre başarıyla değiştirildi. Giriş yapabilirsiniz.";
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }
}
