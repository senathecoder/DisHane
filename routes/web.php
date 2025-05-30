<?php

function route($page) {
    switch($page) {
        case 'login':
            require_once '../controllers/LoginController.php';
            $controller = new LoginController();
            $controller->showLoginForm();
            break;
        
        case 'handleLogin':
            require_once '../controllers/LoginController.php';
            $controller = new LoginController();
            $controller->handleLogin();
            break;

        case 'register':
            require_once '../controllers/RegisterController.php';
            $controller = new RegisterController();
            $controller->showRegisterForm();
            break;
        
        case 'handleRegister':
            require_once '../controllers/RegisterController.php';
            $controller = new RegisterController();
            $controller->handleRegister();
            break;
        
        case 'forgotPassword':
            $content = BASE_PATH . '/views/auth/forgot-password.php';
            require BASE_PATH . '/views/layout.php';
            break;

        case 'handleForgotPassword':
            require_once BASE_PATH . '/controllers/AuthController.php';
            $controller = new AuthController();
            $controller->handleForgotPassword();
            break;

        case 'resetPassword':
            $content = BASE_PATH . '/views/auth/reset-password.php';
            require BASE_PATH . '/views/layout.php';
            break;

        case 'handleResetPassword':
            require_once BASE_PATH . '/controllers/AuthController.php';
            $controller = new AuthController();
            $controller->handleResetPassword();
            break;

        case 'handleAddAppointment':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleAddAppointment();
            break;

        case 'addStaff':
            $title = "Personel Ekle";
            $content = BASE_PATH . '/views/dashboard/add-staff.php';
            require BASE_PATH . '/views/layout.php';
            break;

        case 'addAppointment':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->showAddAppointmentForm();
            break;

        case 'addSlot':
            $controller = new AppointmentController();
            $controller->handleAddSlot();
            break;

        case 'availableSlots':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $title = "Uygun Randevu Saatleri";
            require BASE_PATH . '/views/layout.php';
            break;

        case 'bookSlot':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleBookSlot();
            break;
        
        case 'appointmentsList':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleAppointmentsList();
            break;

        case 'daily-usage':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->dailyUsage();
            break;
        
        case 'daily-usage-ajax':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->dailyUsageAjax();
            break;

        case 'doctorAppointments':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->doctorAppointments();
            break;

        case 'doctorAppointmentsJson':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->getDoctorAppointmentsJson();
            break;

        case 'doctorDayAppointments':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->getDoctorDayAppointments();
            break;

        case 'doctorWorkingHours':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleDoctorWorkingHours();
            break;
        
        case 'deleteDoctorWorkingHour':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->deleteDoctorWorkingHour();
            break;

        case 'handleStaffRegister':
            require_once '../controllers/RegisterController.php';
            $controller = new RegisterController();
            $controller->handleStaffRegister();
            break;

        case 'handleUpdateStatus':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleUpdateStatus();
            break;

        case 'cancelAppointment':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->cancelAppointment();
            break;
        
        case 'cancelAppointmentAjax':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->cancelAppointmentAjax();
            break;
        
        case 'available-hours': 
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->loadAvailableHoursView(); // ilk açılışta sadece doktorları göster
            break;
        
        case 'ajax-get-available-hours':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->getAvailableHoursAjax();
            break;

        case 'bookAppointment':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleBookAppointment();
            break;

        case 'myAppointments':
            require_once BASE_PATH . '/controllers/AppointmentController.php';
            $controller = new AppointmentController();
            $controller->handleMyAppointments();
            break;

        case 'inventory':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->index();
            break;

        case 'inventory-add':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->add();
            break;

        case 'inventory-update':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->updateStock();
            break;

        case 'submit-material-usage':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->submitMaterialUsage();
            break;

        case 'daily-usage':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->dailyUsage();
            break;
        
        case 'low-stock-warning':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->lowStockWarning();
            break;

        case 'stock-level-chart':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->stockChart();
            break;
        //Stok arttır formu gönderildiğinde çalışacak
        case 'inventory-increase':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            $controller->increaseStock();
            break;

        case 'doctor-use-material':
            require_once BASE_PATH . '/controllers/InventoryController.php';
            $controller = new InventoryController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->submitMaterialUsage();
            } else {
                $controller->doctorUseMaterialPage();
            }
            break;

        case 'medicalRecords':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->myRecords(); //hasta paneli için
            break;

        case 'medicalRecordsSekreter':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->listRecent();
            break;

        // Eğer isimle arama eklemek istersen:
        case 'searchMedicalRecords':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->searchByPatient();
            break;
        
        case 'searchMedicalRecordsDoctor':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->searchByPatientDoctor();
            break;
        
        case 'addMedicalRecordForm':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->addForm();
            break;

        case 'addMedicalRecord':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->addRecord();
            break;
        
        case 'addDiagnosis':
            require_once BASE_PATH . '/controllers/DiagnosisController.php';
            $controller = new DiagnosisController();
            $controller->add(); //Tanı ekleme formunu açar veya ekler
            break;

        case 'viewDiagnosis':
            require_once BASE_PATH . '/controllers/DiagnosisController.php';
            $controller = new DiagnosisController();
            $controller->viewByTest(); //Tanı geçmişini ilgili kayıtları gösterir
            break;

        case 'editDiagnosis':
            require_once BASE_PATH . '/controllers/DiagnosisController.php';
            $controller = new DiagnosisController();
            $controller->edit();
            break;

        case 'deleteDiagnosis':
            require_once BASE_PATH . '/controllers/DiagnosisController.php';
            $controller = new DiagnosisController();
            $controller->delete();
            break;

        case 'medicalRecordsPatient':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->myRecords();
            break;

        case 'viewDiagnosisPatient':
            require_once BASE_PATH . '/controllers/MedicalRecordController.php';
            $controller = new MedicalRecordController();
            $controller->viewDiagnosisPatient(); // DOĞRU OLAN BU!
            break;

        case 'clinicStats':
            require_once BASE_PATH . '/controllers/AdminController.php';
            $controller = new AdminController();
            $controller->clinicStats();
            break;

        case 'personelList':
            require_once BASE_PATH . '/controllers/PersonelController.php';
            $controller = new PersonelController();
            $controller->personelList();
            break;

        case 'personelAdd':
            require_once BASE_PATH . '/controllers/PersonelController.php';
            $controller = new PersonelController();
            $controller->personelAdd();
            break;
        
        case 'personelEdit':
            require_once BASE_PATH . '/controllers/PersonelController.php';
            $controller = new PersonelController();
            $controller->personelEdit();
            break;

        case 'personelUpdate':
            require_once BASE_PATH . '/controllers/PersonelController.php';
            $controller = new PersonelController();
            $controller->personelUpdate();
            break;

        case 'personelDelete':
            require_once BASE_PATH . '/controllers/PersonelController.php';
            $controller = new PersonelController();
            $controller->personelDelete();
            break;

        case 'dashboard':
            require_once '../controllers/HomeController.php';
            $controller = new HomeController();
            $controller->redirectByRole();
            break;
        
        case 'logout':
            require_once '../public/logout.php';
            break;

        default:
            echo "404 - Sayfa bulunamadı.";
            break;
    }
}