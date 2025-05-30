<?php
require_once BASE_PATH . '/config/Database.php';

class User {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function create($full_name, $tc_no, $email, $phone, $password, $role) {
        $sql = "INSERT INTO users (full_name, tc_no, email, phone, password, role)
                VALUES (:full_name, :tc_no, :email, :phone, :password, :role)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            'full_name' => $full_name,
            'tc_no' => $tc_no,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
            'role' => $role
        ]);
    }

    public function updatePassword($user_id, $password) {
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            'password' => $hashed,
            'id' => $user_id
        ]);
    }

    public function getByTc($tc_no) {
        $sql = "SELECT * FROM users WHERE tc_no = :tc_no LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tc_no' => $tc_no]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePasswordByTC($tc_no, $password)
    {
        $sql = "UPDATE users SET password = :password WHERE tc_no = :tc_no";
        $stmt = $this->conn->prepare($sql);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([
            'password' => $hashed,
            'tc_no'    => $tc_no
        ]);
    }


    public function tcExists($tc_no) {
        $sql = "SELECT COUNT(*) FROM users WHERE tc_no = :tc_no";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['tc_no' => $tc_no]);
        return $stmt->fetchColumn() > 0;
    }
    
    public function getAllByRole($role) {
        $sql = "SELECT * FROM users WHERE role = :role";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['role' => $role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNameById($id) {
        $sql = "SELECT full_name FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['full_name'] : 'Bilinmiyor';
    }

    public function getMonthlyPatientGrowth($year) {
        // Aylık hasta kayıtlarını getirir
        $sql = "SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') AS month, 
                    COUNT(*) as patient_count 
                FROM users 
                WHERE role = 'hasta' AND YEAR(created_at) = :year
                GROUP BY month
                ORDER BY month ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['year' => $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllPersonnel() {
        $sql = "SELECT * FROM users WHERE role IN ('doktor','sekreter')";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPersonnel($full_name, $tc_no, $email, $phone, $password, $role) {
        $sql = "INSERT INTO users (full_name, tc_no, email, phone, password, role) 
                VALUES (:full_name, :tc_no, :email, :phone, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute([
            'full_name' => $full_name,
            'tc_no'     => $tc_no,
            'email'     => $email,
            'phone'     => $phone,
            'password'  => $hashedPassword,
            'role'      => $role
        ]);
    }

    public function getPersonnelById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePersonnel($id, $full_name, $tc_no, $email, $phone, $role, $password = null) {
        if ($password) {
            $sql = "UPDATE users SET full_name=?, tc_no=?, email=?, phone=?, role=?, password=? WHERE id=?";
            $params = [$full_name, $tc_no, $email, $phone, $role, $password, $id];
        } else {
            $sql = "UPDATE users SET full_name=?, tc_no=?, email=?, phone=?, role=? WHERE id=?";
            $params = [$full_name, $tc_no, $email, $phone, $role, $id];
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }


    public function deletePersonnel($user_id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
    }

}
?>
