<?php

namespace Nifty\Database;

use Exception;
use PDO;

class Db
{
    protected $db;

    public function __construct()
    {
        $this->db = $this->initialize();
    }

    public function initialize(): PDO
    {
        return new PDO(
            'mysql:host='.getenv('HOST').';dbname='.getenv('DBNAME'),
            getenv('USERNAME'),
            getenv('PASSWORD'),
            [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                PDO::ATTR_TIMEOUT => '5',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function create(string $table, array $fields): void
    {
        $db = $this->initialize();
        $db->beginTransaction();

        $sql = 'CREATE TABLE IF NOT EXISTS `'.$table.'`(';
        $sql .= implode(',', $fields);
        $sql .= ')';
        $query = $db->prepare($sql);
        $db->commit();
        $query->execute();
    }

    public function select(
        array $fields,
        string $table,
        array $where = [],
        string $extra = ''
    ): object|false
    {
        $db = $this->initialize();
        $db->beginTransaction();
        $sql = "SELECT ";
        $sql.= implode(',', $fields);
        $sql.= ' FROM `'.$table.'`';
        if (!empty($where)) {
            $sql.= ' WHERE '.implode(',', $where);
        }
        $sql.= $extra;
        $query = $db->prepare($sql);
        $db->commit();
        if (!$query->execute()) {
            return false;
        }
        $rows = (object)$query->fetchAll(PDO::FETCH_OBJ);
        if (!$rows) {
            return false;
        }
        return $rows;
    }

    public function upsert(
        string $table,
        array $fields,
        array $params
    ): void {
        $db = $this->initialize();
        $db->beginTransaction();
        $sql = "INSERT INTO $table SET ";
        $sql .= implode(',', $fields);
        $sql .= " ON DUPLICATE KEY UPDATE ";
        $sql .= implode(',', $fields);
        $query = $db->prepare($sql);
        $db->commit();
        $query->execute($params);
    }

    public function clean(string $table): void
    {
        $db = $this->initialize();
        $db->beginTransaction();
        if ($this->tableExists($table)) {
            $sql = "TRUNCATE TABLE $table";
            $query = $db->prepare($sql);
            $db->commit();
            $query->execute();
        }
    }

    public function drop(string $table): void
    {
        $db = $this->initialize();
        $db->beginTransaction();
        if ($this->tableExists($table)) {
            $sql = "DROP TABLE $table";
            $query = $db->prepare($sql);
            $db->commit();
            $query->execute();
        }
    }

    private function tableExists(string $table): bool
    {
        try {
            $db = $this->initialize();
            $db->beginTransaction();
            $sql = "SELECT 1 FROM $table";
            $query = $db->prepare($sql);
            $db->commit();
            if (!$query->execute()) {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
