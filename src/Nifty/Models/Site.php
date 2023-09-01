<?php

namespace Nifty\Models;

use Nifty\Utils;

class Site extends Model
{

    public function __construct()
    {
        parent::__construct();
        $this->visitCounter();
    }

    public function visitCounter(): void
    {
        $userAlreadyVisited = $this->db->query(
            "SELECT id FROM sessions where session = :session", [':session' => session_id()]
        )->fetch();
        if (!$userAlreadyVisited) {
            $this->db->query(
                "INSERT INTO sessions (`session`, `firstvisit`) VALUES (:session, :firstvisit)", [':session' => session_id(), ':firstvisit' => date('Y-m-d H:i:s')]
            );
        }
    }

    public function getMenu(): array|false
    {
        return $this->db->query("SELECT * FROM menu WHERE status = :status", [':status' => 1])->fetchAll();
    }

    public function getCategories(): array|false
    {
        $categories = $this->db->query("SELECT * FROM categories WHERE status = :status", [':status' => 1])->fetchAll();
        if ($categories) {
            foreach ($categories as $k => &$v) {
                $v->slug = slugify($v->name);
            }
        }
        return $categories;
    }

    public function isAdmin(string $model): bool
    {
        $exists = $this->db->query(
            "SELECT page_types.code FROM pages
            LEFT JOIN page_types ON pages.page_type_id = page_types.id 
            WHERE pages.slug = :slug",
            [':slug' => slugify($model)]
        )->fetch();
        if (is_object($exists) && $exists->code === 'GENERIC_CONTROL_PANEL') {
            return true;
        }
        return false;
    }

    public function doLogin($post): bool
    {

        $exists =
            $this->db->query(
                "SELECT email, username, password FROM users WHERE email = :email AND status = :status",
                [
                    ':email' => $post['email'],
                    ':status' => 1
                ]
            )->fetch();
        if ($exists && is_object($exists)) {
            if (password_verify($post['password'], $exists->password)) {
                unset($exists->password);
                $_SESSION['user'] = $exists;
                return true;
            }
        }
        return false;
    }

    public function getPosts(): array|false
    {
        return $this->db->query("SELECT * FROM posts WHERE status = :status", [':status' => 1])->fetchAll();
    }
}
