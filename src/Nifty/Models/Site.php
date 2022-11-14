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

    public function doLogin($post): bool
    {
        $exists =
        (new Db())
        ->select(
            ['email, username, password'],
            'users',
            ['email = :email',' AND status = :status'],
            [$post['email'], 1]
        );
        if (isset($exists->{0})) {
            if (password_verify($post['password'], $exists->{0}->password)) {
                unset($exists->{0}->password);
                $_SESSION['user'] = $exists->{0};
                return true;
            }
        }
        return false;
    }
}
