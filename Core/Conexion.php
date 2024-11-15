<?php
namespace Core;

use PDO;
use PDOException;	

class Conexion
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $host = $_ENV['DB_HOST'] ?: '';
        $dbname = $_ENV['DB_NAME'] ?: '';
        $username = $_ENV['DB_USER'] ?: '';
        $password = $_ENV['DB_PASSWORD'] ?: '';

        try {
            // Establecer la conexión a la base de datos
            $this->connection = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("SET NAMES 'utf8mb4'");  // Asegurarse de que la codificación sea utf8mb4
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Conexion();
        }

        return self::$instance->connection;
    }
}
