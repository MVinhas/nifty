<?php

namespace Nifty\Models;

use Nifty\Db;

class Admin
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function getVisits() : object|false
    {
        return $this->db
        ->select(
            ['firstvisit AS date'],
            'sessions',
            [],
            [],
            'GROUP BY firstvisit'
        );
    }
}
