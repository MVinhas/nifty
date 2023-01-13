<?php

namespace Nifty\Models;

use Nifty\Db;

class Post
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function delete(array $keys, array $values): bool
    {
        if ($this->db->delete('posts', $keys, $values)) {
            return true;
        }
        return false;
    }

    public function upsert(array $_post_keys, array $_post_values)
    {
        if ($this->db->upsert('posts', $_post_keys, $_post_values)) {
            return true;
        }
        return false;
    }

    public function get(int $id): object|false
    {
        return $this->db->select(
            ['*'],
            'posts',
            ['status = :status', 'AND id = :id'],
            [1, $id]
        )->{0} ?? false;
    }
}