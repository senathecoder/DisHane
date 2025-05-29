<?php
// controller fonksiyonunun başına koy:
class AdminController
{
    // Doktorların bir ayda kaç hasta baktığını gösteren fonksiyon
    public function clinicStats()
    {
        require_once BASE_PATH . '/models/Appointment.php';
        require_once BASE_PATH . '/models/User.php';
        require_once BASE_PATH . '/models/Inventory.php';
        require_once BASE_PATH . '/config/Database.php'; 
        
        $inventoryModel = new Inventory();
        $criticalStocks = $inventoryModel->getCriticalStocks(5);
        $mostUsedItems = $inventoryModel->getMostUsedItems(5);
            
        $criticalStockNames = array_column($criticalStocks, 'name');
        $criticalStockValues = array_column($criticalStocks, 'quantity');

        $usedItemNames = array_column($mostUsedItems, 'name');
        $usedItemValues = array_column($mostUsedItems, 'used_amount');

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }

        $db = (new Database())->getConnection(); // Veritabanı bağlantısı
        
        // 1. Toplam doktor sayısı
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'doktor'");
        $stmt->execute();
        $totalDoctors = $stmt->fetchColumn();

        // 2. Toplam hasta sayısı
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'hasta'");
        $stmt->execute();
        $totalPatients = $stmt->fetchColumn();

        // 3. Toplam sekreter sayısı
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'sekreter'");
        $stmt->execute();
        $totalSecretaries = $stmt->fetchColumn();

        // 4. Bu ay eklenen hasta sayısı
        $thisMonth = date('Y-m');
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE role = 'hasta' AND created_at LIKE '$thisMonth%'");
        $stmt->execute();
        $newPatientsThisMonth = $stmt->fetchColumn();

        // 5. Toplam randevu sayısı
        $stmt = $db->prepare("SELECT COUNT(*) FROM appointments");
        $stmt->execute();
        $totalAppointments = $stmt->fetchColumn();

        // Var olan doktor istatistikleri ve maaş hesabı
        $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
        $appointmentModel = new Appointment();
        $clinicStats = $appointmentModel->getMonthlyDoctorStats($year, $month);

        // Maaş hesaplama (ÖRNEK: hasta başına 500₺)
        $salaryPerPatient = 500;
        $doctorSalaries = [];
        foreach ($clinicStats as $stat) {
            $doctorSalaries[] = [
                'doctor_name' => $stat['doctor_name'],
                'salary' => $stat['patient_count'] * $salaryPerPatient
            ];
        }

        //Çizgi grafiği
        $userModel = new User();
        $yearForChart = isset($_GET['year']) ? intval($_GET['year']) : date('Y');
        $monthlyPatientGrowth = $userModel->getMonthlyPatientGrowth($yearForChart);

        $statusData = $appointmentModel->getAppointmentStatusStats($year, $month);

        $title = "Doktor İstatistikleri";
        $content = BASE_PATH . '/views/dashboard/admin/clinic-stats.php';
        require BASE_PATH . '/views/layout.php';
    }
}
