<?php

namespace Nifty\Models;

class Post extends Model
{
    public function get(string $slug): object|false
    {
        return $this->db->query(
            "SELECT posts.slug as slug, posts.title as title, posts.date as date, users.username as author, posts.content as content
            FROM posts
            LEFT JOIN users
            ON posts.author_id = users.id
            WHERE posts.slug = :slug AND posts.status = :status LIMIT 1",
            [
                ':slug' => $slug,
                ':status' => 1
            ]
        )->fetch();
    }
}