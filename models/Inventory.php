<?php
require_once __DIR__ . '/../config/Database.php';

class Inventory {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();  
    }

    // Tüm stokları getir
    public function getAllItems() {
        $stmt = $this->db->query("SELECT * FROM inventory_items ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Doktorun kendi kullanım kayıtları
    public function getDoctorUsageLogs($doctor_id) {
        $stmt = $this->db->prepare("
        SELECT i.name, il.change_quantity AS used_quantity, il.created_at, il.reason
        FROM inventory_logs il
        JOIN inventory_items i ON il.item_id = i.id
        JOIN appointments a ON il.related_appointment_id = a.id
        WHERE a.doctor_id = ?
        ORDER BY il.created_at DESC
        LIMIT 15
    ");
    $stmt->execute([$doctor_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Belirli bir stok kalemini getir
    public function getItem($id) {
        $stmt = $this->db->prepare("SELECT * FROM inventory_items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Yeni stok kalemi ekle
    public function addItem($name, $quantity) {
        $stmt = $this->db->prepare("INSERT INTO inventory_items (name, quantity) VALUES (?, ?)");
        return $stmt->execute([$name, $quantity]);
    }

    /// Malzeme stoğu ve log ekle
    public function updateQuantity($item_id, $change, $reason = null, $appointment_id = null, $user_id = null) {
        try {
            $this->db->beginTransaction();

            // Update item quantity
            $stmt = $this->db->prepare("UPDATE inventory_items SET quantity = quantity + ? WHERE id = ?");
            $stmt->execute([$change, $item_id]);

            // Insert log
            $log = $this->db->prepare("
                INSERT INTO inventory_logs (item_id, change_quantity, reason, related_appointment_id, user_id)
                VALUES (?, ?, ?, ?, ?)
            ");
            $log->execute([
                $item_id,
                $change,
                $reason,
                $appointment_id,
                $user_id
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Randevuya göre kullanım logları
    public function getUsageLogsByAppointment($appointment_id) {
        $stmt = $this->db->prepare("SELECT i.name, il.change_quantity AS used_quantity, il.created_at, il.reason
                                    FROM inventory_logs il
                                    JOIN inventory_items i ON il.item_id = i.id
                                    WHERE il.related_appointment_id = ?
                                    ORDER BY il.created_at DESC
                                    LIMIT 25");
        $stmt->execute([$appointment_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Logları getir
    public function getLogs($item_id) {
        $stmt = $this->db->prepare("SELECT * FROM inventory_logs WHERE item_id = ? ORDER BY created_at DESC LIMIT 10");
        $stmt->execute([$item_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopUsedItems($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT ii.name, ABS(SUM(il.change_quantity)) AS total_used
            FROM inventory_logs il
            INNER JOIN inventory_items ii ON il.item_id = ii.id
            WHERE il.change_quantity < 0
            GROUP BY il.item_id
            ORDER BY total_used DESC
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTop10ItemUsageAndStock() {
        $stmt = $this->db->prepare("
            SELECT 
                ii.name, 
                ii.quantity AS current_stock,
                ABS(SUM(CASE WHEN il.change_quantity < 0 THEN il.change_quantity ELSE 0 END)) AS total_used,
                ii.quantity + ABS(SUM(CASE WHEN il.change_quantity < 0 THEN il.change_quantity ELSE 0 END)) AS initial_stock
            FROM inventory_items ii
            LEFT JOIN inventory_logs il ON il.item_id = ii.id
            GROUP BY ii.id
            ORDER BY total_used DESC
            LIMIT 10
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDailyUsageByDate($date) {
        $stmt = $this->db->prepare("
            SELECT i.name AS item_name, il.change_quantity, il.reason, a.appointment_time, u.full_name AS doctor
            FROM inventory_logs il
            JOIN inventory_items i ON il.item_id = i.id
            JOIN appointments a ON il.related_appointment_id = a.id
            JOIN users u ON a.doctor_id = u.id
            WHERE a.appointment_date = ?
            ORDER BY a.appointment_time ASC
        ");
        $stmt->execute([$date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Kritik stok göstergesi
    public function getLowStockItems($threshold = 5) {
        $stmt = $this->db->prepare("SELECT name, quantity FROM inventory_items WHERE quantity <= ? ORDER BY quantity ASC");
        $stmt->execute([$threshold]);
        return $stmt->fetchAll();
    }
    
    public function getCriticalStocks($limit = 5) {
        $sql = "SELECT id, name, quantity 
                FROM inventory_items 
                ORDER BY quantity ASC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getMostUsedItems($limit = 5) {
        $sql = "SELECT ii.id, ii.name, 
                    ABS(SUM(il.change_quantity)) AS used_amount
                FROM inventory_items ii
                JOIN inventory_logs il ON il.item_id = ii.id
                WHERE il.change_quantity < 0
                AND il.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                GROUP BY ii.id
                ORDER BY used_amount DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
