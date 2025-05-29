<?php
require_once __DIR__ . '/../models/Inventory.php';

class InventoryController {
    private $inventory;

    public function __construct() {
        $this->inventory = new Inventory();
    }

    // Malzeme listesi
    public function index() {
        $items = $this->inventory->getAllItems();
        $topUsedItems = $this->inventory->getTopUsedItems();
        // Grafik için örnek olarak ilk malzemenin geçmişi alınıyor
        $logs = [];

        if (!empty($items)) {
            $logs = $this->inventory->getLogs($items[0]['id']);
        }

        // Grafik için veriyi getiriyoruz
        $chartItems = $this->inventory->getTop10ItemUsageAndStock();

        // Burada kritik stokları al
        $lowStockItems = $this->inventory->getLowStockItems();

        $title="Stok Yönetimi";
        $content = __DIR__ . '/../views/dashboard/sekreter/inventory-manage.php';
        require __DIR__ . '/../views/layout.php';
    }

    // Yeni malzeme ekle
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $quantity = (int) ($_POST['quantity'] ?? 0);

            if ($name !== '' && $quantity > 0) {
                $this->inventory->addItem($name, $quantity);
            }

            header("Location: index.php?page=inventory");
            exit();
        }
    }

    // Stok miktarını güncelle (düşür/artır)
    public function updateStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item_id = $_POST['item_id'] ?? null;
            $change = (int) ($_POST['change_quantity'] ?? 0);
            $reason = $_POST['reason'] ?? null;

            if ($item_id && $change !== 0) {
                $this->inventory->updateQuantity($item_id, $change, $reason);
            }

            header("Location: index.php?page=inventory");
            exit();
        }
    }

    public function increaseStock() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
                header("Location: index.php?page=login");
                exit();
            }

            $item_id = $_POST['item_id'] ?? null;
            $amount = (int) ($_POST['increase_quantity'] ?? 0);
            $reason = $_POST['reason'] ?? "Yeni stok girişi";

            if ($item_id && $amount > 0) {
                $this->inventory->updateQuantity($item_id, $amount, $reason, null, $_SESSION['user_id']);
            }

            header("Location: index.php?page=inventory&increased=1");
            exit();
        }
    }

    public function dailyUsage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }
        $date = $_GET['date'] ?? date('Y-m-d');
        require_once BASE_PATH . '/models/Inventory.php';
        $inventory = new Inventory();
        $logs = $inventory->getDailyUsageByDate($date);

        // View'a veri gönderimi
        include BASE_PATH . '/views/dashboard/sekreter/daily-usage.php';
    }

    public function dailyUsageAjax() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            http_response_code(403);
            exit('Yetkisiz erişim');
        }
        $date = $_GET['date'] ?? date('Y-m-d');
        require_once BASE_PATH . '/models/Inventory.php';
        $inventory = new Inventory();
        $logs = $inventory->getDailyUsageByDate($date);

        include BASE_PATH . '/views/dashboard/sekreter/daily-usage-table.php';
        exit;
    }

    // Doctor material usage page GET
    public function doctorUseMaterialPage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        $materials = $this->inventory->getAllItems();

        $appointment_id = $_GET['appointment_id'] ?? null;
        $usage_logs = [];

        if ($appointment_id) {
            $usage_logs = $this->inventory->getUsageLogsByAppointment($appointment_id);
        }

        $success = isset($_GET['success']);
        $error = $_GET['error'] ?? null;

        $title = "Malzeme Kullanımı";
        $content = BASE_PATH . '/views/dashboard/doktor/doctor-use-material.php';
        require BASE_PATH . '/views/layout.php';
    }

    // Doctor POST form
    public function submitMaterialUsage() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
                header("Location: index.php?page=login");
                exit();
            }
            $item_id = $_POST['item_id'] ?? null;
            $quantity = (int) ($_POST['quantity'] ?? 0);
            $reason = $_POST['reason'] ?? null;
            $appointment_id = $_POST['appointment_id'] ?? null;
            $doctor_id = $_SESSION['user_id'];

            // Error check
            if (!$item_id || $quantity <= 0 || !$appointment_id) {
                $error = urlencode("Malzeme, miktar veya randevu hatalı!");
                header("Location: index.php?page=doctor-use-material&appointment_id=$appointment_id&error=$error");
                exit();
            }

            $ok = $this->inventory->updateQuantity($item_id, -$quantity, $reason, $appointment_id, $doctor_id);

            if ($ok) {
                header("Location: index.php?page=doctor-use-material&appointment_id=$appointment_id&success=1");
            } else {
                $error = urlencode("Kayıt eklenemedi! Lütfen tekrar deneyin.");
                header("Location: index.php?page=doctor-use-material&appointment_id=$appointment_id&error=$error");
            }
            exit();
        }
    }

    
    public function stockChart() {
        //Modelden veriyi çek
        $items = $this->inventory->getTop10ItemUsageAndStock();

        // Dizilere ayır 
        $labels = [];
        $initials = [];
        $currents = [];
        foreach ($items as $item) {
            $labels[] = $item['name'];
            $initials[] = $item['initial_stock'];
            $currents[] = $item['current_stock'];
        }
        //View'a aktar
        include __DIR__ . '/../views/dashboard/sekreter/stock-level-chart.php';
    }

}
