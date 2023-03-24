<?php

namespace Nifty\Controllers;

use Nifty\Models\Post;
use Nifty\Models\Site;
use Nifty\Utils;

class PostsController extends Controller
{
    protected Utils $utils;
    protected Site $site;
    protected Post $post;

    public function __construct()
    {
        $this->post = new Post();
        $this->site = new Site();
        $this->utils = new Utils();
    }

    public function new(): bool
    {
        return $this->view(
            (object)[
                'categories' => $this->site->getCategories()
            ],
            'admin/posts',
            'new'
        );
    }

    public function edit(int $id): bool
    {
        if (
            (!isset($id) || !is_int($id) || $id < 1)
        ) {
            return false;
        }

        return $this->view(
            (object)[
                'post' => $this->post->get($id),
                'categories' => $this->site->getCategories()
            ],
            'admin/posts',
            'edit'
        );
    }

    public function delete(int $id): bool
    {
        if (
            (!isset($id) || $id < 1)
        ) {
            return false;
        }

        $array = [
            'id' => $id
        ];
        if (!$this->post->delete(
            $this->utils->arrayKeysToQueryFields($array),
            $this->utils->arrayValuesToQueryParams($array)
        )) {
            return false;
        }
        return $this->index();
    }

    public function index(): bool
    {
        return $this->view(
            (object)[
                'posts' => $this->site->getPosts()
            ],
            'admin/posts',
            'index'
        );
    }

    public function submit()
    {
        $_post = $this->utils->_postSanitized();
        if (!$_post['csrf'] || $_post['csrf'] !== $_SESSION['csrf']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        }
        unset($_post['csrf']);
        if (!$this->post->upsert(
            $this->utils->arrayKeysToQueryFields($_post),
            $this->utils->arrayValuesToQueryParams($_post)
        )) {
            return false;
        }
        return $this->index();
    }
}