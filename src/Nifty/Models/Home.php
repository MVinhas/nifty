<?php

namespace Nifty\Models;

use Nifty\Db;

class Home
{
    public function getPosts(): object
    {
        return (new Db())->select(['*'], 'posts', ['status' => 1]);
    }
}
