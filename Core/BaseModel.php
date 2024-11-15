<?php
namespace Core;
use Core\Conexion;

abstract class BaseModel {
    protected $conn;
    protected $table;
    protected $primaryKeys; // Array de llaves primarias

    public function __construct($table, $primaryKeys) {
        $this->conn = Conexion::getInstance();
        $this->table = $table;
        $this->primaryKeys = $primaryKeys;
    }

    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_values($data));
    }

    // Leer un registro por llaves compuestas
    public function read($keys) {
        $conditions = implode(" AND ", array_map(function($key) { return "$key = ?"; }, array_keys($keys)));
        $sql = "SELECT * FROM $this->table WHERE $conditions";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute( array_values($keys))) {
            return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
        } else {
            throw new \Exception("Error al ejecutar la consulta: " . implode(", ", $stmt->errorInfo()));
        }
    }

    // Leer muchos registros por llaves compuestas
    public function readWhere($keys) {
        $conditions = implode(" AND ", array_map(function($key) { return "$key = ?"; }, array_keys($keys)));
        $sql = "SELECT * FROM $this->table WHERE $conditions";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_values($keys));
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Actualizar un registro por llaves compuestas
    public function update($keys, $data) {
        $sets = implode(", ", array_map(function($key) { return "$key = ?"; }, array_keys($data)));
        $conditions = implode(" AND ", array_map(function($key) { return "$key = ?"; }, array_keys($keys)));
        $sql = "UPDATE $this->table SET $sets WHERE $conditions";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_merge(array_values($data), array_values($keys)));
    }

    // Eliminar un registro por llaves compuestas
    public function delete($keys) {
        $conditions = implode(" AND ", array_map(function($key) { return "$key = ?"; }, array_keys($keys)));
        $sql = "DELETE FROM $this->table WHERE $conditions";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array_values($keys));
    }

    // Leer todos los registros
    public function readAll() {
        $sql = "SELECT * FROM $this->table LIMIT 100";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPrimaryKey() {
        return $this->primaryKeys;
    }
}
