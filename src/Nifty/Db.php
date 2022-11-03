<?php

namespace Nifty;

use Nifty\Exceptions\DbException;
use PDO;
use PDOException;

class Db
{
    public PDO $pdo;
    public function __construct()
    {
        $this->pdo = $this->initialize();
    }

    public function initialize(): PDO
    {
        try {
            $pdo = new PDO(
                'mysql:host='.getenv('HOST').';dbname='.getenv('DBNAME'),
                getenv('USERNAME'),
                getenv('PASSWORD'),
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                    PDO::ATTR_TIMEOUT => '5',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
        } catch (PDOException $e) {
            die((new DbException)->throwDbNotConfigured($e));
        }
        return $pdo;
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
        array $params = [],
        string $extra = ''
    ): object|false
    {
        $db = $this->initialize();
        $db->beginTransaction();
        $sql = "SELECT ";
        $sql.= implode(',', $fields);
        $sql.= ' FROM '.$table.'';
        if (!empty($where)) {
            $sql.= ' WHERE '.implode(' ', $where);
        }
        if (!empty($extra)) {
            $sql.= ' '.$extra;
        }
        $query = $db->prepare($sql);
        foreach ($params as $key => $param) {
            $field = substr($where[$key], strpos($where[$key], ':') + 1);
            $query->bindValue(
                $field,
                $param,
                $param === (int)$param ? PDO::PARAM_INT : PDO::PARAM_STR
            );
        }
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
        $db = $this->initialize();
        $db->beginTransaction();
        $sql = "SELECT 1 FROM $table";
        $query = $db->prepare($sql);
        $db->commit();
        if (!$query->execute()) {
            return false;
        }
        return true;
    }
}
