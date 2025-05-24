<?php

namespace Core;

use PDO;
use PDOException;

class Model
{
    protected static $pdo = null;
    protected string $table;

    public function __construct()
    {
        if (self::$pdo === null) {
            self::con();
        }
    }

    protected static function con()
    {
        $host = 'localhost';
        $db   = 'exampledb';
        $user = 'root';
        $pass = '347913';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            self::$pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }

    public function all()
    {
        $stmt = self::$pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = rtrim(str_repeat('?, ', count($data)), ', ');
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute(array_values($data));
    }


    public function update(array $data, $id)
    {
        if (empty($data)) {
            throw new \Exception("No data provided for update.");
        }

        $setClauseParts = [];
        foreach ($data as $column => $value) {
            $setClauseParts[] = "$column = ?";
        }

        $setClause = implode(', ', $setClauseParts);

        $sql = "UPDATE {$this->table} SET $setClause WHERE id = ?";
        $stmt = self::$pdo->prepare($sql);

        $values = array_values($data);
        $values[] = $id;

        return $stmt->execute($values);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$id]);
    }


}
