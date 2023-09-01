<?php

namespace Nifty\Controllers;

use Nifty\Models\Home;
use Nifty\Models\Site;

class HomeController extends Controller
{
    protected Home $home;

    public function __construct()
    {
        $this->home = new Home();
    }

    public function index(): bool
    {
        $data = (object)[
            'posts' => (new Site())->getPosts(),
            'main_post' => $this->getMainPost(),
            'other_featured_posts' => $this->getOtherFeaturedPosts(),
            'normal_posts' => $this->getNormalPosts($this->getPage()),
            'previous_page' => $this->getPreviousPage(),
            'next_page' => $this->getNextPage()
        ];
        $data->last_key = (string)array_key_last((array)$data->posts);

        return $this->view($data);
    }

    public function getMainPost(): object|bool
    {
        return $this->home->getMainPost();
    }

    public function getOtherFeaturedPosts(): bool|array
    {
        return $this->home->getOtherFeaturedPosts();
    }

    public function getNormalPosts(int $page_offset = 0): bool|array
    {
        return $this->home->getNormalPosts($page_offset);
    }

    public function getPage(): int
    {
        if (!array_key_exists('page', $_GET)) {
            return 0;
        }
        return (int)$_GET['page'];
    }

    public function getAboutContent(): object|bool
    {
        return $this->home->getAboutContent();
    }

    public function getSocialNetworks(): bool|array
    {
        return $this->home->getSocialNetworks();
    }

    public function getPreviousPage(): int
    {
        return $this->getPage() - 1;
    }

    public function getNextPage(): int
    {
        return $this->getPage() + 1;
    }

    public function getArchive(): bool|array
    {
        return $this->home->getArchive();
    }
}