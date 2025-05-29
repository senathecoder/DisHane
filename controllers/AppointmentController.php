<?php
require_once BASE_PATH . '/models/Appointment.php';

class AppointmentController {

    public function handleAddAppointment() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Appointment();

            $patient_id = $_POST['patient_id'] ?? null;
            $doctor_id = $_POST['doctor_id'] ?? null;
            $appointment_date = $_POST['appointment_date'] ?? null;
            $appointment_time = $_POST['appointment_time'] ?? null;

            // Geçmiş tarih kontrolü
            if (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
                $_SESSION['error'] = "Geçmiş bir tarih için randevu oluşturulamaz.";
                header("Location: index.php?page=available-hours");
                exit;
            }

            $notes = $_POST['notes'] ?? null;
            $secretary_id = $_SESSION['user_id'];

            if (!$patient_id || !$doctor_id || !$appointment_date || !$appointment_time) {
                $_SESSION['error'] = "Lütfen tüm zorunlu alanları doldurun.";
                header("Location: index.php?page=addAppointment");
                exit;
            }

            $success = $model->create($patient_id, $doctor_id, $secretary_id, $appointment_date, $appointment_time, $notes);
            $_SESSION[$success ? 'success' : 'error'] = $success
                ? "Randevu başarıyla eklendi."
                : "Randevu eklenirken bir hata oluştu.";

            header("Location: index.php?page=addAppointment");
            exit;
        }
    }

    public function myAppointments() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hasta') {
            header("Location: index.php?page=login");
            exit;
        }
        $model = new Appointment();
        $appointments = $model->getByPatientId($_SESSION['user_id']); // veya kendi fonksiyonun
        $title = "Randevularım";
        $content = BASE_PATH . '/views/dashboard/hasta/my-appointments.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function doctorAppointments() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        // Randevuları/ilgili verileri modelden çek
        // Takvim sadece AJAX ile veri çekiyorsa basit bırakabilirsin
        $title = "Randevu Takvimi";
        $content = BASE_PATH . '/views/dashboard/doktor/doctor-appointments.php'; // Klasörüne göre ayarla
        require BASE_PATH . '/views/layout.php';
    }

    public function doctorCalendar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            header("Location: index.php?page=login");
            exit;
        }
        // Ekstra veri eklemek istersen buraya koyabilirsin
        $title = "Randevu Takvimi";
        $content = BASE_PATH . '/views/dashboard/doktor/doktor.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function handleBookAppointment() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hasta') {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new Appointment();

            $patient_id = $_SESSION['user_id'];
            $doctor_id = $_POST['doctor_id'] ?? null;
            $date = $_POST['date'] ?? null;
            $time = $_POST['time'] ?? null;
            $notes = null;
            $created_by = $patient_id;

            if (!$doctor_id || !$date || !$time) {
                $_SESSION['error'] = "Lütfen doktor, tarih ve saat seçin.";
                header("Location: index.php?page=available-hours");
                exit();
            }

            $existing = $model->getExistingAppointment($patient_id, $date, $doctor_id);
            if ($existing) {
                $_SESSION['error'] = "Bu tarihte zaten bir randevunuz bulunmaktadır.";
                header("Location: index.php?page=available-hours");
                exit();
            }

            $success = $model->create($patient_id, $doctor_id, $created_by, $date, $time, $notes);
            $_SESSION[$success ? 'success' : 'error'] = $success
                ? "Randevunuz başarıyla oluşturuldu."
                : "Bu saat dolu ya da bir hata oluştu.";

            header("Location: index.php?page=myAppointments");
            exit();
        }
    }

    public function loadAvailableHoursView() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $model = new Appointment();
        $_SESSION['doctors'] = $model->getDoctors();
        include BASE_PATH . '/views/dashboard/hasta/available-hours.php';
    }

    public function getAvailableHoursAjax() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json; charset=utf-8');

        try {
            $doctor_id = $_POST['doctor_id'] ?? null;
            $date = $_POST['date'] ?? null;
            $patient_id = $_SESSION['user_id'] ?? null;

            if (!$doctor_id || !$date || !$patient_id) {
                echo json_encode(['has_appointment' => false, 'data' => []]);
                return;
            }

            $model = new Appointment();
            $existing = $model->getExistingAppointment($patient_id, $doctor_id, $date);

            if ($existing) {
                echo json_encode([
                    'has_appointment' => true,
                    'data' => $existing
                ]);
                return;
            }

            $hours = $model->getAvailableHours($doctor_id, $date);

            echo json_encode([
                'has_appointment' => false,
                'data' => $hours
            ]);
            return;

        } catch (Exception $e) {
            echo json_encode([
                'error' => true,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ]);
            return;
        }
    }

    public function showAddAppointmentForm() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }
        require_once BASE_PATH . '/models/User.php';
        $userModel = new User();
        $patients = $userModel->getAllByRole('hasta');
        $doctors = $userModel->getAllByRole('doktor');
    
        $title = "Randevu Ekle";
        $content = BASE_PATH . '/views/dashboard/add-appointment.php';
        require BASE_PATH . '/views/layout.php'; // Burada layout.php $patients, $doctors ile çağrılır
    }

    public function cancelAppointment() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['hasta', 'sekreter'])) {
            header("Location: index.php?page=login");
            exit();
        }
        $appointment_id = $_POST['appointment_id'] ?? null;
        if (!$appointment_id) {
            $_SESSION['error'] = "Randevu ID bulunamadı.";
            $target = ($_SESSION['role'] === 'sekreter') ? "appointmentsList" : "myAppointments";
            header("Location: index.php?page=$target");
            exit();
        }

        $model = new Appointment();
        // Eğer yukarıda daha güvenli olanı kullanmak istiyorsan:
        $success = ($_SESSION['role'] === 'sekreter')
            ? $model->cancelByAnyone($appointment_id)
            : $model->cancelByPatientOrSecretary($appointment_id, $_SESSION['user_id']);
        // Eğer hasta ve sekreter ayırmak istemiyorsan sadece cancelByAnyone ile çağır.
        // $success = $model->cancelByAnyone($appointment_id);

        $_SESSION[$success ? 'success' : 'error'] = $success
            ? "Randevu başarıyla iptal edildi."
            : "İptal işlemi başarısız.";

        $target = ($_SESSION['role'] === 'sekreter') ? "appointmentsList" : "myAppointments";
        header("Location: index.php?page=$target");
        exit();
    }

    public function cancelAppointmentAjax() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        $appointment_id = $_POST['appointment_id'] ?? null;
        $user_id = $_SESSION['user_id'] ?? null;

        if (!is_numeric($appointment_id) || !is_numeric($user_id)) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz veri']);
            exit;
        }

        $model = new Appointment();
        $success = $model->cancelByAnyone($appointment_id);

        echo json_encode(['success' => $success]);
        exit;
    }

    public function handleDoctorWorkingHours() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }

        require_once BASE_PATH . '/models/User.php';
        $userModel = new User();
        $doctors = $userModel->getAllByRole('doktor');

        require_once BASE_PATH . '/models/Appointment.php';
        $appointmentModel = new Appointment();

        // 1. DÜZENLEME (Edit Modal’dan gelen)
        if (isset($_POST['save_edit'])) {
            $id = $_POST['edit_id'];
            $weekday = $_POST['edit_weekday'];
            $start_time = $_POST['edit_start_time'];
            $end_time = $_POST['edit_end_time'];
            $is_active = isset($_POST['edit_is_active']) ? 1 : 0;
            $appointmentModel->updateWorkingHour($id, $weekday, $start_time, $end_time, $is_active);
            $_SESSION['success'] = "Çalışma saati başarıyla güncellendi!";
            header("Location: index.php?page=doctorWorkingHours");
            exit;
        }

        // 2. YENİ ÇALIŞMA SAATİ EKLEME (Ana formdan gelen)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doctor_id'])) {
            $doctor_id = $_POST['doctor_id'];
            $weekday = $_POST['weekday'];
            $start_time = $_POST['start_time'];
            $end_time = $_POST['end_time'];
            $is_active = isset($_POST['is_active']) ? 1 : 0;
            if ($doctor_id && $weekday && $start_time && $end_time) {
                $appointmentModel->addWorkingHour($doctor_id, $weekday, $start_time, $end_time, $is_active);
                $_SESSION['success'] = "Yeni çalışma saati başarıyla eklendi!";
            }
            header("Location: index.php?page=doctorWorkingHours");
            exit;
        }

        // Tüm çalışma saatlerini çek
        $working_hours = $appointmentModel->getAllWorkingHours();

        $title = "Doktor Çalışma Saatleri";
        $content = BASE_PATH . '/views/dashboard/sekreter/doctor-working-hours.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function deleteDoctorWorkingHour() {
        if (!isset($_GET['id'])) return;
        $id = $_GET['id'];
        require_once BASE_PATH . '/models/Appointment.php';
        $model = new Appointment();
        $model->deleteWorkingHour($id);
        header("Location: index.php?page=doctorWorkingHours");
        exit;
    }

    public function handleMyAppointments() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'hasta') {
            header("Location: index.php?page=login");
            exit();
        }

        $model = new Appointment();
        $appointments = $model->getByPatientId($_SESSION['user_id']);
        $_SESSION['my_appointments'] = $appointments;

        include BASE_PATH . '/views/dashboard/hasta/my-appointments.php';
    }

    public function handleUpdateStatus() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['sekreter', 'doktor'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $appointment_id = $_POST['appointment_id'] ?? null;
            $new_status = $_POST['status'] ?? null;

            if (!$appointment_id || !in_array($new_status, ['beklemede', 'tamamlandı', 'iptal'])) {
                $_SESSION['error'] = "Geçersiz veri.";
                header("Location: index.php?page=appointmentsList");
                exit;
            }

            $model = new Appointment();
            $updated = $model->updateStatus($appointment_id, $new_status);
            $_SESSION[$updated ? 'success' : 'error'] = $updated
                ? "Randevu durumu güncellendi."
                : "Güncelleme başarısız.";

            $redirect = $_SESSION['role'] === 'sekreter' ? 'appointmentsList' : 'doctorAppointments';
            header("Location: index.php?page={$redirect}");
            exit();
        }
    }
    public function handleAppointmentsList() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }

        $model = new Appointment();
        $appointments = $model->getAllWithNames(); // içinde doktor ve hasta adları olsun
        $_SESSION['all_appointments'] = $appointments;
        include BASE_PATH . '/views/dashboard/appointments-list.php';
    }

    public function getDoctorAppointmentsJson() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            echo json_encode([]);
            exit;
        }

        $doctor_id = $_SESSION['user_id'];
        $model = new Appointment();
        $appointments = $model->getByDoctorId($doctor_id);

        $grouped = [];
        foreach ($appointments as $appt) {
            $date = $appt['appointment_date'];
            if (!isset($grouped[$date])) {
                $grouped[$date] = 0;
            }
            $grouped[$date]++;
        }

        $events = [];
        foreach ($grouped as $date => $count) {
            $events[] = [
                'title' => "$count Hasta",
                'start' => $date
            ];
        }

        echo json_encode($events);
        exit;
    }

    public function getDoctorDayAppointments() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doktor') {
            echo json_encode([]);
            exit;
        }

        $doctor_id = $_SESSION['user_id'];
        $date = $_POST['date'] ?? null;

        if (!$date) {
            echo json_encode([]);
            exit;
        }

        $model = new Appointment();
        $appointments = $model->getByDoctorAndDate($doctor_id, $date);

        $details = array_map(function ($appt) {
            return [
                'id' => $appt['id'],
                'patient' => $appt['patient_name'],
                'time' => $appt['appointment_time'],
                'status' => $appt['status']
            ];
        }, $appointments);

        echo json_encode($details);
        exit;
    }

}
