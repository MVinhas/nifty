<?php

namespace Nifty\Models;

use Nifty\Db;

class Home
{
    protected $db;
    public function __construct()
    {
        $this->db = new Db();
    }

    public function getPosts(): object|false
    {
        return $this->db->select(['*'], 'posts', ['status = :status'], [1]);
    }

    public function getMainPost(): object|false
    {
        return $this->db
        ->select(
            ['*'],
            'posts',
            ['status = :status'],
            [1],
            'ORDER BY featured DESC, id DESC LIMIT 1'
        )->{0};
    }

    public function getOtherFeaturedPosts(): object|false
    {
        return $this->db
        ->select(
            ['categories.name as category_name, posts.title, posts.slug, posts.date, posts.excerpt'],
            'posts LEFT JOIN categories ON posts.category_id = categories.id',
            ['posts.status = :status'],
            [1],
            'ORDER BY posts.featured DESC, posts.id DESC LIMIT 2 OFFSET 1'
        );
    }
}
