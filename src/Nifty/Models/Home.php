<?php

namespace Nifty\Models;

use Nifty\Db;

class Home
{
    public function getPosts(): object|false
    {
        return (new Db())->select(['*'], 'posts', ['status = :status'], [1]);
    }

    public function getMainPost(): object|false
    {
        return (new Db())
        ->select(
            ['*'],
            'posts',
            ['status = :status'],
            [1],
            'ORDER BY featured DESC, id DESC LIMIT 1'
        )->{0};
    }
}
