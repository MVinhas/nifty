<?php

namespace Nifty\Models;

class Home extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMainPost(): object|false
    {
        return $this->db->query(
            "SELECT * FROM posts WHERE status = :status ORDER BY featured DESC, id DESC LIMIT 1",
            [':status' => 1]
        )->fetch();
    }

    public function getOtherFeaturedPosts(): array|false
    {
        return $this->db->query(
            "SELECT posts.id, categories.name as category_name, posts.title, posts.slug, posts.date, posts.excerpt 
            FROM posts 
            LEFT JOIN categories ON posts.category_id = categories.id AND posts.status = :status 
            ORDER BY posts.featured DESC, posts.id DESC 
            LIMIT 2 OFFSET 1",
            [':status' => 1]
        )->fetchAll();
    }

    public function getAboutContent(): object|false
    {
        return $this->db->query(
            "SELECT pages.content AS content
            FROM pages LEFT JOIN page_types ON pages.page_type_id = page_types.id
            WHERE pages.status = :status AND page_types.code = :code LIMIT 1",
            [
                ':status' => 1,
                ':code' => 'ABOUT'
            ]
        )->fetch();
    }

    public function getSocialNetworks(): array|false
    {
        return $this->db->query(
            "SELECT CONCAT(social_networks.domain, social_accounts.username) as url, social_networks.name as name
            FROM social_accounts LEFT JOIN social_networks ON social_accounts.social_id = social_networks.id
            WHERE social_accounts.status = :status AND social_networks.status = :status",
            [':status' => 1, ':status' => 1]
        )->fetchAll();
    }

    public function getNormalPosts(int $page_offset = 0): array|false
    {
        $normal_posts = $this->db
            ->query(
                "SELECT posts.id,
                categories.name as category_name,
                posts.title,
                posts.slug,
                posts.date,
                posts.excerpt,
                users.username as author
                FROM posts 
                LEFT JOIN categories ON posts.category_id = categories.id
                LEFT JOIN users ON users.id = posts.author_id
                WHERE posts.status = :status AND posts.featured = :featured",
                [
                    ':status' => 1,
                    ':featured' => 0
                ]
            )->fetchAll();

        $featured = $this->getOtherFeaturedPosts();
        if ($featured) {
            $featured[] = $this->getMainPost();
        }
        foreach ($featured as $featured_value) {
            foreach ($normal_posts as $key => $unique_value) {
                if ($unique_value->id === $featured_value->id) {
                    unset($normal_posts->{$key});
                }
            }
        }
        return
            array_slice(
                (array)$normal_posts,
                $page_offset * getenv('POSTS_PER_PAGE'),
                getenv('POSTS_PER_PAGE'),
                true
            );
    }

    public function getArchive(): array|false
    {
        return $this->db->query(
            'SELECT COUNT(*) AS total,
            DATE_FORMAT(date, "%M %Y") AS date,
            DATE_FORMAT(date, "%m") AS month,
            DATE_FORMAT(date, "%Y") AS year
            FROM posts
            WHERE status = :status
            GROUP BY DATE_FORMAT(date, "%M %Y"), DATE_FORMAT(date, "%m"), DATE_FORMAT(date, "%Y")
            ORDER BY year, month ASC',
            [':status' => 1]
        )->fetchAll();
    }
}
