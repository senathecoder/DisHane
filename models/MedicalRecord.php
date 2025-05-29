<?php
require_once __DIR__ . '/../config/Database.php';

class MedicalRecord {
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }

    // 1. Hasta kendi kayıtlarını görsün
    public function getByPatient($patient_id) {
        $stmt = $this->db->prepare("SELECT * FROM medical_records WHERE patient_id = ? ORDER BY record_date DESC");
        $stmt->execute([$patient_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Son X kayıt (sekreter paneli)
    public function getRecent($limit = 15) {
        $stmt = $this->db->prepare("SELECT mr.*, u.full_name AS patient_name FROM medical_records mr JOIN users u ON mr.patient_id = u.id ORDER BY mr.created_at DESC LIMIT ?");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Hasta adıyla arama (sekreter/doktor)
    public function getByPatientSearch($name) {
        $stmt = $this->db->prepare("SELECT mr.*, u.full_name AS patient_name FROM medical_records mr JOIN users u ON mr.patient_id = u.id WHERE u.full_name LIKE ? ORDER BY mr.created_at DESC");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 4. Kayıt ekle (sekreter ekler)
    public function add($patient_id, $doctor_id, $test_type, $result, $record_date) {
        $stmt = $this->db->prepare("INSERT INTO medical_records (patient_id, doctor_id, test_type, result, record_date) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$patient_id, $doctor_id, $test_type, $result, $record_date]);
    }

    // 5. Bütün hastaları getir (sekreter formu için)
    public function getAllPatients() {
        $stmt = $this->db->query("SELECT id, full_name FROM users WHERE role = 'hasta' ORDER BY full_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 6. Bütün doktorları getir (sekreter formu için)
    public function getAllDoctors() {
        $stmt = $this->db->query("SELECT id, full_name FROM users WHERE role = 'doktor' ORDER BY full_name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 7. Tek bir kaydı ID ile getir (düzenleme/silme için)
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM medical_records WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 8. Kayıt sil (sekreter için)
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM medical_records WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // 9. Kayıt güncelle (istersen ekleyebilirsin)
    public function update($id, $test_type, $result, $record_date) {
        $stmt = $this->db->prepare("UPDATE medical_records SET test_type = ?, result = ?, record_date = ? WHERE id = ?");
        return $stmt->execute([$test_type, $result, $record_date, $id]);
    }
}
