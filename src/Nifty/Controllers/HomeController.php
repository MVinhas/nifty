<?php

namespace Nifty\Controllers;

use Nifty\Models\Home;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->home = new Home();
    }

    public function index()
    {
        $data = (object)[];
        $data->posts = $this->home->getPosts();
        $data->last_key = (string)array_key_last((array)$data->posts);
        $data->main_post = $this->getMainPost();
        $data->other_featured_posts = $this->getOtherFeaturedPosts();
        $data->about = $this->getAboutContent();
        $data->social_networks = $this->getSocialNetworks();
        return $this->view($data);
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
}