<?php

namespace Nifty\Controllers;

use Nifty\Models\Site;
use Nifty\Route;
use Nifty\Utils;

class SiteController extends Controller
{
    protected $site, $route, $utils;

    public function __construct()
    {
        $this->site = new Site();
        $this->route = new Route();
        $this->utils = new Utils();
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
        $_post = $this->utils->_postSanitized();
        if (!$_post['csrf'] || $_post['csrf'] !== $_SESSION['csrf']) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
            exit;
        }
        unset($_post['csrf']);
        if ($this->site->doLogin(
            $_post
        )) {
            header('Location: /');
            exit;
        } else {
            return $this->login(true);
        }
    }
}
