<?php
if (session_status() === PHP_SESSION_NONE) session_start();

class HomeController {
    public function redirectByRole() {
        $role = $_SESSION['role'] ?? null;

        switch ($role) {
            case 'admin':
                $title = "Admin Paneli";
                $content = BASE_PATH . '/views/dashboard/admin/admin.php';
                break;
            case 'doktor':
                $title = "Doktor Paneli";
                $content = BASE_PATH . '/views/dashboard/doktor/doktor.php';
                break;
            case 'sekreter':
                $title = "Sekreter Paneli";
                $content = BASE_PATH . '/views/dashboard/sekreter/sekreter.php';
                break;
            case 'hasta':
                $title = "Hasta Paneli";
                $content = BASE_PATH . '/views/dashboard/hasta/hasta.php';
                break;
            default:
                header("Location: index.php?page=login");
                exit;
        }

        require BASE_PATH . '/views/layout.php';
    }
}
