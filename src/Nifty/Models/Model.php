<?php

namespace Nifty\Models;

use Nifty\Db;

class Model
{
    protected ?Db $db = null;

    public function __construct()
    {
        $this->db = new Db();
    }
}