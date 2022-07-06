<?php

namespace Nifty;

use Nifty\Exceptions\DatabaseException;
use Nifty\Exceptions\SiteException;
use Exception;
use PDO;
use PDOException;

class Db
{
    public function initialize() : PDO
    {
        try {
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
        } catch (PDOException $e) {
            throw DatabaseException::cannotConnect($e);
        }
    }

    public function create(string $table, array $fields) : void
    {
        $db = self::initialize();
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
        array $where = []
    ) : object {
        $db = self::initialize();
        $db->beginTransaction();
        $sql = "SELECT ";
        $sql.= implode(',', $fields);
        $sql.= ' FROM `'.$table.'`';
        if (!empty($where)) {
            $sql.= ' WHERE '.implode(',', $where);
        }
        $query = $db->prepare($sql);
        $db->commit();
        $query->execute();
        return (object)$query->fetchAll(PDO::FETCH_OBJ);
    }

    public function upsert(
        string $table,
        array $fields,
        array $params
    ) : void {
        $db = self::initialize();
        $db->beginTransaction();
        $sql = "INSERT INTO $table SET ";
        $sql .= implode(',', $fields);
        $sql .= " ON DUPLICATE KEY UPDATE ";
        $sql .= implode(',', $fields);
        $query = $db->prepare($sql);
        $db->commit();
        $query->execute($params);
    }

    public function clean(string $table) : void
    {
        $db = self::initialize();
        $db->beginTransaction();
        $sql = "DELETE FROM $table";
        $query = $db->prepare($sql);
        $db->commit();
        $query->execute();
    }

    public function drop(string $table) : void
    {
        $db = self::initialize();
        $db->beginTransaction();
        $sql = "DROP TABLE $table";
        $query = $db->prepare($sql);
        $db->commit();
        $query->execute();
    }
}
