<?php

namespace Nifty\Controllers;

use Nifty\Models\Post;

class CategoryController extends Controller
{
    private Post $post;

    public function __construct()
    {
        $this->post = new Post();
    }

    public function index(string $slug): bool
    {
        $data = (object)['posts' => $this->post->getPostsByCategory($slug)];
        return $this->view($data);
    }
}