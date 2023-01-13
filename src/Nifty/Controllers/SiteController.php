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
        if (!$this->site->isAdmin($this->route->getURI()->model)) {
            return $this->view($data);
        }
    }

    public function footer()
    {
        if (!$this->site->isAdmin($this->route->getURI()->model)) {
            return $this->view();
        }
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
