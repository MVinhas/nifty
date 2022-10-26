<?php

namespace Nifty\Models;

use Nifty\Db;
use Nifty\Utils;

class Site
{
    public function getMenu(): object|false
    {
        return (new Db())->select(['*'], 'menu', ['status = :status'], [1]);
    }

    public function getCategories(): object|false
    {
        $categories = (new Db())->select(['*'], 'categories', ['status = :status'], [1]);
        if ($categories) {
            foreach ($categories as $k => &$v) {
                $v->slug = (new Utils())->slugify($v->name);
            }
        }
        return $categories;
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
