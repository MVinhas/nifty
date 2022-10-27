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
        return $this->view($data);
    }

    public function getMainPost()
    {
        return $this->home->getMainPost();
    }
}