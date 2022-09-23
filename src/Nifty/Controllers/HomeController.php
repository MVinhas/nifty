<?php

namespace Nifty\Controllers;

use Nifty\Models\Home;

class HomeController extends Controller
{
    public function index()
    {
        $data = (object)[];
        $data->posts = (new Home())->getPosts();
        $data->last_key = (string)array_key_last((array)$data->posts);
        return $this->view($data);
    }
}