<?php

namespace Nifty\Controllers;

use Nifty\Models\Category;
use Nifty\Models\Site;
use Nifty\Utils;

class CategoriesController extends Controller
{
    protected Utils $utils;
    protected Site $site;
    protected Category $category;

    public function __construct()
    {
        $this->category = new Category();
        $this->site = new Site();
        $this->utils = new Utils();
    }

    public function index(): bool
    {
        return $this->view(
            (object)[
                'categories' => $this->site->getCategories()
            ],
            'admin/categories',
            'index'
        );
    }

    public function new(): bool
    {
        return $this->view(
            null,
            'admin/categories',
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
            (object)['category' => $this->category->get($id)],
            'admin/categories',
            'edit'
        );
    }

    public function delete(int $id): bool
    {
        if (
            (!isset($id) || !is_int($id) || $id < 1)
        ) {
            return false;
        }
        $array = [
            'id' => $id
        ];
        if (!$this->category->delete(
            $this->utils->arrayKeysToQueryFields($array),
            $this->utils->arrayValuesToQueryParams($array)
        )) {
            return false;
        }
        return $this->index();
    }

    public function submit(): bool
    {
        $_post = $this->utils->_postSanitized();
        if (!$_post['csrf'] || $_post['csrf'] !== $_SESSION['csrf']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        }
        unset($_post['csrf']);
        if (!$this->category->upsert(
            $this->utils->arrayKeysToQueryFields($_post),
            $this->utils->arrayValuesToQueryParams($_post)
        )) {
            return false;
        }
        return $this->index();
    }
}