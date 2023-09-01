<?php

namespace Nifty\Models\backoffice;

use Nifty\Models\Model;

class Category extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get(int $id): object|false
    {
        return $this->db->query(
            "SELECT * FROM categories WHERE status = :status AND id = :id",
            [':status' => 1, ':id' => $id]
        )->fetch();
    }

    public function delete(string $keys, array $values): bool
    {
        if ($this->db->query("DELETE FROM categories WHERE $keys", $values)) {
            return true;
        }
        return false;
    }

    public function upsert(string $_post_keys, array $_post_values): bool
    {
        if ($this->db->query(
            "INSERT INTO categories SET $_post_keys ON DUPLICATE KEY UPDATE $_post_keys",
            $_post_values
        )) {
            return true;
        }
        return false;
    }
}