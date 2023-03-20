<?php

namespace Nifty\Models;

class Admin extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getVisits(): object|false
    {
        return $this->db->query("SELECT firstvisit AS date FROM sessions GROUP BY firstvisit");
    }
}
