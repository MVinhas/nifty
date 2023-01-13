<?php

namespace Nifty\Controllers;

use Nifty\Models\Category;
use Nifty\Models\Site;
use Nifty\Utils;

class CategoriesController extends Controller
{
    protected $category, $site, $utils;

    public function __construct()
    {
        $this->category = new Category();
        $this->site = new Site();
        $this->utils = new Utils();
    }

    public function index()
    {
        return $this->view(
            (object)[
                'categories' => $this->site->getCategories()
            ],
            'admin/categories',
            'index'
        );
    }

    public function new()
    {
        return $this->view(
            null,
            'admin/categories',
            'new'
        );
    }

    public function edit(int $id)
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

    public function delete(int $id)
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

    public function submit()
    {
        if (!$this->category->upsert(
            $this->utils->arrayKeysToQueryFields($this->utils->_postSanitized()),
            $this->utils->arrayValuesToQueryParams($this->utils->_postSanitized())
        )) {
            return false;
        }
        return $this->index();
    }
}