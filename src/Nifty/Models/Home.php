<?php

namespace Nifty\Models;

use Nifty\Db;

class Home
{
    public function getPosts(): object|false
    {
        return (new Db())->select(['*'], 'posts', ['status = :status'], [1]);
    }
}
