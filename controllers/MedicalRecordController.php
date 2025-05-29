<?php
require_once __DIR__ . '/../models/MedicalRecord.php';
require_once __DIR__ . '/../models/Diagnosis.php';

class MedicalRecordController {
    private $model;
    public function __construct() {
        $this->model = new MedicalRecord();
    }

    // HASTA: Kendi kayıtlarını görür
    public function myRecords() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hasta') {
            header("Location: index.php?page=login");
            exit;
        }
        $records = $this->model->getByPatient($_SESSION['user_id']);
        $title = "Tıbbi Kayıtlarım";
        $content = BASE_PATH . '/views/dashboard/hasta/medical-records.php';
        require BASE_PATH . '/views/layout.php';
    }

    // HASTA: Seçili kaydın tanı geçmişini görür
    public function viewDiagnosisPatient() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hasta') {
            header("Location: index.php?page=login");
            exit;
        }
        $test_id = $_GET['test_id'] ?? null;
        if (!$test_id) {
            echo "Test ID'si bulunamadı!";
            exit;
        }
        $diagnosisModel = new Diagnosis();
        $diagnoses = $diagnosisModel->getByTest($test_id);
        $title = "Tanı Geçmişi";
        $content = BASE_PATH . '/views/dashboard/hasta/view-diagnosis.php';
        require BASE_PATH . '/views/layout.php';
    }

    // SEKRETER: Son 15 kayıt
    public function listRecent() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }
        $records = $this->model->getRecent(15);
        $patients = $this->model->getAllPatients();
        $doctors = $this->model->getAllDoctors();
        $title = "Tüm Tıbbi Kayıtlar";
        $content = BASE_PATH . '/views/dashboard/sekreter/medical-records.php';
        require BASE_PATH . '/views/layout.php';
    }

    // SEKRETER: Hasta adına göre arama
    public function searchByPatient() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }
        $name = $_GET['search'] ?? '';
        $records = $this->model->getByPatientSearch($name);
        $title = "Tıbbi Kayıt Arama Sonuçları";
        $content = BASE_PATH . '/views/dashboard/sekreter/medical-records.php';
        require BASE_PATH . '/views/layout.php';
    }

    // DOKTOR: Hasta adına göre arama
    public function searchByPatientDoctor() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        $name = $_GET['search'] ?? '';
        $records = $this->model->getByPatientSearch($name);
        $title = "Tıbbi Kayıtlar";
        $content = BASE_PATH . '/views/dashboard/doktor/medical-records.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function addForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }
        $model = $this->model;
        $patients = $model->getAllPatients();
        $doctors = $model->getAllDoctors();
        $title = "Tıbbi Kayıt Ekle";
        $content = BASE_PATH . '/views/dashboard/sekreter/add-medical-record.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function addRecord() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['role'] === 'sekreter') {
            $patient_id = $_POST['patient_id'];
            $doctor_id = $_POST['doctor_id'];
            $test_type = $_POST['test_type'];
            $result = $_POST['result'];
            $record_date = $_POST['record_date'];
            $success = $this->model->add($patient_id, $doctor_id, $test_type, $result, $record_date);
            $_SESSION['success'] = $success ? "Kayıt başarıyla eklendi!" : "Kayıt eklenirken bir hata oluştu!";
            header("Location: index.php?page=medicalRecordsSekreter"); // Listeye geri dön
            exit;
        }
    }
}
