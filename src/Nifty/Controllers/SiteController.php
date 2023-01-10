<?php

namespace Nifty\Controllers;

use Nifty\Models\Site;
use Nifty\Route;

class SiteController extends Controller
{
    protected $site;
    protected $route;

    public function __construct()
    {
        $this->site = new Site();
        $this->route = new Route();
    }

    public function head()
    {
        return $this->view();
    }

    public function header()
    {
        $data = (object)[];
        $data->menu = $this->site->getMenu();
        $data->categories = $this->site->getCategories();
        if (!$this->isAdmin()) {
            return $this->view($data);
        }
    }

    public function footer()
    {
        if (!$this->isAdmin()) {
            return $this->view();
        }
    }

    private function isAdmin()
    {
        $currentModel = $this->route->getURI()->model;
        return $this->site->isAdmin(strtolower($currentModel));
    }

    public function login(bool|null $errors = false)
    {
        return $this->view((object)['error' => $errors]);
    }

    public function doLogin()
    {
        if ($this->site->doLogin(
            filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        )) {
            header('Location: /');
            exit;
        } else {
            return $this->login(true);
        }
    }
}
