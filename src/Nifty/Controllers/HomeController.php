<?php

namespace Nifty\Controllers;

use Nifty\Models\Home;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view();
    }
}
