<?php

namespace Nifty\Models;

use Nifty\Db;

class Site
{
    public function getMenu(): object|false
    {
        return (new Db())->select(['*'], 'menu', ['status = :status'], [1]);
    }

    public function isAdmin(string $model): bool
    {
        $exists = (new Db())->select(['id'], 'pages', ['slug = :slug'], [$model]);
        if (isset($exists->{0}) && is_int($exists->{0}->id)) {
            return true;
        }
        return false;
    }
}
