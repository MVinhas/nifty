<?php

namespace Nifty\Database;

use PDO;

class Connection
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
}
