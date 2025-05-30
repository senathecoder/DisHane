<?php
require_once '../models/User.php';

class LoginController {
    public function showLoginForm($error = '') {
        $title = "Giriş Yap";
        $content = '../views/auth/login.php';
        // Hata mesajı, view dosyasına gönderilecek
        require BASE_PATH . '/views/layout.php';
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tc_no = trim($_POST['tc_no']);
            $password = $_POST['password'];

            $error = '';
            // TC kontrolü
            if (!ctype_digit($tc_no) || strlen($tc_no) !== 11) {
                $error = "Geçerli bir TC Kimlik No giriniz.";
            } else {
                $userModel = new User();
                $user = $userModel->getByTc($tc_no);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];
                    header("Location: index.php?page=dashboard");
                    exit;
                } else {
                    $error = "TC Kimlik No veya Şifre hatalı!";
                }
            }
            // Hata varsa, formu hata mesajı ile tekrar göster
            $this->showLoginForm($error);
            return;
        }

        // Eğer GET ile gelindiyse (ilk açılış), boş hata ile formu göster
        $this->showLoginForm();
    }
}
