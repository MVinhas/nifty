<?php

namespace Nifty\Controllers;

use Nifty\Models\Post;

class PostController extends Controller
{
    private Post $post;

    public function __construct()
    {
        $this->post = new Post();
    }

    public function index(string $slug): bool
    {
        return $this->view($this->post->get($slug));
    }
}