<?php
require_once __DIR__ . '/../models/Diagnosis.php';

class DiagnosisController {
    private $model;

    public function __construct() {
        $this->model = new Diagnosis();
    }

    // Tanı ekle (GET ve POST birlikte)
    public function add() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $test_id = $_POST['test_id'];
            $diagnosis = $_POST['diagnosis'];
            $doctor_id = $_SESSION['user_id'];
            $diagnosis_date = date('Y-m-d');

            $this->model->add($test_id, $doctor_id, $diagnosis, $diagnosis_date);
            // Tanı eklendikten sonra tanı geçmişine yönlendir
            header("Location: index.php?page=viewDiagnosis&test_id=" . $test_id);
            exit();
        } else {
            // GET ile geldiyse formu göster
            $test_id = $_GET['test_id'] ?? null;
            $title = "Tanı Ekle";
            $content = BASE_PATH . '/views/dashboard/doktor/add-diagnosis.php';
            require BASE_PATH . '/views/layout.php';
        }
    }

    // Tanı geçmişini göster
    public function viewByTest() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        $test_id = $_GET['test_id'] ?? null;
        if (!$test_id) {
            echo "Test ID'si bulunamadı!";
            exit;
        }
        $diagnoses = $this->model->getByTest($test_id);
        $title = "Tanı Geçmişi";
        $content = BASE_PATH . '/views/dashboard/doktor/view-diagnosis.php';
        require BASE_PATH . '/views/layout.php';
    }

    // Tanı düzenleme
    public function edit() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $diagnosis_id = $_POST['diagnosis_id']; // <-- Mutlaka burada!
            $test_id = $_POST['test_id'];
            $diagnosis = $_POST['diagnosis'];
            $diagnosis_date = date('Y-m-d');
            $this->model->update($diagnosis_id, $diagnosis, $diagnosis_date);
            header("Location: index.php?page=viewDiagnosis&test_id=" . $test_id);
            exit();
        } else {
            $diagnosis_id = $_GET['diagnosis_id'] ?? null;
            $diagnosis = $this->model->getById($diagnosis_id);
            $title = "Tanı Düzenle";
            $content = BASE_PATH . '/views/dashboard/doktor/edit-diagnosis.php';
            require BASE_PATH . '/views/layout.php';
        }
    }


    // Tanı silme
    public function delete() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        $diagnosis_id = $_GET['diagnosis_id'] ?? null;
        $test_id = $_GET['test_id'] ?? null;
        if (!$diagnosis_id) {
            $_SESSION['error'] = "Tanı ID'si eksik!";
            header("Location: index.php?page=medicalRecordsDoctor");
            exit;
        }

        $this->model->delete($diagnosis_id);

        $_SESSION['success'] = "Tanı başarıyla silindi.";
        header("Location: index.php?page=viewDiagnosis&test_id=$test_id");
        exit;
    }

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

    public function viewDiagnosis() {
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

}
