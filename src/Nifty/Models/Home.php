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
            ['CONCAT(social_networks.domain, social_accounts.username) as url, social_networks.name as name'],
            'social_accounts LEFT JOIN social_networks ON social_accounts.social_id = social_networks.id',
            ['social_accounts.status = :status', 'AND social_networks.status = :status'],
            [1, 1]
        );

    }
}
