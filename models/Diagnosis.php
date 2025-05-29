<?php
require_once __DIR__ . '/../config/Database.php';

class Diagnosis {
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Yeni tanı ekle
    public function add($test_id, $doctor_id, $diagnosis, $diagnosis_date) {
        $stmt = $this->db->prepare("INSERT INTO diagnoses (test_id, doctor_id, diagnosis, diagnosis_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$test_id, $doctor_id, $diagnosis, $diagnosis_date]);
    }

    // Belirli bir testin tüm tanıları (tanı geçmişi)
    public function getByTest($test_id) {
        $stmt = $this->db->prepare("SELECT * FROM diagnoses WHERE test_id = ? ORDER BY diagnosis_date DESC, id DESC");
        $stmt->execute([$test_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Belirli bir tanıyı id ile getir (düzenleme/silme için)
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM diagnoses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tanı sil
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM diagnoses WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // Tanı güncelle
    public function update($id, $diagnosis) {
        $stmt = $this->db->prepare("UPDATE diagnoses SET diagnosis = ? WHERE id = ?");
        return $stmt->execute([$diagnosis, $id]);
    }
}
