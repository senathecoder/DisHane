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

            require_once BASE_PATH . '/models/User.php';
            $userModel = new User();
            $user = $userModel->getByTc($tc_no);

            if (!$user) {
                $_SESSION['error'] = "Girilen TC ile kayıtlı kullanıcı bulunamadı.";
                header("Location: index.php?page=forgotPassword");
                exit;
            }

            // Şifreyi değiştireceği yeni sayfaya yönlendir (TC parametresiyle!)
            header("Location: index.php?page=resetPassword&tc=" . urlencode($tc_no));
            exit;
        }
    }

    public function handleResetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tc_no = $_POST['tc'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $_SESSION['error'] = "Şifreler eşleşmiyor.";
                header("Location: index.php?page=resetPassword&tc=" . urlencode($tc_no));
                exit;
            }
            if (strlen($password) < 6) {
                $_SESSION['error'] = "Şifre en az 6 karakter olmalı.";
                header("Location: index.php?page=resetPassword&tc=" . urlencode($tc_no));
                exit;
            }

            require_once BASE_PATH . '/models/User.php';
            $userModel = new User();
            $user = $userModel->getByTc($tc_no);

            if (!$user) {
                $_SESSION['error'] = "Kullanıcı bulunamadı!";
                header("Location: index.php?page=resetPassword&tc=" . urlencode($tc_no));
                exit;
            }

            $userModel->updatePasswordByTC($tc_no, $password);

            $_SESSION['success'] = "Şifreniz başarıyla değiştirildi. Giriş yapabilirsiniz.";
            header("Location: index.php?page=login");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
    }
}
