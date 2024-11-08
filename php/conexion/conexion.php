<?php

class conn {

    private static $pdo = null;

    public static function conn() {
        if (self::$pdo !== null) {
            return self::$pdo;
        }
        try {
            self::$pdo = new PDO("mysql:host=" . 'localhost' . ";dbname=" . 'cecytem' . ";charset=utf8mb4", 'root', '');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$pdo;
        } catch (PDOException $e) {
            print "Error de conexión a la base de datos: " . $e->getMessage() . "<br>";
            return null;
        }
    }
}
