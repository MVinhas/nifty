<?php

namespace Nifty;

use Nifty\Exceptions\DbException;
use PDO;
use PDOException;
use PDOStatement;

require_once 'utils.php';

class Db
{
    public PDO $connection;

    public function __construct()
    {
        $dsn = 'mysql:' . http_build_query(
                [
                    'host' => getenv('HOST'),
                    'port' => 3306,
                    'dbname' => getenv('DBNAME'),
                    'charset' => 'utf8mb4'
                ],
                '',
                ';'
            );
        try {
            $this->connection = new PDO(
                $dsn,
                getenv('USERNAME'),
                getenv('PASSWORD'),
                [
                    PDO::ATTR_TIMEOUT => '5',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        } catch (PDOException $e) {
            die((new DbException())->throwDbNotConfigured($e));
        }
    }

    public function query(string $sql, array $params = []): PDOStatement|false
    {
        $this->connection->beginTransaction();
        $query = $this->connection->prepare($sql);
        $this->connection->commit();
        $msc = microtime(true);
        if (!$query->execute($params)) {
            $this->connection->rollBack();
        }
        $msc = round((microtime(true) - $msc) * 1000, 3);
        if (getenv('ENVIRONMENT') === 'dev') {
            log_to_file(
                "($msc ms)\t$sql\nCaller: " . debug_backtrace()[1]['class'] . "\\" . debug_backtrace()[1]['function'] . "\n\n",
                '.querylog'
            );
        }
        return $query;
    }
}
