<?php

namespace Nifty\Controllers;

use Nifty\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        return $this->view();
    }
}