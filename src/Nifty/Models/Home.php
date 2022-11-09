<?php

namespace Nifty\Models;

use Nifty\Db;
use phpDocumentor\Reflection\PseudoTypes\False_;

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
        );
    }

    public function getOtherFeaturedPosts(): object|false
    {
        return $this->db
        ->select(
            [
                'posts.id,
                categories.name as category_name,
                posts.title,
                posts.slug,
                posts.date,
                posts.excerpt'
            ],
            'posts LEFT JOIN categories ON posts.category_id = categories.id',
            ['posts.status = :status'],
            [1],
            'ORDER BY posts.featured DESC, posts.id DESC LIMIT 2 OFFSET 1'
        );
    }

    public function getAboutContent(): object|false
    {
        return $this->db
        ->select(
            ['pages.content as content'],
            'pages LEFT JOIN page_types ON pages.page_type_id = page_types.id',
            ['pages.status = :status', 'AND page_types.code = :code'],
            [1, 'ABOUT'],
            'ORDER BY pages.id DESC LIMIT 1'
        )->{0};
    }

    public function getSocialNetworks(): object|false
    {
        return $this->db
        ->select(
            [
                'CONCAT(social_networks.domain, social_accounts.username) as url,
                social_networks.name as name'
            ],
            'social_accounts LEFT JOIN social_networks
            ON social_accounts.social_id = social_networks.id',
            ['social_accounts.status = :status',
            'AND social_networks.status = :status'],
            [1, 1]
        );

    }

    public function getNormalPosts(int $page_offset = 0): object|false
    {
        $normal_posts = $this->db
        ->select(
            [
                'posts.id,
                categories.name as category_name,
                posts.title,
                posts.slug,
                posts.date,
                posts.excerpt,
                users.username as author'
            ],
            'posts LEFT JOIN categories ON posts.category_id = categories.id
            LEFT JOIN users on posts.author_id = users.id',
            ['posts.status = :status', 'AND posts.featured = :featured'],
            [1, 0],
            'ORDER BY posts.id DESC'
        );

        $featured = (object)array_merge(
            (array)$this->getMainPost(),
            (array)$this->getOtherFeaturedPosts()
        );
        foreach ($featured as $featured_value) {
            foreach ($normal_posts as $key => $unique_value) {
                if ($unique_value->id === $featured_value->id) {
                    unset($normal_posts->{$key});
                }
            }
        }
        return
            (object)array_slice(
                (array)$normal_posts,
                $page_offset*getenv('POSTS_PER_PAGE'),
                getenv('POSTS_PER_PAGE'),
                true
            );
    }

    public function getArchive(): object|false
    {
        return $this->db
        ->select(
            [
                'COUNT(*) AS total,
                DATE_FORMAT(date, "%M %Y") AS date,
                DATE_FORMAT(date, "%m") as month,
                DATE_FORMAT(date, "%Y") as year'
            ],
            'posts',
            ['status = :status'],
            [1],
            'GROUP BY DATE_FORMAT(date, "%M %Y"), DATE_FORMAT(date, "%m"), DATE_FORMAT(date, "%Y")
            ORDER BY year, month ASC'
        );
    }
}
