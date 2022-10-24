<?php

namespace Nifty\Controllers;

use Nifty\Models\Site;
use Nifty\Route;

class SiteController extends Controller
{
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
}
