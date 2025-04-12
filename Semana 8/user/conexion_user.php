<?php
// Elimina cualquier espacio antes de <?php
define('PDO_HOST', 'localhost');
define('PDO_DBNAME', 'agencia');
define('PDO_USER', 'root');
define('PDO_PASS', '');
define('PDO_PORT', 3306);

class PDOConnection {
    private static $pdoInstance = null;
    
    public static function getConnection() {
        if (self::$pdoInstance === null) {
            try {
                self::$pdoInstance = new PDO(
                    "mysql:host=".PDO_HOST.";dbname=".PDO_DBNAME.";port=".PDO_PORT.";charset=utf8mb4",
                    PDO_USER,
                    PDO_PASS,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch(PDOException $e) {
                // Registrar error sin mostrar al usuario
                error_log('PDO Connection Error: ' . $e->getMessage());
                return null;
            }
        }
        return self::$pdoInstance;
    }
}
