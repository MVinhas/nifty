<?php

namespace Nifty\Controllers;

use Nifty\Models\Admin;
use Nifty\Models\Site;

class AdminController extends Controller
{
    protected $admin, $site;

    public function __construct()
    {
        $this->admin = new Admin();
        $this->site = new Site();
    }

    public function index()
    {
        $visits = $this->admin->getVisits();
        $data = [];
        $data['sessions']['today'] = $data['sessions']['week'] = 0;
        $data['sessions']['alltime'] = count((array)$visits);
        foreach ($visits as $visit) {
            if (
                $visit->date >= date('Y-m-d 00:00:00')
                &&
                $visit->date < date('Y-m-d 00:00:00', strtotime('+1 day'))
            ) {
                $data['sessions']['today'] += 1;
            }
            if ($visit->date >= date('Y-m-d 00:00:00', strtotime('-7 days'))) {
                $data['sessions']['week'] += 1;
            }
        }
        return $this->view((object)$data);
    }

    public function signOut()
    {
        unset($_SESSION['user']);
        session_write_close();
        header('Location: /');
        exit;
    }

    public function posts(string $action = null, ?int $id = null): mixed
    {
        if (!$action) {
            return $this->view(
                (object)[
                    'posts' => $this->site->getPosts()
                ],
                'admin/posts',
                'index'
            );
        }
        if (
            ((!isset($id) || !is_int($id) || $id < 1) && $action != 'new')
        ) {
            return false;
        }
        switch ($action) {
            case 'new':
                return $this->view(
                    (object)[
                        'categories' => $this->site->getCategories()
                    ],
                    'admin/posts',
                    'new'
                );
            case 'edit':
                return $this->view(
                    (object)[
                        'post' => $this->site->getPost($id),
                        'categories' => $this->site->getCategories()
                    ],
                    'admin/posts',
                    'edit'
                );
            case 'delete':
                $array = [
                    'id' => $id
                ];
                if (!$this->site->deletePost($this->getKeys($array), $this->getValues($array))) {
                    return false;
                }
                return $this->posts();
            case 'submit':
                if (!$this->site->upsertPost($this->getKeys($_POST), $this->getValues($_POST))) {
                    return false;
                }
                return $this->posts();
            default:
                return false;
        }
    }

    public function categories(string $action = null, ?int $id = null): mixed
    {
        if (!$action) {
            return $this->view(
                (object)[
                    'categories' => $this->site->getCategories()
                ],
                'admin/categories',
                'index'
            );
        }
        if (
            ((!isset($id) || !is_int($id) || $id < 1) && $action != 'new')
        ) {
            return false;
        }
        switch ($action) {
            case 'new':
                return $this->view(
                    null,
                    'admin/categories',
                    'new'
                );
            case 'edit':
                return $this->view(
                    (object)['category' => $this->site->getCategory($id)],
                    'admin/categories',
                    'edit'
                );
            case 'delete':
                $array = [
                    'id' => $id
                ];
                if (!$this->site->deleteCategory($this->getKeys($array), $this->getValues($array))) {
                    return false;
                }
                return $this->categories();
            case 'submit':
                if (!$this->site->upsertCategory($this->getKeys($_POST), $this->getValues($_POST))) {
                    return false;
                }
                return $this->categories();
            default:
                return false;
        }
    }

    private function getKeys(array|null $array)
    {
        $keys  = [];
        foreach ($array as $key => $value) {
            array_push($keys, "$key = :".$key);
        }
        return [implode(',', $keys)];

    }

    private function getValues(array|null $array)
    {
        $values = [];
        foreach ($array as $key => &$value) {
            $value = [':'.$key => $value];
            $values = array_merge($values, $value);
        }
        return $values;
    }
}