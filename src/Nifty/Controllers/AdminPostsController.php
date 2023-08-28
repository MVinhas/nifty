<?php

namespace Nifty\Controllers;

use Nifty\Models\AdminPost;
use Nifty\Models\Site;

class AdminPostsController extends Controller
{
    protected Site $site;
    protected AdminPost $post;

    public function __construct()
    {
        $this->post = new AdminPost();
        $this->site = new Site();
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
            (!isset($id) || $id < 1)
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
            arrayKeysToQueryFields($array),
            arrayValuesToQueryParams($array)
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
        $_post = _postSanitized();
        if (!$_post['csrf'] || $_post['csrf'] !== $_SESSION['csrf']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        }
        unset($_post['csrf']);
        if (!$this->post->upsert(
            arrayKeysToQueryFields($_post),
            arrayValuesToQueryParams($_post)
        )) {
            return false;
        }
        return $this->index();
    }
}