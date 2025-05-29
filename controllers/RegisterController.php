<?php
require_once BASE_PATH . '/models/User.php'; 

class RegisterController {

    //Kayıt ekranını göster
    public function showRegisterForm() {
        $title = "Kayıt Ol";
        $content = BASE_PATH . '/views/auth/register.php';
        require BASE_PATH . '/views/layout.php';
    }
    // Hasta kaydını işleyen fonksiyon
    public function handleRegister() {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $full_name = trim($_POST['full_name']);
            $tc_no = trim($_POST['tc_no']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'] ?? '';

            // Sadece hasta rolü kabul edilir
            if($role !== 'hasta') {
                die("Sadece hasta olarak kayıt yapılabilir.");
            }

            $userModel = new User();

            if ($userModel->tcExists($tc_no)) {
                $_SESSION['error'] = "Bu TC numarasıyla zaten bir hasta kayıtlı.";
                header("Location: index.php?page=register");
                exit;
            }

            $userModel->create($full_name, $tc_no, $email, $phone, $password, $role);
            header("Location: index.php?page=login");
            exit;
        }
    }
    // Adminin personel kaydı yapabildiği fonksiyon
    public function handleStaffRegister() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Giriş yapılmamış veya admin değilse reddet
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=login");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name']);
            $tc_no = trim($_POST['tc_no']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $role = $_POST['role'];
            
            // Sadece doktor ve sekreter seçilebilir
            if (!in_array($role, ['doktor', 'sekreter'])) {
                die("Geçersiz rol.");
            }

            $userModel = new User();

            if ($userModel->tcExists($tc_no)) {
                $_SESSION['error'] = "Bu TC numarasına sahip bir kullanıcı zaten kayıtlı.";
                header("Location: index.php?page=addStaff");
                exit;
            }

            $userModel->create($full_name, $tc_no, $email, $phone, $password, $role);
            $_SESSION['success'] = "Personel başarıyla eklendi.";
            header("Location: index.php?page=dashboard");
            exit;
        }
    }
}
?>