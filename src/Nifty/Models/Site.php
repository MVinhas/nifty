<?php

namespace Nifty\Models;

use Nifty\Db;

class Site
{
    public function getMenu(): object|false
    {
        return (new Db())->select(['*'], 'menu', ['status = :status'], [1]);
    }
}
