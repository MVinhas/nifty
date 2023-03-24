<?php

namespace Nifty\Models;

class Post
{
    public function __construct()
    {
        parent::__construct();
    }

    public function delete(string $keys, array $values): bool
    {
        if ($this->db->query("DELETE FROM posts WHERE $keys", $values)) {
            return true;
        }
        return false;
    }

    public function upsert(string $_post_keys, array $_post_values): bool
    {
        if ($this->db->query("INSERT INTO posts SET $_post_keys ON DUPLICATE KEY UPDATE $_post_keys", $_post_values)) {
            return true;
        }
        return false;
    }

    public function get(int $id): object|false
    {
        return $this->db->query(
            "SELECT * FROM posts WHERE status = :status AND id = :id",
            [
                ':status' => 1,
                ':id' => $id
            ]
        )->fetch();
    }
}