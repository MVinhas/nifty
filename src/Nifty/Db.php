<?php

namespace Nifty;

use Nifty\Exceptions\DatabaseException;
use Nifty\Exceptions\SiteException;
use Exception;
use PDO;
use PDOException;

class Db
{
    public static function initialize()
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
            if (getenv('HOST')) {
                throw SiteException::HostNotFound();
            } else {
                throw DatabaseException::cannotConnect($e);
            }
        }
    }

    public static function create(string $table, array $fields)
    {
        $db = self::initialize();
        $db->beginTransaction();

        try {
            $sql = 'CREATE TABLE IF NOT EXISTS `'.$table.'`(';
            $sql .= implode(',', $fields);
            $sql .= ')';
            $query = $db->prepare($sql);
            $db->commit();
            $query->execute();
        } catch (PDOException $e) {
            $db->rollback();
            throw DatabaseException::cannotCreate($e);
        }
    }

    public static function select(
        array $fields,
        string $table,
        array $where = []
    )
    {
        $db = self::initialize();
        $db->beginTransaction();

        try {
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
        } catch (PDOException $e) {
            $db->rollback();
            throw DatabaseException::cannotSelect($e);
        }
    }

    public static function insert(
        string $table,
        array $fields,
        array $values
    )
    {
        $db = self::initialize();
        $db->beginTransaction();

        try {
            $sql = "INSERT INTO `".$table;
            $sql .= "` (".implode(',', $fields).")";
            $sql .= " VALUES (".implode(',', $values).")";
            $query = $db->prepare($sql);
            $db->commit();
            $query->execute();
        } catch (PDOException $e) {
            $db->rollBack();
            throw DatabaseException::cannotInsert($e, $sql);
        }
    }

    public static function clean(string $table)
    {
        $db = self::initialize();
        $db->beginTransaction();
        try {
            $sql = "DELETE FROM $table";
            $query = $db->prepare($sql);
            $db->commit();
            $query->execute();
        } catch (PDOException $e) {
            $db->rollback();
            throw DatabaseException::cannotClean($e, $sql);
        }
    }

    public static function drop(string $table)
    {
        $db = self::initialize();
        $db->beginTransaction();
        try {
            $sql = "DROP TABLE $table";
            $query = $db->prepare($sql);
            $db->commit();
            $query->execute();
        } catch (PDOException $e) {
            $db->rollback();
            throw DatabaseException::cannotDrop($e, $sql);
        }
    }
}