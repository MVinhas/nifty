<?php

namespace Nifty\Models;

use Nifty\Db;

class Site
{
    public function getMenu(): object
    {
        return (new Db())->select(['*'], 'menu', ['status' => 1]);
    }
}
