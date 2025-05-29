<?php

class Database {
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            $host = 'localhost';
            $db = 'dishane_db';     // veritabanı ismi
            $user = 'root';        // Veritabanı kullanıcı adı
            $pass = '';            // Veritabanı şifresi (varsayılan localhost için genellikle boş)
            $charset = 'utf8mb4';
            
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Hata ayarları
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Veri çekme modu (associative array)
                PDO::ATTR_EMULATE_PREPARES => false,                // Güvenlik için
            ];

            try {
                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("Veritabanı bağlantı hatası: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
