<?php
// Ubicación: /Semana 8/conexion.php

class Database {
    private static $instance = null;
    private $conn;
    
    private function __construct() {
        // Datos de conexión (modificables según entorno)
        $config = [
            'host' => 'localhost',
            'dbname' => 'agencia',
            'username' => 'root',
            'password' => ''
        ];
        
        try {
            $this->conn = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8", 
                $config['username'], 
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false // Mejora seguridad
                ]
            );
        } catch(PDOException $e) {
            error_log('[' . date('Y-m-d H:i:s') . '] Error en conexion.php: ' . $e->getMessage());
            throw new Exception('Servicio no disponible. Intente más tarde.');
        }
    }
    
    public static function getConnection() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}

// Uso en otros archivos:
// require __DIR__ . '/conexion.php'; 
// $conn = Database::getConnection();
?>