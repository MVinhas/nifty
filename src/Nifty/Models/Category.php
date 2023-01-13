<?php

namespace Nifty\Models;

use Nifty\Db;

class Category
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function get(int $id): object|false
    {
        return $this->db->select(
            ['*'],
            'categories',
            ['status = :status', 'AND id = :id'],
            [1, $id]
        )->{0} ?? false;
    }

    public function delete(array $keys, array $values): bool
    {
        if ($this->db->delete('categories', $keys, $values)) {
            return true;
        }
        return false;
    }

    public function upsert(array $_post_keys, array $_post_values): bool
    {
        if ($this->db->upsert('categories', $_post_keys, $_post_values)) {
            return true;
        }
        return false;
    }
}