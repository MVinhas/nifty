<?php

namespace Nifty\Controllers;

use Nifty\Models\Site;

class SiteController extends Controller
{
    public function head()
    {
        return $this->view();
    }

    public function header()
    {
        $data = (object)[];
        $data->menu = (new Site())->getMenu();
        return $this->view($data);
    }

    public function footer()
    {
        return $this->view();
    }
}
