<?php

namespace Nifty\Models;

use Nifty\Db;
use Nifty\Utils;

class Site
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db;
        $this->visitCounter();
    }

    public function visitCounter(): void
    {
        $userAlreadyVisited = $this->db->select(
            ['id'],
            'sessions',
            ['session = :session'],
            [session_id()]
        );

        if (empty((array)$userAlreadyVisited)) {
            $this->db->upsert(
                'sessions',
                ['session = :session', 'firstvisit = :firstvisit'],
                ['session' => session_id(), 'firstvisit' => date('Y-m-d H:i:s')]
            );
        }
    }

    public function getMenu(): object|false
    {
        return $this->db->select(['*'], 'menu', ['status = :status'], [1]);
    }

    public function getCategories(): object|false
    {
        $categories = $this->db->select(['*'], 'categories', ['status = :status'], [1]);
        if ($categories) {
            foreach ($categories as $k => &$v) {
                $v->slug = (new Utils())->slugify($v->name);
            }
        }
        return $categories;
    }

    public function isAdmin(string $model): bool
    {
        $exists = $this->db->select(['id'], 'pages', ['slug = :slug'], [$model]);
        if (isset($exists->{0}) && is_int($exists->{0}->id)) {
            return true;
        }
        return false;
    }

    public function doLogin($post): bool
    {
        $exists =
        $this->db
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
