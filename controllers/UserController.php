<?php
session_start();

require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $userModel;

    public function __construct() {
        $pdo = Database::getConnection();
        $this->userModel = new User($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $tc_no = $_POST['tc_no'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = 'hasta'; // Sabit olarak atadım

            $result = $this->userModel->register($full_name, $tc_no, $email, $phone, $password, $role);

            if ($result === true) {
                $_SESSION['success'] = "Kayıt başarılı!";
                header("Location: /login");
                exit;
            } else {
                $_SESSION['error'] = $result;
                header("Location: /register");
                exit;
            }
        }

        // GET isteğinde kayıt formunu göster
        require __DIR__ . '/../views/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->login($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                header("Location: /home");
                exit;
            } else {
                $_SESSION['error'] = "E-posta veya şifre yanlış!";
                header("Location: /login");
                exit;
            }
        }

        // GET isteğinde login formunu göster
        require __DIR__ . '/../views/login.php';
    }

    public function home() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit;
        }

        require __DIR__ . '/../views/home.php';
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }
}
