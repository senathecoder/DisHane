<?php
require_once BASE_PATH . '/config/Database.php';

class Appointment {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Randevu oluşturma
    public function create($patient_id, $doctor_id, $created_by, $date, $time, $notes = null) {
        // Aynı hasta aynı güne daha önce randevu almış mı?
        $checkPatient = $this->conn->prepare("
            SELECT id FROM appointments 
            WHERE patient_id = :patient_id 
              AND appointment_date = :date 
              AND status != 'iptal'
        ");
        $checkPatient->execute([
            'patient_id' => $patient_id,
            'date' => $date
        ]);
        if ($checkPatient->fetch()) return false;

        // Aynı doktor aynı saatte başka hasta almış mı?
        $check = $this->conn->prepare("
            SELECT id FROM appointments 
            WHERE doctor_id = :doctor_id 
              AND appointment_date = :date 
              AND appointment_time = :time
              AND status != 'iptal'
        ");
        $check->execute([
            'doctor_id' => $doctor_id,
            'date' => $date,
            'time' => $time
        ]);
        if ($check->fetch()) return false;

        // Randevuyu oluştur
        $sql = "INSERT INTO appointments 
                (patient_id, doctor_id, secretary_id, appointment_date, appointment_time, status, notes)
                VALUES (:patient_id, :doctor_id, :created_by, :date, :time, 'beklemede', :notes)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id,
            'created_by' => $created_by,
            'date' => $date,
            'time' => $time,
            'notes' => $notes
        ]);
    }

    public function getAll() {
        $sql = "SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByDoctorId($doctor_id) {
        $sql = "SELECT * FROM appointments WHERE doctor_id = :doctor_id ORDER BY appointment_date DESC, appointment_time DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['doctor_id' => $doctor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByDoctorAndDate($doctor_id, $date) {
        $sql = "SELECT a.*, u.full_name AS patient_name
                FROM appointments a
                JOIN users u ON a.patient_id = u.id
                WHERE a.doctor_id = :doctor_id AND a.appointment_date = :date
                ORDER BY a.appointment_time ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['doctor_id' => $doctor_id, 'date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithNames() {
        $sql = "SELECT a.id, a.appointment_date, a.appointment_time, a.status, a.notes,
                    p.full_name AS patient_name,
                    d.full_name AS doctor_name
                FROM appointments a
                JOIN users p ON a.patient_id = p.id
                JOIN users d ON a.doctor_id = d.id
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateStatus($appointment_id, $new_status) {
        $sql = "UPDATE appointments SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'status' => $new_status,
            'id' => $appointment_id
        ]);
    }

    public function getDoctors() {
        $stmt = $this->conn->prepare("SELECT id, full_name FROM users WHERE role = 'doktor'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableHours($doctor_id, $date) {
        $weekdayEN = date('l', strtotime($date));
        $enToTr = [
            'Monday'    => 'Pazartesi',
            'Tuesday'   => 'Salı',
            'Wednesday' => 'Çarşamba',
            'Thursday'  => 'Perşembe',
            'Friday'    => 'Cuma',
            'Saturday'  => 'Cumartesi',
            'Sunday'    => 'Pazar',
        ];
        $weekday = $enToTr[$weekdayEN] ?? $weekdayEN;

        $working = $this->getDoctorWorkingHours($doctor_id, $weekday);
        if (!$working) return [];

        $workingStart = strtotime($working['start_time']);
        $workingEnd   = strtotime($working['end_time']);
        $start = strtotime('08:00');
        $end   = strtotime('17:00');

        $takenHours = $this->getTakenHoursByDate($doctor_id, $date);

        $result = [];
        for ($t = $start; $t < $end; $t += 3600) {
            $time = date('H:i', $t);
            $isWorkingHour = ($t >= $workingStart && $t < $workingEnd);
            $isTaken = in_array($time, $takenHours);

            $result[] = [
                'time' => $time,
                'available' => $isWorkingHour && !$isTaken,
                'closed' => !$isWorkingHour
            ];
        }

        return $result;
    }

    public function getExistingAppointmentByDate($patient_id, $date) {
        $sql = "SELECT id, appointment_time
                FROM appointments
                WHERE patient_id = :patient_id 
                  AND appointment_date = :date 
                  AND status != 'iptal'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'patient_id' => $patient_id,
            'date' => $date
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getExistingAppointment($patient_id, $doctor_id, $date) {
        $sql = "SELECT id, appointment_time
                FROM appointments
                WHERE patient_id = :patient_id 
                  AND doctor_id = :doctor_id 
                  AND appointment_date = :date 
                  AND status != 'iptal'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id,
            'date' => $date
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelByPatient($appointment_id, $patient_id) {
        $sql = "UPDATE appointments SET status = 'iptal' 
                WHERE id = :id AND (patient_id = :patient_id OR secretary_id = :patient_id)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id' => $appointment_id,
            'patient_id' => $patient_id
        ]);
    }
    
    public function cancelByAnyone($appointment_id) {
        $sql = "UPDATE appointments SET status = 'iptal' WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $appointment_id]);
    }

    public function getDoctorWorkingHours($doctor_id, $weekday) {
        $sql = "SELECT start_time, end_time 
                FROM doctor_hours 
                WHERE doctor_id = :doctor_id 
                  AND weekday = :weekday 
                  AND is_active = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'doctor_id' => $doctor_id,
            'weekday' => $weekday
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllWorkingHours() {
        $sql = "SELECT dh.*, u.full_name AS doctor_name
                FROM doctor_hours dh
                JOIN users u ON dh.doctor_id = u.id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addWorkingHour($doctor_id, $weekday, $start_time, $end_time, $is_active) {
        $sql = "INSERT INTO doctor_hours (doctor_id, weekday, start_time, end_time, is_active) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$doctor_id, $weekday, $start_time, $end_time, $is_active]);
    }
    
    public function updateWorkingHour($id, $weekday, $start_time, $end_time, $is_active) {
        $sql = "UPDATE doctor_hours SET weekday = :weekday, start_time = :start_time, end_time = :end_time, is_active = :is_active WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'weekday' => $weekday,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'is_active' => $is_active,
            'id' => $id
        ]);
    }

    public function deleteWorkingHour($id) {
        $sql = "DELETE FROM doctor_hours WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function getTakenHoursByDate($doctor_id, $date) {
        $sql = "SELECT appointment_time 
                FROM appointments 
                WHERE doctor_id = :doctor_id 
                AND appointment_date = :date 
                AND status != 'iptal'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'doctor_id' => $doctor_id,
            'date' => $date
        ]);
        $rawHours = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Saatleri 'H:i' formatına dönüştür
        return array_map(function($t) {
            return date('H:i', strtotime($t));
        }, $rawHours);
    }

    public function getByPatientId($patient_id) {
        $sql = "SELECT a.*, u.full_name AS doctor_name 
                FROM appointments a
                JOIN users u ON a.doctor_id = u.id
                WHERE a.patient_id = :patient_id
                ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['patient_id' => $patient_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function handleAppointmentsList() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'sekreter') {
            header("Location: index.php?page=login");
            exit;
        }

        $model = new Appointment();
        $appointments = $model->getAllWithNames();
        $_SESSION['all_appointments'] = $appointments;

        include BASE_PATH . '/views/dashboard/sekreter/appointments-list.php';
    }

    public function getAppointmentById($id) {
        $stmt = $this->conn->prepare("SELECT a.*, u1.full_name as patient_name, u2.full_name as doctor_name
                                    FROM appointments a
                                    JOIN users u1 ON a.patient_id = u1.id
                                    JOIN users u2 ON a.doctor_id = u2.id
                                    WHERE a.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMonthlyDoctorStats($year, $month) {
        $sql = "SELECT d.id as doctor_id, d.full_name as doctor_name, COUNT(a.id) as patient_count
                FROM users d
                LEFT JOIN appointments a ON d.id = a.doctor_id
                    AND MONTH(a.appointment_date) = :month AND YEAR(a.appointment_date) = :year
                WHERE d.role = 'doktor'
                GROUP BY d.id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'month' => $month,
            'year' => $year
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Appointment.php modeline ekle
    public function getAppointmentStatusStats($year, $month)
    {
        $start = "$year-$month-01";
        $end = date("Y-m-t", strtotime($start));
        // Eğer appointment_date ise:
        $stmt = $this->conn->prepare("SELECT status, COUNT(*) as count FROM appointments WHERE appointment_date BETWEEN ? AND ? GROUP BY status");

        $stmt->execute([$start, $end]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['status']] = (int)$row['count'];
        }
        return $result;
    }

        public function cancelByPatientOrSecretary($appointment_id, $user_id) {
        $sql = "UPDATE appointments SET status = 'iptal' WHERE id = ? AND (patient_id = ? OR secretary_id = ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$appointment_id, $user_id, $user_id]);
    }

}
