<?php

namespace App\Controllers;

use PDO;
use PDOException;

class DbController {
    private $host = 'localhost';
    private $db = 'clicterapia';
    private $user = 'root';
    private $password = '';
    private $charset = 'utf8mb4';
    private $connection;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function select($table, $conditions = [], $fields = '*', $orderBy = null) {
        try {
            $sql = "SELECT $fields FROM $table";
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereConditions = [];
                foreach ($conditions as $key => $value) {
                    $whereConditions[] = "$key = :$key";
                }
                $sql .= implode(' AND ', $whereConditions);
            }

            if ($orderBy) {
                $sql .= " ORDER BY $orderBy";
            }

            $stmt = $this->connection->prepare($sql);
            
            if (!empty($conditions)) {
                foreach ($conditions as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function update($table, $data, $conditions) {
        try {
            $sql = "UPDATE $table SET ";
            $sets = [];
            foreach ($data as $key => $value) {
                $sets[] = "$key = :set_$key";
            }
            $sql .= implode(', ', $sets);

            $sql .= " WHERE ";
            $whereConditions = [];
            foreach ($conditions as $key => $value) {
                $whereConditions[] = "$key = :where_$key";
            }
            $sql .= implode(' AND ', $whereConditions);

            $stmt = $this->connection->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":set_$key", $value);
            }
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":where_$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function delete($table, $conditions) {
        try {
            $sql = "DELETE FROM $table WHERE ";
            $whereConditions = [];
            foreach ($conditions as $key => $value) {
                $whereConditions[] = "$key = :$key";
            }
            $sql .= implode(' AND ', $whereConditions);

            $stmt = $this->connection->prepare($sql);

            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function insert($table, $data) {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            
            $stmt = $this->connection->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    
}
