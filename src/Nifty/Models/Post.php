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

    public function getPostsByCategory(string $categorySlug): array|false
    {
        return $this->db->query(
            "SELECT posts.slug as slug, posts.title as title, posts.date as date, users.username as author, posts.excerpt as excerpt, categories.slug as category_slug
            FROM posts
            LEFT JOIN users
            ON posts.author_id = users.id
            LEFT JOIN categories
            ON categories.id = posts.category_id
            WHERE posts.status = :status AND categories.slug = :category_slug",
            [
                ':status' => 1,
                ':category_slug' => $categorySlug
            ]
        )->fetchAll();
    }
}