<?php

namespace Nifty\Controllers;

use Nifty\Models\Home;
use Nifty\Models\Site;

class HomeController extends Controller
{
    protected $home;

    public function __construct()
    {
        $this->home = new Home();
    }

    public function index()
    {
        $data = (object)[
            'posts' => (new Site())->getPosts(),
            'main_post' => $this->getMainPost(),
            'other_featured_posts' => $this->getOtherFeaturedPosts(),
            'normal_posts' => $this->getNormalPosts($this->sanitizePage()),
            'about' => $this->getAboutContent(),
            'social_networks' => $this->getSocialNetworks(),
            'previous_page' => $this->getPreviousPage(),
            'next_page' => $this->getNextPage(),
            'archive' => $this->getArchive()
        ];
        $data->last_key = (string)array_key_last((array)$data->posts);

        return $this->view($data);
    }

    public function sanitizePage(): int
    {
        if (!isset($_GET['page'])) {
            return 0;
        }
        return (int)$_GET['page'];
    }

    public function getMainPost()
    {
        return $this->home->getMainPost();
    }

    public function getOtherFeaturedPosts()
    {
        return $this->home->getOtherFeaturedPosts();
    }

    public function getAboutContent()
    {
        return $this->home->getAboutContent();
    }

    public function getSocialNetworks()
    {
        return $this->home->getSocialNetworks();
    }

    public function getNormalPosts(int $page_offset = 0)
    {
        return $this->home->getNormalPosts($page_offset);
    }

    public function getPreviousPage(): int
    {
        return $this->sanitizePage() - 1;
    }

    public function getNextPage(): int
    {
        return $this->sanitizePage() + 1;
    }

    public function getArchive()
    {
        return $this->home->getArchive();
    }
}